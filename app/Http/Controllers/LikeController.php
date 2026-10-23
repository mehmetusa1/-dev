<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\Visitor;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        $visitor = Visitor::id($request);
        $removed = $post->likes()->where('visitor_id', $visitor)->delete();
        if (!$removed) {
            $post->likes()->firstOrCreate(['visitor_id' => $visitor]);
        }

        return back()->with('success', $removed ? 'Beğeni geri alındı.' : 'Yazıyı beğendin.');
    }
}
