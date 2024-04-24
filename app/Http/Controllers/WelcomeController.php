<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        if(!empty(Auth::user())){
            return redirect("mypage");
        }else{            
            return redirect('login');
        } 
       
    }
}
