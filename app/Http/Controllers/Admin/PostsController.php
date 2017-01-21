<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DateTime;

use App\Post;
use App\Tag;

class PostsController extends Controller
{
    /**
     * Get all posts from newest to oldest
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(Request $request)
    {

        $posts = Post::with('tags')->whereDoesntHave('tags', function ($q) {
            $q->where('name', '=', 'is-project');
        })->orderBy('created_at', 'desc')->paginate(3);

        $posts->setPath('');

        return $posts;

    }

    /**
     * Create a new Post
     *
     * @param Request $request
     *
     * @return Post
     */
    public function create(Request $request)
    {
        $post        = new Post();
        $status      = $request->input('status');
        $post->title = $request->input('title');
        $post->body  = $request->input('body');
        $slug        = $post->title;
        $post->slug  = str_slug($slug);

        if ($status) {
            $post->published_at = new DateTime();
            $post->published_at = $post->published_at->format('Y-m-d H:i:s');
        }
        $tags = $request->json('tags');

        $post->save();

        if (sizeof($tags > 0)) {
            foreach ($tags as $tag) {
                $tag = preg_replace('/[^A-Za-z0-9|\-]/', '', $tag);
                if ( ! empty($tag)) {
                    $theTag = Tag::firstOrCreate(['name' => strtolower($tag)]);
                    if ( ! $post->tags->contains($theTag)) {
                        $post->tags()->attach($theTag->id);
                    }
                }
            }
        }

        return $post;
    }

    public function update(Request $request)
    {
        $id          = $request->input('id');
        $status      = $request->input('status');
        $post        = Post::find($id);
        $post->title = $request->input('title');
        $post->body  = $request->input('body');
        $slug        = $post->title;
        $post->slug  = str_slug($slug);

        if ($status && $post->published_at == null) {
            $post->published_at = new DateTime();
            $post->published_at = $post->published_at->format('Y-m-d H:i:s');
        } else if ( ! $status && $post->published_at != null) {
            $post->published_at = null;
        }

        $tags = $request->json('tags');

        $post->save();

        $post->tags()->detach();

        if (sizeof($tags > 0)) {
            foreach ($tags as $tag) {
                $tag = preg_replace('/[^A-Za-z0-9|\-]/', '', $tag);
                if ( ! empty($tag)) {
                    $theTag = Tag::firstOrCreate(['name' => strtolower($tag)]);
                    if ( ! $post->tags->contains($theTag)) {
                        $post->tags()->attach($theTag->id);
                    }
                }
            }
        }

        return $post;
    }

    public function post($id)
    {
        $post = Post::with('tags')->findOrFail($id);

        return $post;
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        Post::find($id)->delete();
    }

    public function search(Request $request)
    {
        $term = $request->input('term');

        if ($term != '') {
            $posts = Post::with('tags')->whereDoesntHave('tags', function ($q) {
                $q->where('name', '=', 'is-project');
            })->where('title', 'like', '%' . $term . '%')
                         ->orWhere('body', 'like', '%' . $term . '%')
                         ->orderBy('created_at', 'desc')->paginate(3);

            $posts->setPath('search');
        } else {
            $posts = new Post();
        }

        return $posts;
    }

}
