<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Post;

class TagsController extends Controller
{
    /**
     * Get all tags
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tags = Tag::join('post_tag', 'post_tag.tag_id', '=', 'tags.id')
                   ->groupBy('tags.id')
                   ->get(['tags.id', 'tags.name', \DB::raw('count(tags.id) as tag_count')])
                   ->sortByDesc('tag_count');

        return view('public.tag.index', compact('tags'));
    }

    public function tag($request)
    {
        $posts = Post::postsByTag($request);

        $tags  = Tag::popular();

        return view('public.tag.byname', compact('posts', 'tags'));
    }
}
