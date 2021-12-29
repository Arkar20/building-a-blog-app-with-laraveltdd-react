<?php

namespace App\Http\Inspections;

use ErrorException;
use Illuminate\Http\Request;
use App\Http\Inspections\KeyHeldDown;
use App\Http\Inspections\InvalidKeyWords;

class Spam   //* Facade pattern
{
  public function detect($title) 
  {
   try{
     $invalidkeywords= new InvalidKeyWords();
     $invalidkeywords->detectInvalidKeyWords($title);

     $keyheldown=new KeyHeldDown();
     $keyheldown->detectKeyHeldDown($title);
   }catch(ErrorException $e){
      return true;
   }
  }
              
}