<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth'])->except(['index', 'show']);
    }

    //생성자. 통합 미들웨어 만들기. 이 클래스사용하는 애들은 다 적용이 됨. 인덱스, 쇼 메소드는 제외하고

    public function show(Request $request, $id)
    {
        $page = $request->page;
        $post = Post::find($id);
        // $post->count++;
        //이렇게 count값을 올리면 된다.(조회수 증가시킴)-->근데 이건 한 유저가 계속누르면 계속올라가서 
        // 별로 필요 없는 코드임.
        // $post->save();
        // DB에 반영

        /*
        이 글을 조회한 사용자들 중에, 현재 
        로그인한 사용자가 포함되어 있는지를 체크하고 
        포함되어 있지 않으면 추가.
        포함되어 있으면 다음 단계로 넘어감.
        */
        if (Auth::user() != null && !$post->viewers->contains(Auth::user())) {
            $post->viewers()->attach(Auth::user()->id);
            //해당 id에 해당하는 투플을 피벗테이블에 넣어줌
        }
        //"로그인 돼 있는 상태 + 아직 안들어간 게시글 일 때" 조회수 +1함.
        //앞에 조건이 있어야 없으면 로그인을 안 한 상태일 때 두번째 조건을 충족시켜 조회수 +1을 시킴. ( 로그인하지 않은 사용자는 조회수 참가 안 하기로 함. )
        $comments = Post::find($id)->comments()->latest()->get();


        //넣어야 될 경우

        return view('test.show', compact('post', 'page', 'comments'));
    }
    //몇번째 게시물인지, 몇번째 목록이였는지도 함께 받음

    public function postCreate(Request $request)
    {
        return view('test.postcreate');
    }

    public function postStore(Request $request)
    {
        // $request->input['title'];
        // $request->input['content'];
        //name값으로 전달됨
        // dd($request);
        $title = $request->title;
        $content = $request->content;
        //이렇게 꺼내도 됨. name으로 찾는거임. 파라미터. 전달값.

        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required',
            'imageFile' => 'image|max:2000'
        ]);
        //내가 원하는 형태로 데이터가 왔는지 확인
        //-->만족안하면 posts/create로 redirect시킴 (바로 전 요청으로 redirection시킴)
        //Request클래스 안에 있는 validate를 통해서 파라미터의 조건을 확인한다.
        //위와 같은 형식으로 설정하면 된다. 


        // dd($request);
        //-->419오류가 남. 이유 : 보안상의 문제 때문에. 사용자의 정보가 해커에게 날아갈 수 있음. 그래서 토큰이 있어야 알려줌. 


        //DB에 저장
        $post = new Post();
        //App/Models/Post안에 있다. 
        $post->title = $title;
        $post->content = $content;
        $post->user_id = Auth::user()->id;
        //지금 로그인한 사용자를 줌.
        //File처리 
        //내가 원하는 파일시스템 상의 위치에 원하는 이름으로
        //파일을 저장하고 
        if ($request->file('imageFile')) {
            $post->image = $this->uploadPostImage($request);
        }

        //$fileName = 'spaceship_시간~~.확장자
        // dd($fileName);


        //spaceship.jpg
        //-->spaceship_123sdfsdfsdf(unique name);
        // dd($name . 'extenstion:' . $extension);


        // $request->imageFile
        //그 파일이름을 column에 설정


        //Posts테이블의 column에 접근함.

        $post->save();
        return redirect('/posts/index');
        //결과 뷰를 반환
    }


    protected function uploadPostImage(Request $request)
    {
        $name = $request->file('imageFile')->getClientOriginalName();
        $extension = $request->file('imageFile')->extension();
        $nameWithoutExtension = Str::of($name)->basename('.' . $extension);
        $fileName = $nameWithoutExtension . '_' . time() . '.' . $extension;
        $request->file('imageFile')->storeAs('public/images', $fileName);
        return $fileName;
    }


    public function index()
    {
        // $posts = Post::orderBy('created_at', 'desc')->get();
        // $posts = Post::latest()->get();
        // return $posts;
        // dd($posts[0]->created_at);
        //dd만나면 그밑으로 안 감.
        $posts = Post::latest()->paginate(10);
        //한페이지에 10개씩만 줘
        return view('test.index', ['posts' => $posts, 'page' => $posts]);
    }


    public function edit(Request $request, Post $post)
    {
        //Post $post로 하면 
        // $post = Post::find($id);
        // $post = Post::where('id', $id)->get();
        //위와 같은 방법으로 primary키가 아닌 다른 방법으로 찾을 수도 있음
        // dd($post);
        //수정폼 생성
        return view('test.edit', ['post' => $post, 'page' => $request->page]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required',
            'imageFile' => 'image|max:2000'
        ]);
        //다시 수정한 애들도 검증을 해야 됨.
        $post = Post::find($id);
        $post->title = $request->title;
        $post->content = $request->content;
        //업데이트 한 사진,글도 띄우고 동시에 이전에 것도 삭제해야 됨.
        //게시글을 데이터베이스에서 수정. 변경할 내용도 받아야 됨. Request객체로 받으면 됨.
        //매개변수 순서 중요 $request가 $id앞에 와야됨.

        // if (auth()->user()->id == $post->user_id) {
        //     abort(403);
        // }

        if ($request->user()->cannot('update', $post)) {
            abort(403);
        }
        //Authorization. 즉 수정 권한이 있는지 검사 즉, 로그인한 사용자와 게시글의 작성자가 같은지 체크

        if ($request->file('imageFile')) {
            $imagePath = 'public/images/' . $post->image;
            Storage::delete($imagePath);
            //일단 파일 시스템에 있는 사진을 지움
            $post->image = $this->uploadPostImage($request);
        }
        $post->save();

        return redirect()->route('post.show', ['id' => $id, 'page' => $request->page]);
        //DB에 주고 요청 다시 하면 안 되니까(새로고침할 때) redirect를 쓴다.
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        //Authorization. 즉 삭제 권한이 있는지 검사 즉, 로그인한 사용자와 게시글의 작성자가 같은지 체크
        $page = $request->page;
        if ($request->user()->cannot('delete', $post)) {
            abort(403);
        }
        if ($post->image) {
            $imagePath = 'public/images/' . $post->image;
            Storage::delete($imagePath);
        }
        // 이미지 파일이 있었을 경우 파일 시스템에서도 없애야 됨.
        $post->delete();
        //DB에서 삭제. 
        return redirect()->route('posts.index', ['page' => $page]);
        //파일 시스템에서 이미지 파일 삭제(서버의 storage안에 사진 파일들)
        //게시글을 데이터베이스에서 삭제
    }
    public function myposts()
    {
        // $posts = auth() -> user()->posts()->paginate(2);
        $CURR = Auth::user()->id;
        $Myposts = Post::where('user_id', $CURR)->latest()->paginate(2);
        //latest는 정렬
        return view('test.myposts', ['posts' => $Myposts, 'page' => $Myposts, 'Myposts' => $Myposts]);
    }
}
