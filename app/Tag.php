<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//use App\Post;

/**
 * App\Tag
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Post[] $posts
 * @method static \Illuminate\Database\Query\Builder|\App\Tag whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tag whereName($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Tag postsByTag($name)
 * @method static \Illuminate\Database\Query\Builder|\App\Tag popular()
 */
class Tag extends Model
{

    protected $fillable = ['name'];

    /**
     * Get the posts associated with the given tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Get all posts or projects for a specific tag
     *
     * @param $query
     * @param $name String name of the tag
     *
     * @return mixed
     */
    public function scopePostsByTag($query, $name)
    {
        $tag = $query->with('posts')->whereName($name)->get();

        return $posts;
    }

    /**
     * Get 10 most popular tags
     *
     * @return mixed
     */
    public function scopePopular()
    {
        $tags = Tag::join('post_tag', 'post_tag.tag_id', '=', 'tags.id')
                   ->groupBy('tags.id')
                   ->get(['tags.id', 'tags.name', \DB::raw('count(tags.id) as tag_count')])
                   ->sortBy('name')
                   ->take(10);

        return $tags;
    }

}
