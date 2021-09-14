<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;

class AdminController extends Controller
{
    //
    
    public function login(){
        return view('admin.login');
    }
    
    public function authenticate(Request $request){
        
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password, 'role'=>'admin'])){
            return redirect()->intended('admin/dashboard')->withSuccess('Logged-in');
        }
        
        return back()->with('error_msg','Credentials are wrong.');
    }
    
    //show super user dashboard
    
    public function dashboard(){
        
        $posts=Post::orderBy('id','DESC')->get();
        $members=User::orderBy('id','DESC')->get();
        
        return view('admin.dashboard',compact('posts','members'));
    }
    
    public function members(){
        $members=User::orderBy('id','DESC')->get();
        
        return view('admin.users',compact('members'));
    }
    
    public function posts(){
        $posts=Post::orderBy('id','DESC')->get();
        
        return view('admin.posts',compact('posts'));
    }
    
    public function userUpdate(User $user){
        
        $user->email_verified_at=Carbon::now();
        
        $user->save();
        
        return redirect()->back();
    }
    
    public function postUpdate(Post $post, $status){
        
        if($status=='approve'){
            $post->status='approved';
        }else{
            $post->status='denied';
        }
        
        $post->save();
        
        
        return redirect()->back();
    }
}
