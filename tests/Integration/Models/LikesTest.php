<?php

use App\Post;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LikesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function a_user_can_like_a_post()
    {
        // given I have a post
        $post = factory(App\Post::class)->create();
        // and a user
        $user = factory(App\User::class)->create();

        // and that user is logged in
        $this->be($user);

        // when they like a post
        $post->like();

        // then we should see evidence in the DB and the post should be liked
        $this->seeInDatabase('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post)
        ]);

        $this->assertTrue($post-isLiked());
    }

    /** @test */
    public function a_user_can_unlike_a_post()
    {
         $post = factory(App\Post::class)->create();
         $user = factory(App\User::class)->create();
 
         $this->be($user);
 
         $post->like();
         $post->unlike();
 
         $this->notSeeInDatabase('likes', [
             'user_id' => $user->id,
             'likeable_id' => $post->id,
             'likeable_type' => get_class($post)
         ]);
 
         $this->assertFalse($post-isLiked());
    }

    /** @test */
    public function a_user_can_toggle_likes()
    {   
        $post = factory(App\Post::class)->create();
        $user = factory(App\User::class)->create();

        $this->be($user);

        $post->toggle();
        $this->assertTrue($post-isLiked());   

        $post->toggle();
        $this->assertFalse($post-isLiked());  
    }

}
