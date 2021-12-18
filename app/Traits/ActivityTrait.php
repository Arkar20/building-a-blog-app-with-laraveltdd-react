<?php

namespace App\Traits;


trait ActivityTrait{


   public static function bootActivityTrait(){
    
    $events=['created','deleting'];


    foreach($events as $event){
        static::$event(function($action) use($event){
           return $action->markActivity($event);
        });

    }

        
    }

    public function markActivity($action)
    {
        return $this->activities()->create(['action_type'=>$action.'_'.$this->getClassName()]);
    }
    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }
    

  
}