<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $users = null;
    protected $posts = null;

    public function __construct()
    {
        parent::__construct();
        $this->users = User::all();
        $this->posts = Post::all();
        //collection($users, $posts에는 random메소드가 있음)
    }
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;
    //convention을 따르지 않으면 우리가 설정해야 되는 부분
    //--model=Post라고 하면 자동으로 설정됨.

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'content' => $this->faker->sentence(),
            // 'user_id' => $this->users->random()->id,
            'user_id' => User::factory()->create()->id,
            //User에만 있는 id를 생성하나? 다른건 랜덤으로 만들어주던데?
            //user의 더미데이터도 만들어주는 것?ㅇㅇ문장자체가 그 뜻이다.
        ];
        //user_id(foreign key를 고려해서 써야됨.)
    }
}
