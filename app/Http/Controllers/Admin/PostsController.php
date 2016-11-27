<?php

namespace CMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use CMS\Post;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $posts = Post::with('category','user')->orderBy('post_id', 'desc')->get();
        //$posts = Post::all()->load('category','user');
        return view('admin.posts.posts')->with(['template'=>$this->adminTemplate(),'posts'=>$posts]);
    }

    public function add(Request $r)
    {
        $this->validate($r, [
            'title' => 'required|min:4',
            'content' => 'required|min:5',
        ]);
        $post = new Post($r->all());
        $post->user_id = Auth::user()->user_id;
        $post->save();
        return back();
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit')->with(['post' => $post,'template'=>$this->adminTemplate()]);
    }

    public function update(Request $r, Post $post)
    {
        if($r['confirm']) {
            $this->validate($r, [
                'title' => 'required|min:4',
                'content' => 'required|min:5',
            ]);

            $post->user_id = Auth::user()->user_id;
            $post->update($r->all());
            return back();
        }

    }

}
