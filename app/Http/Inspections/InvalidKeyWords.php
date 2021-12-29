<?php


namespace App\Http\Inspections;

use ErrorException;


class InvalidKeyWords{
    private $keywords=['Customer SerVice'];

   public function detectInvalidKeyWords($title)
   {
      foreach($this->keywords as $keyword){
         if(stripos($title,$keyword)!==false){
            throw new ErrorException("Comment contains spam!");
         }
      }

      return false;

   }
}