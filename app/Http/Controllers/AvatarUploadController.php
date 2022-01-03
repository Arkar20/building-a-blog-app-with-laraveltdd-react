<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvatarUploadController extends Controller
{
  public function store(Request $request)
  {
     $request->validate(['avatar'=>['image','file']]);

     auth()->user()->update(['avatar'=>$request->file('avatar')->store('avatars','public')]);

     return back();
  }
}
