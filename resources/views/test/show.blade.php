<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container m-5">
       <div class = "m-5">
           <a href="{{ route('posts.index',['page'=>$page]) }}">목록보기</a>
       </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" readonly name = "title" class="form-control" id="title" autocomplete="off" value="{{ $post->title }}">
        </div>

        <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" 
                id="content" name = "content" readonly>{{ $post->content }}</textarea>
        </div>

        <div class="form-group">
                <label for="imageFile" style>Post Image</label>
               <div class="w-10" style="height:20">
                {{-- <img class = "img-thumbnail" width="20%" height="20%" src="/storage/images/{{ $post->image ?? 'no_image_available.png'}}"/> --}}
                <img class = "img-thumbnail" width="20%" height="20%" src="{{ $post->imagePath() }}"/>
                {{-- imagePath는 Post.php에 가보면 알 수 있다. --}}
               </div>
        </div>

            <div class="form-group">
                <label>등록일</label>
                <input type="text" readonly 
                class="form-control" 
                value="{{ $post->created_at->diffForHumans() }}">
             </div>

             <div class="form-group">
                <label>수정일</label>
                <input type="text" readonly 
                class="form-control" 
                value="{{ $post->updated_at }}">
             </div>

             <div class="form-group">
                <label>작성자</label>
                <input type="text" readonly 
                class="form-control" 
                value="{{ $post->user_id }}">
             </div>

             @auth
             {{-- @if(auth()->user()->id == $post->user_id) --}}
             @can('update',$post)
             {{-- 지금 로그인한 사용자의 user()객체를 찾음 그리고 $post의 user_id하고 같은지 확인 
                내가 만든거여야 수정삭제가 뜸--}}
             <div class = "flex">
                 <div>
                 <a class = "btn btn-warning"
                    href="{{ route('post.edit',['post'=>$post->id,'page'=>$page]) }}">수정</a>
                </div>
                <form action ="{{ route('post.delete',['id'=>$post->id,'page'=>$page]) }}" method="post">
                    @csrf
                    @method("delete")
                 <button type = "submit" class = "btn btn-danger">삭제</button>
                  {{-- location.href는 무조건 get방식 근데 삭제는 post로 해야. --}}
                </form>
             </div>
             @endcan
             {{-- @endif --}}
             @endauth
</body>
</html>