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
  <div class="container mx-4 mt-5">
    <div> <a href="{{ route('posts.index', ['page'=>$page]) }}">목록보기</a> </div><br>
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


              {{-- 여기부터 댓글 --}}
              <div class="bg-gray p-0 pb-0">
                <div class="max-w-7xl -mx-0 mt-10"> 
                  <div class="bg-white h-auto p-5 modal__content rounded p-0">
                    <div class="modal__header mb-4">
                      <div class="p-2 rounded-full bg-purple-lightest inline-block">
                        <i class="fas fa-comments text-2xl text-purple-dark"></i>
                      </div>
                    </div>
                    <div class="modal__body">
                      <p class="text-grey-darkest font-medium mb-1 text-base"> Leave a Comment</p>
                      <div class="mt-4 border border-grey w-10/12 border-1 rounded p-2 relative focus:border-red">

  <form action="{{ route('posts.comment.store',['id'=>$post->id]) }}" 
    method="post"  enctype="multipart/form-data"> 
    {{-- ???왜 아이디를 url에 보내는데 파라미터로 받지 않고 query로 받는가. --}}
                  @csrf
                        <div class="form-group">
                        <input type="text" name="content" class="pl-8 text-grey-dark 
                        font-light w-4/5 text-sm font-medium tracking-wide" placeholder="Type your commnet...">
                        @error('content')
                        <div>{{ $message }}</div>
                        @enderror
                        </div>

                        <button class="ml-2 bg-purple-500 text-white border-2 border-purple p-3 rounded text-sm font-semibold hover:bg-purple-dark hover:border-purple-dark">Submit Comment</button>
                      </form>
                      </div>
                      <div class="mt-6 border"></div>
                      <div class="flex relative mt-6">
                        <i class="fas fa-globe text-grey-dark"></i>
                        <div class=" ml-2 "> 
                        </div>
                        <i class="fas fa-toggle-on fa-2x ml-auto text-blue"></i>
                      </div>
                      <div class="flex relative mt-6">
                        <i class="fab fa-slack text-grey-dark"></i>
                        <div class=" ml-2 "> 
                        </div>
                        <i class="fas fa-toggle-on fa-2x ml-auto text-blue"></i>
                      </div>
                    </div>
                    <div class="modal__footer mt-6">
                    <div class="text-right">
                        {{-- <button class="bg-white border-2 p-3 rounded text-sm font-semibold hover:bg-grey-light">Cancel</button> --}}
                    </div>
                    </div>
                  </div>
                </div>
                </div>
              </form>
                 {{-- 여기까지 댓글입력 --}}
               
                 
                 @foreach($comments as $comment)
                 
                  <section class="rounded-b-lg  mt-4 h-15">
                    <div id="task-comments" class="pt-4">
                <div class="bg-white rounded-lg p-3 pr-1 flex flex-col justify-center items-center shadow-lg">
                <div class="flex flex-row justify-center mr-2">



                  <div class="flex space-x-4">
  
                  <div class="flex-1 mt-6">
                    <p style="font-size:15px; color:purple; font-family:'맑은 고딕'"><b>작성자 : {{ $comment->user->name }}</b></p>
                  </div>

                  <div class="flex-1">
                    <form action ="{{ route('post.comment.edit',['post'=>$post->id,'page'=>$page, 'commentid'=>$comment->id]) }}" method="post">
                      @csrf
                      <textarea name="editedcomment" style="width:600px" class="text-gray-600 text-lg text-center md:text-left resize-none " >{{ $comment->content }}</textarea>
                    </div>
                    
                    <div class = "flex-1">
                    @auth
                    @if(auth()->user()->id == $comment->user_id)
                    
                    <button class="bg-purple-400 .p-16 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-l rounded-r mb-3">
                      수정
                    </button>
                    </form>
                  
                    <form action ="{{ route('post.comment.delete',['post'=>$post->id,'page'=>$page, 'commentid'=>$comment->id]) }}" method="post">
                    @csrf
                    <div class = "mb-0">
                    <button class="bg-purple-400 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4  rounded-l rounded-r">
                      삭제
                    </button>
                    </div>
                    
                    @endif
                    @endauth
                    </form>

                  </div>

                  

                  <div class="flex-1 w-48 ">
                    <p width="100%" class="text-gray-600 text-xs mt-7">{{ $comment->created_at->diffForHumans() }}에 작성됨</p>
                  </div>


                </div>
                </div>
               </div>
              </div>
                </section>
                @endforeach


          </div>
        </div>
</x-app-layout>


