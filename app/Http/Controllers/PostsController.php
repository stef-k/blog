<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Tag;

class PostsController extends Controller
{
    /**
     * Return all posts except those having isproject tags
     * with their tags and paginate them.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::with('tags')->whereDoesntHave('tags', function ($q) {
            $q->where('name', '=', 'is-project');
        })->where('published_at', '!=', 'null')->orderBy('created_at', 'desc')->paginate(3);

        // get the 10 most used tags except 'is-project' tag
        $tags = Tag::join('post_tag', 'post_tag.tag_id', '=', 'tags.id')
                   ->groupBy('tags.id')
                   ->having('tags.name', '!=', 'is-project')
                   ->get(['tags.id', 'tags.name', \DB::raw('count(tags.id) as tag_count')])
                   ->sortByDesc('tag_count')
                   ->take(10);

        return view('public.post.index', compact('posts', 'tags'));
    }

    /**
     * Get a single post
     *
     * @param $year
     * @param $month
     * @param $day
     * @param $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($year, $month, $day, $slug)
    {
        $date = strtotime($year . '-' . $month . '-' . $day);
        $date = date('Y-m-d', $date);
        $post = Post::with('tags')->whereRaw('date(published_at) = ?', $date)->whereSlug($slug)->firstOrFail();

        return view('public.post.single', compact('post'));
    }


    public function tag($name)
    {
        $posts = Post::with('tags')->whereHas('tags', function ($q) use ($name) {
            $q->where('name', $name);
        })->whereDoesntHave('tags', function ($q) {
            $q->where('name', '=', 'is-project');
        })->where('published_at', '!=', 'null')->orderBy('created_at', 'desc')->paginate(3);

        // get the 10 most used tags except 'is-project' tag
        $tags = Tag::join('post_tag', 'post_tag.tag_id', '=', 'tags.id')
                   ->groupBy('tags.id')
                   ->having('tags.name', '!=', 'is-project')
                   ->get(['tags.id', 'tags.name', \DB::raw('count(tags.id) as tag_count')])
                   ->sortByDesc('tag_count')
                   ->take(10);

        return view('public.post.index', compact('posts', 'tags'));
    }

    public function tags()
    {
        $tags = Tag::join('post_tag', 'post_tag.tag_id', '=', 'tags.id')
                   ->groupBy('tags.id')
                   ->having('tags.name', '!=', 'is-project')
                   ->get(['tags.id', 'tags.name', \DB::raw('count(tags.id) as tag_count')])
                   ->sortByDesc('tag_count');

        return view('public.tag.index', compact('tags'));
    }

    public function search(Request $request)
    {
        $term = $request->input('term');

        $posts = Post::with('tags')->whereDoesntHave('tags', function ($q) {
            $q->where('name', '=', 'is-project');
        })->where('published_at', '!=', 'null')
                     ->where('title', 'like', '%' . $term . '%')
                     ->where('body', 'like', '%' . $term . '%')
                     ->orderBy('created_at', 'desc')->paginate(3);

        $posts->setPath('search');

        // get the 10 most used tags except 'is-project' tag
        $tags = Tag::join('post_tag', 'post_tag.tag_id', '=', 'tags.id')
                   ->groupBy('tags.id')
                   ->having('tags.name', '!=', 'is-project')
                   ->get(['tags.id', 'tags.name', \DB::raw('count(tags.id) as tag_count')])
                   ->sortByDesc('tag_count')
                   ->take(10);

        return view('public.post.index', compact('posts', 'tags'));
    }
}
