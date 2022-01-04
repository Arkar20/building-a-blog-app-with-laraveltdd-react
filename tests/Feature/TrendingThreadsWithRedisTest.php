<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Thread;
use App\Trending\Trending;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrendingThreadsWithRedisTest extends TestCase
{
    protected $trending;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();

        $this->trending=new Trending();

        Redis::del($this->trending->getKey());
    }
    public function test_record_user_visits_on_single_page()
    {
        $this->withoutExceptionHandling();
        $trending_threads=$this->trending->getTrending();

        
       $thread= Thread::factory()->create();

        $response = $this->get($thread->path());
        $trending_threads=$this->trending->getTrending();



        $this->assertEquals(1,count($trending_threads));
       
    }
    public function test_trending_threads_are_viewed_sorted_from_Most_view_to_least()
    {
        $this->withoutExceptionHandling();
        
        $trending_threads=$this->trending->getTrending();
        
        
        $thread1= Thread::factory()->create();
        $thread2= Thread::factory()->create();
        
        $response = $this->get($thread1->path());

        $response = $this->get($thread2->path());
        $response = $this->get($thread2->path());
        $response = $this->get($thread2->path());
        

        $trending_threads=$this->trending->getTrending();

        $this->assertEquals([
            $thread2->title,
            $thread1->title,
        ],
        [
           $trending_threads[3]->title,
         $trending_threads[1]->title
        ]
    );

        

    }
}
