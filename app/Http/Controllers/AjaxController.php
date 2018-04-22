<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    
    public function users(Request $req){
        $user = \App\User::all();
        return json_encode($user);

    }
}
