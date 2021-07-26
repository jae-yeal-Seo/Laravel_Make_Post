<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // protected $table = 'my_posts';

    use HasFactory;

    public function imagePath()
    {
        // $path = '/storage/images';
        $path = env('IMAGE_PATH', '/storage/images/');
        $imageFile = $this->image ?? 'no_image_available.png';
        return $path . $imageFile;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //연결될 모델을 소문자로 씀. 관례 : 모델은 단수, 테이블은 복수
    //내부적으로 조인 해줌

    public function viewers()
    {
        // return $this->belongsTo(User::class, 'post_user', 'post_id', 'user_id','id','id','users');
        return $this->belongsToMany(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
