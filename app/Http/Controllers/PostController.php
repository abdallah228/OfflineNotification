<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Notifications\PostNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use DB;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $post = Post::create([
            'title'=>$request->title,
            'body'=>$request->body,
        ]);
            $users = User::where('id','!=',auth()->user()->id)->get();
            $user_creator = auth()->user()->name;
            Notification::send($users,new PostNotification($post->id,$user_creator,$post->title));
            return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // return auth()->user()->unreadNotifications;
        $post = Post::findOrFail($id);
        $notificationId = request()->singleNotification;
            DB::table('notifications')->where('id',$notificationId)->update(['read_at'=>now()]);
            // dd('updated done');
            return $post;
            // dd(request()->singleNotification);
        // $notifyId = DB::table('notifications')->where('data->post_id',$id)->pluck('id');
        // dd($id);
            //  foreach($notifyId as $id) {
            //  DB::table('notifications')->where('id',$id)->update(['read_at'=>now()]);
            //  }
            //  return $post;
        // return redirect()->route('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    /**
     * mark allAuth User Notification as read
     */
    public function markAsRead() {
        $user = auth()->user()->unreadNotifications;
        foreach($user as $notificatio) {
            $notificatio->markAsRead();
        }
        return redirect()->back();
    }
}
