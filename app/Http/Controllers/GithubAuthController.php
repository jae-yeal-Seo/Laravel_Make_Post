<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GithubAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }
    //생성자는 guest인지 확인한다(로그인하지 않은 사용자여야 하니까)
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }
    //깃허브에 보낼때
    public function callback()
    {
        $user = Socialite::driver('github')->user();
        //유저정보를 github로부터 받아온다.

        //DB에 사용자 정보를 저장한다.
        //이미 이 사용자 정보가 DB에 저장되어 있다면 
        //저장할 필요가 없다. 
        $user = User::firstOrCreate(
            [
                'email' => $user->getEmail()
            ],
            //email이 검색조건
            [
                'password' => Hash::make(Str::random(24)),
                'name' => $user->getName()
            ]
        );
        //로그인 처리
        Auth::login($user);
        //로그인 한 걸로 처리해라.
        //내가 추가가 안된 이유는 깃허브 이메일과 내가 만든 이메일이 같기 때문이다. 


        return redirect()->intended('/dashboard');
        //원래 요청했던 페이지로 가기, 없으면 default로 dashboard로 이동
    }
    //깃허브에서 맞다고 받음을 dd($user)로 확인
}
//로그인이 안 되어있을 때 사용가능함
