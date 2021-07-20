<x-app-layout>
    <x-slot name="header">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </x-slot>
    <div class = "py-13">
    <div class="container m-5">
         <div class="form-group">
             <label for="title">Title</label>
             <input type="text" readonly name = "title" class="form-control" id="title" autocomplete="off" value="{{ $post->title }}">
         </div>
 
         <div class="form-group">
                 <label for="content">Content</label>
                 <div name = "content"
                 id="content"  readonly>{!! $post->content !!}</div>
         </div>
 
         <div class="form-group">
                 <label for="imageFile" style>Post Image</label>
                <div>
                 {{-- <img class = "img-thumbnail" width="20%" height="20%" src="/storage/images/{{ $post->image ?? 'no_image_available.png'}}"/> --}}
                 <img class = "object-scale-down h-50 w-60"  src="{{ $post->imagePath() }}"/>
                 {{-- imagePath는 Post.php에 가보면 알 수 있다. --}}
                </div>
                {{-- layout/app.php를 보면 tailwinds를 사용하고 있음을 알 수 있다. 따라서 tailwinds문법을 사용해야 한다. --}}
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
                 value="{{ $post->user->name }}">
              </div>
              {{-- $post->user가 조인. --}}
              {{-- user()이면 모든 애들다나옴 }}
              {{-- user면 column설정가능 }}
 
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
              {{-- @endauth --}}
        </div>
    </div>
</x-app-layout>
   


