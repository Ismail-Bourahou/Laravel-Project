<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
   public function logout()
    {
        session()->forget('user_id');
        return redirect('/'); 
    }
}
