<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.4.1/dist/chart.min.js"></script>
</head>
<body>
    <canvas id="myChart" width="600" height="700"></canvas>
    <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($postusers as $postuser)
                "{{ $postuser->title }}",
                @endforeach
            ],
            datasets: [{
                label: "# of Views",
                data: [
                    @foreach($postusers as $postuser)
                    {{ $postuser->cnt }},
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
    <div class = "list-group" style="background-color:ivory; ">
        @foreach($postusers as $postuser)
        <a href="{{ route('post.show',['id'=>$postuser->post_id]) }}" class="list-group-item list-group-item-action flex-column align-items-start active">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"> 제목 : {{ $postuser->title }}</h5>
            <small><span> {{ \Carbon\Carbon::parse($postuser->created_at)->diffForHumans() }}에 작성됨</span></small>
            <br>
            <small>{{ $postuser->cnt }}
              {{ $postuser->cnt > 0 ? Str::plural('view',$postuser->cnt) : 'view' }}
             <hr></small>
          </div>
        </a>
        @endforeach
    </div>
</body>
</html>