<?php

use App\Post;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LikesTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    protected $post;

     public function setup()
     {
        parent::setUp();

        $this->post = factory(App\Post::class)->create();

        // user method from TestCase.php
        $this->signIn();
     }

    /** @test */
    public function a_user_can_like_a_post()
    {
        // when they like a post
        $this->post->like();

        // then we should see evidence in the DB and the this->post should be liked
        $this->seeInDatabase('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post)
        ]);

        $this->assertTrue($this->post-isLiked());
    }

    /** @test */
    public function a_user_can_unlike_a_post()
    {
         $this->be($this->user);
 
         $this->post->like();
         $this->post->unlike();
 
         $this->notSeeInDatabase('likes', [
             'user_id' => $this->user->id,
             'likeable_id' => $this->post->id,
             'likeable_type' => get_class($this->post)
         ]);
 
         $this->assertFalse($this->post-isLiked());
    }

    /** @test */
    public function a_user_can_toggle_likes()
    {   
        $this->post->toggle();
        
        $this->assertTrue($this->post-isLiked());   

        $this->post->toggle();
        $this->assertFalse($this->post-isLiked());  
    }

    /** @test */
    public function a_post_knows_how_many_likes_it_has()
    {
        $this->post->toggle();

        $this->assertEquals(1, $this->post->likesCount);
    }
}
