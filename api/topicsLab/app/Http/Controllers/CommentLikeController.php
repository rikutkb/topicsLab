<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Topic;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Topic $topic, Comment $comment)
    {
        $user = $request->user();
        $commentlike = new CommentLike();
        $commentlike->user()->associate($user);
        $commentlike->comment()->associate($comment);
        $commentlike->save();
        return $commentlike;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CommentLike  $commentLike
     * @return \Illuminate\Http\Response
     */
    public function show(CommentLike $commentLike)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CommentLike  $commentLike
     * @return \Illuminate\Http\Response
     */
    public function edit(CommentLike $commentLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommentLike  $commentLike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommentLike $commentLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CommentLike  $commentLike
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommentLike $commentLike)
    {
        //
    }
}
