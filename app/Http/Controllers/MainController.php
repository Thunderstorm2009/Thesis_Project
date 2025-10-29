<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MainController extends Controller
{
    public function ProfilePage($username){
        $data = DB::table('profile')
        ->where('username',$username)
        ->first();

      //print_r($data);
        return view('profile')->with('data',$data);
    }

    public function HomePage(){
      $data = DB::table('profile')
      ->get();

    //print_r($data);
      return view('home')->with('data',$data);
    }

}