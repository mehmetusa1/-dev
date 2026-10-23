<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\Visitor;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $visitor = Visitor::id($request);
        $posts = Post::withCount('likes')->withExists(['likes as liked' => fn ($query) => $query->where('visitor_id', $visitor)])->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function show(Request $request, Post $post)
    {
        $visitor = Visitor::id($request);
        $post->loadCount('likes')->loadExists(['likes as liked' => fn ($query) => $query->where('visitor_id', $visitor)]);
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        abort_unless(session('admin'), 403);
        return view('posts.create');
    }

    public function store(Request $request)
    {
        abort_unless(session('admin'), 403);
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'content' => 'required|string|max:20000',
        ]);
        Post::create($data);
        return redirect()->route('posts.index')->with('success', 'Yazı eklendi.');
    }

    public function edit(Post $post)
    {
        abort_unless(session('admin'), 403);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        abort_unless(session('admin'), 403);
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'content' => 'required|string|max:20000',
        ]);
        $post->update($data);
        return redirect()->route('posts.index')->with('success', 'Yazı güncellendi.');
    }

    public function destroy(Post $post)
    {
        abort_unless(session('admin'), 403);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Yazı silindi.');
    }
}
