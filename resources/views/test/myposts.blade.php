<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=<, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container m-5">
      <a href="{{ route('dashboard') }}">Dashboard</a>
      <h1>게시글 리스트</h1>
      @auth
      <a href="/posts/create" class="btn btn-primary">게시글 작성</a>
      {{-- 로그인 중에만 쓸 수 있는 기능이여야 함. 그래서 auth, endauth추가 --}}
      @endauth
      
      <ul class="list-group mt-3">
        @foreach($Myposts as $post)
        <li class="list-group-item">
          <span>
          <a href="{{ route('post.show',['id'=>$post->id, 'page'=>$posts->currentPage()]) }}">
              Title : {{ $post->title }}
            </a>
          </span>
          {{-- 이걸 누르면 상세보기로 되게끔 --}}
          {{-- dd($request)하면 많이 볼 수 있음 --}}
          {{-- currentPage는 배열에서 가져와야 --}}
          {{-- <div>
            {{ $post->content }}
          </div>
          <span>written on {{ $post->created_at }}</span> --}}
          <hr>
        </li>
        @endforeach
      </ul>
      <div class="mt-5">
        {{ $posts->links() }}
      </div>
    </div>
    </body>
    </html>