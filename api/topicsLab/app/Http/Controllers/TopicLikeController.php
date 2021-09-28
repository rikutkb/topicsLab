<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\TopicLike;
use Illuminate\Http\Request;

class TopicLikeController extends Controller
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
    public function store(Request $request, Topic $topic)
    {
        $user = $request->user();
        $topiclike = new TopicLike();
        $topiclike->user()->associate($user);
        $topiclike->topic()->associate($topic);
        $topiclike->save();
        return $topiclike;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TopicLike  $topicLike
     * @return \Illuminate\Http\Response
     */
    public function show(TopicLike $topicLike)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TopicLike  $topicLike
     * @return \Illuminate\Http\Response
     */
    public function edit(TopicLike $topicLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TopicLike  $topicLike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TopicLike $topicLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TopicLike  $topicLike
     * @return \Illuminate\Http\Response
     */
    public function destroy(TopicLike $topicLike)
    {
        //
    }
}
