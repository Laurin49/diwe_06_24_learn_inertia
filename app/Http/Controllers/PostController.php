<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with('user')->latest()->get();         // eager loading user

        return inertia()->render('Posts/Index', [
            'posts' => PostResource::collection($posts),
            'can' => [
                'post_create' => auth()->user()->can('create', Post::class)
            ]
        ]);
    }

    public function store(StorePostRequest $request) {
        auth()->user()->posts()->create($request->validated());

        return redirect()
            ->route('posts.index')
            ->with('message', [                           // bearbeitet in HandleInertiaRequests.php
                'type' => 'success',
                'body' => 'Post created successfully',
            ]);
    }
}
