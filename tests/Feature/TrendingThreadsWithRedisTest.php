<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class TrendingThreadsWithRedisTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();

        Redis::del('trendng_threads');
    }
    public function test_record_user_visits_on_single_page()
    {
        $this->withoutExceptionHandling();
        $trending_threads=Redis::zrevrange('trendng_threads',0,-1);

        
       $thread= Thread::factory()->create();

        $response = $this->get($thread->path());
        $trending_threads=Redis::zrevrange('trendng_threads',0,-1);



        $this->assertEquals(1,count($trending_threads));
       
    }
    public function test_trending_threads_are_viewed_sorted_from_Most_view_to_least()
    {
        $this->withoutExceptionHandling();
        
        $trending_threads=Redis::zrevrange('trending_threads',0,-1);
        
        
        $thread1= Thread::factory()->create();
        $thread2= Thread::factory()->create();
        
        $response = $this->get($thread1->path());
        $response = $this->get($thread2->path());
        $response = $this->get($thread2->path());
        $response = $this->get($thread2->path());
        
        $response = $this->get('/');

        $trending_threads=Redis::zrevrange('trending_threads',0,-1);

        $this->assertEquals([
            $thread2->title,
            $thread1->title,
        ],
        [
            json_decode($trending_threads[0])->title,
            json_decode($trending_threads[1])->title
        ]
    );

        

    }
}
