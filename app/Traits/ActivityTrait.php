<?php

namespace App\Traits;


trait ActivityTrait{


   public static function bootActivityTrait(){

    if(auth()->guest()) return;


    
    $events=['created'];


    foreach($events as $event){
        static::$event(function($action) use($event){
           return $action->markActivity($event);
        });

    }

            static::deleting(function($model){
                return $model->activities()->delete();
            });

        
    }

    public function markActivity($action)
    {
        return $this->activities()->create(['action_type'=>$action.'_'.$this->getClassName(),'user_id'=>auth()->id()]);
    }
    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }
    

  
}