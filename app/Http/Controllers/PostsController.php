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

        $tags = Tag::popular();

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

    /**
     * Search in article titles and main body of text
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

        $tags = Tag::popular();

        return view('public.post.index', compact('posts', 'tags'));
    }
}
