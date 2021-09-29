<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mypage(Request $request)
    {
        $user = $request->user();
        $user->comments = Comment::where('user_id', $user->id)->get();
        $user->topics = Topic::where('user_id', $user->id)->get();
        return $user;
    }
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->intro = "";
        $user->save();
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->comments = Comment::where('user_id', $user->id)->get();
        $user->topics = Topic::where('user_id', $user->id)->get();
        return $user;
    }
    public function summary($id)
    {
        $user = User::withCount('topics', 'comments')->find($id);
        return $user;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {


        $user = $request->user();
        if ($request->intro != null || $request->intro != "") {
            $user->intro = $request->intro;
        }

        if ($request->hasFile('file')) {
            $filename = time() . '-' . $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public', $filename);
            $user->img_path = 'storage/' . $filename;
        }
        $user->save();
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = $request->user();
        Comment::where('user_id', $user->id)->delete();
        Topic::where('user_id', $user->id)->get()->each(function ($topic) {
            Comment::where('topic_id', $topic->id)->delete();
            $topic->delete();
        });
        $user->delete();
        return $user;
    }
}
