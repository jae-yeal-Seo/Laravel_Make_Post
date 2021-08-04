
<x-app-layout>
  {{-- layouts/app.blade.php를 사용한다. --}}
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('목록리스트') }}
    </h2>
</x-slot>
      

<div class = "list-group" style="background-color:ivory">
  @foreach($posts as $post)
  <a href="{{ route('post.show',['id'=>$post->id, 'page'=>$posts->currentPage()]) }}" class="list-group-item list-group-item-action flex-column align-items-start active">
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
</div>
{{-- <ul class="list-group mt-3">
        @foreach($posts as $post)
        <li class="list-group-item">
          <span>
          <a href="{{ route('post.show',['id'=>$post->id, 'page'=>$posts->currentPage()]) }}">
              Title : {{ $post->title }}
            </a>
          </span> --}}

          {{-- 이걸 누르면 상세보기로 되게끔 --}}
          {{-- dd($request)하면 많이 볼 수 있음 --}}
          {{-- currentPage는 배열에서 가져와야 --}}
          {{-- <div>
            {{ $post->content }}
          </div>
          <span>written on {{ $post->created_at }}</span> --}}


          {{-- <span>written on {{ $post->created_at->diffForHumans() }}</span>
          {{ $post->viewers->count() }}
           {{ $post->viewers->count() > 0 ? Str::plural('view',$post->viewers->count()) : 'view' }}
          <hr>
        </li>
        @endforeach
      </ul> --}}
      <div>
        {{ $posts->links() }}
      </div>
    </div>
  </x-app-layout>
  {{-- 왜 count에 ()붙지? column도 ()가 붙나? --}}
          {{-- !!이상한 점에 주목해야 한다. 거기에 답이 있다 !!--}}
          {{-- count는 column이 아니라 갯수를 세는 "메소드"이다.  --}}
          {{-- $post->viewers에 접근하는 것은 피벗테이블, 상대테이블 모두 접근할 수 있다. --}}
          {{-- -->이게 맞다. --}}
          {{-- php artisan tinker --> $post = Post::find(4) $post->viewers로 해보면 알 수 있다. --}}

          {{-- 1개면 view라고 하고 복수형이면 views(복수형)으로 만들어라. 0개일 때도 view가 됨.--}}
          {{-- 한 show 누르고 뒤로가기 누르면 안 올라갔다가 목록보기 할 때 한꺼번에 올라감 --}}
          {{-- 뒤로가기로 하는 건 그 이전의 목록을 보여주는 거임. 목록을 목록보기로 다시 
            요청하는 게 아니라 --}}