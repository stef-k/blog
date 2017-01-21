<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Post;
use App\Tag;

class ProjectsController extends Controller
{
    /**
     * Return all posts having isproject or is-project tags
     * with their tags and paginate them.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::with('tags')->whereHas('tags', function($q){
            $q->where('name', '=', 'is-project');
        })->where('published_at', '!=', 'null')->orderBy('created_at', 'desc')->paginate(6);

        return view('public.project.index', compact('posts', 'tags'));
    }

    /**
     * Get a single post with is-project tag
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
        $post = Post::whereRaw('date(published_at) = ?', $date)->whereSlug($slug)->firstOrFail();
        return view('public.project.single', compact('post'));
    }
}
