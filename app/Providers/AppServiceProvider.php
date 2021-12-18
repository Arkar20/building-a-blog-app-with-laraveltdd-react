<?php

namespace App\Providers;

use App\Models\Channel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         

            View::composer('*',function($view){
                Cache::remember('channels',10,function(){
                return Channel::all();
            });
             return  $view->with('channels',Cache::get('channels'));
            });
        

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    
    {
        

             Model::preventLazyLoading(!$this->app->isProduction());
             Paginator::useBootstrap();
    }
}
