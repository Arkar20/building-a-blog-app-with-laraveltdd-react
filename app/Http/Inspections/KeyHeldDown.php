<?php

namespace App\Http\Inspections;

use ErrorException;


class KeyHeldDown{

public function detectKeyHeldDown($title)
   {
      if(preg_match('/(.)\\1{4,}/',$title,$matches)){
         throw new ErrorException("Comment contains Key Held Down sdpam!");
      }

      return false;
   }
}