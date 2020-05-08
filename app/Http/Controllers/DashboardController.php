<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;


class DashboardController extends Controller
{
    public function index(){
        $posts = Post::all();
        foreach($posts as $post){
            echo $post->title ."<br>";
        }
    }

    public function create(Request $request){
        if($request->isMethod('post')){
            $post = new Post();
            $post->title = $request->input('title');
            $post->description = $request->input("description");
            $post->category = "general";
            $post->save();
            echo  "POST saved";
            return false;
        }
        return View("dashboard.create");
    }

    public function home(){
        return View("dashboard.home");
    }

    public function help(){
        return View("dashboard.help");
    }
}
