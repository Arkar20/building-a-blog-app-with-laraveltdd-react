<?php

namespace Tests\Unit;

use ErrorException;
use Tests\TestCase;
use App\Http\Inspections\Spam;
use App\Http\Inspections\KeyHeldDown;
use App\Http\Inspections\InvalidKeyWords;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpamTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    public function test_spam_detect_invalid_keywords()
    {

        $this->expectException(ErrorException::class);

          $spam=new InvalidKeyWords();

         $spam->detectInvalidKeyWords("Customer Service");

    }
    public function test_spam_detect_keyHeldDown()
    {

        $this->expectException(ErrorException::class);

          $spam=new KeyHeldDown();

         $spam->detectKeyHeldDown("aaaaaaa");

    }
}
