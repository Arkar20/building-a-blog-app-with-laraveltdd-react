<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
  public function index(User $user)
  {
    $threads=$user->threads()->paginate(5);
      return view('profile.index',compact('user','threads'));
  }
}
