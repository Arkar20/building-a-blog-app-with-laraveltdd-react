<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
  public function index(User $user)
  {

    $activities=$user->activities()->with('activity')->get()->groupBy(function($activity){
      return $activity->created_at->format('Y-m-d');
    });

      return view('profile.index',compact('user','activities'));
  }
}
