<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


class UsersController extends Controller
{

    public function show(){
        return View("users",['title'=>'Hello World','show'=>true]);
    }

    public function test(){
        $email = DB::table('users')->where('firstname', 'Cchaddie')->value('email');
        echo $email . '<br>';
    }

}
