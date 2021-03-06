<?php

namespace App\Filters;

use Illuminate\Http\Request;


abstract class Filter {

    protected $request;

    protected $filters=[];
    

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function apply($query)
    {
        foreach($this->filters as $filter){
            if(method_exists($this,$filter) && $username=$this->request->get($filter)){
                $query= $this->$filter($username,$query);     
            }
        }


        return $query;
        
    }

    // abstract public function by($username,$query);

}