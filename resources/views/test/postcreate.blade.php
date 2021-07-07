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
    <div class="container">
        <form action="/posts/store" method="post" enctype="multipart/form-data"> 
            {{-- enctype="multipart/form-data 이게 있어야 사진을 서버로 보낼 수 있음 --}}
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name = "title" class="form-control" id="title" autocomplete="off" value="{{ old('title') }}">
                @error('title')
          <div>{{ $message }}</div>
          @enderror
            </div>


            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" 
                    id="content" name = "content" >{{ old('content') }}</textarea>
          @error('content')
          <div>{{ $message }}</div>
          @enderror
            </div>


            <div class="form-group">
                <label for="file">File</label>
              <input type="file" id="file" name = "imageFile">
          @error('imageFile')
          <div>{{ $message }}</div>
          @enderror
            </div>
            <button type="submit" class = "btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>