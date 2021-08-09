<x-app-layout>
    
    <x-slot name="header">
      <div class="h-14 flex flex-wrap content-start">
        <div>
      <h2 style="position:relative; top:14px"  class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('목록리스트') }}
      </h2>
    </div>
  
  <div>
  <form class="m-4 flex" action ="{{ route('post.title.find') }}" method="get">
            <input size=80 name="findtitle" style="position:relative; bottom:16px" class="rounded-l-lg p-4 border-t mr-0 border-b border-l text-gray-800 border-gray-200 bg-white" placeholder="찾을 게시글을 입력하세요"/>
          <button style="position:relative; bottom:16px"  class="px-8 rounded-r-lg bg-yellow-400  text-gray-800 font-bold p-4 uppercase border-yellow-500 border-t border-b border-r">찾기</button>
        </form>
      </div>
  
      <div>
        @auth
            <a style="position:relative; top:14px"  href="/posts/create" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">게시글 작성</a>
          
           @endauth
        </div>
  
    </div>
    </x-slot>
  @foreach($posts as $post)
  <a href="{{ route('post.show',['id'=>$post->id, 'page'=>$posts->currentPage()]) }}" class="list-group-item list-group-item-action flex-column align-items-start active">
  <div class = "list-group" style="background-color:ivory">
      <div class="min-w-screen p-2 min-h-full bg-gray-100 flex items-center justify-center bg-gray-100 font-sans ">
        <div class="container">
          <div class="card bg-white py-3 px-5 rounded-xl flex flex-col">
            
            <div class="title text-xl font-medium mb-3"> <h5 class="mb-1"> 제목 : {{ $post->title }}</h5></div>
            <div class="w-full">
        <small><span> {{ $post->created_at->diffForHumans() }}에 작성됨</span></small>
        <br>
        <small>{{ $post->viewers->count() }}
          {{ $post->viewers->count() > 0 ? Str::plural('view',$post->viewers->count()) : 'view' }}
         <hr></small>
          </div>
          </div>
        </div>
        </div>
      </div>
    </a>
  @endforeach
  
        <div>
          {{ $posts->links() }}
        </div>
      </div>
    </x-app-layout>
  