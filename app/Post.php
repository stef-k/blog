<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Tag;

/**
 * App\Post
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property string $published_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Tag[] $tags
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post wherePublishedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Post postsByTag($name)
 */
class Post extends Model
{
    protected $fillable = ['title', 'body', 'status', 'published_at'];
    /**
     * Get all Tags beloging to this post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    /**
     * Post's permalink URL as /year/month/day/slug
     *
     * @return string
     */
    public function permalink($type='posts/')
    {
        $date = strtotime($this->published_at);
        $year = date("Y", $date);
        $month = date("m", $date);
        $day = date("d", $date);
        return  '/' . $type . $year . '/' . $month . '/' . $day . '/' . $this->slug;
    }

    /**
     * Post excerpt with limit at word boundaries.
     *
     * @param int $limit how many characters to keep
     * @param boolean $withImage keep image in exceprt?
     * @return string
     */
    public function excerpt($limit=150, $withImage=true)
    {

        $excerpt = substr($this->body, 0, $limit);
        if (!$withImage) {
            $excerpt = preg_replace("/^!\[.*\]\(.*\)$/m", '', $excerpt);
        }

        $cutoff = strrpos($excerpt, ' ');
        if ($cutoff > 0) {
            $excerpt = substr($excerpt, 0, $cutoff);
        }
        return $excerpt . '[...]';
    }

    /**
     * Parses post's body and returns the first image.
     *
     * @return string
     */
    public function image($url=false)
    {
        preg_match("/^!\[.*\]\(.*\)$/m", $this->body, $img);

        // extract image's URL
        if($url) {
            if (sizeof($img) > 0) {
                $str = $img[0];
                preg_match("#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#", $str, $clean);
                $img = $clean;
            } else {
                $img[0] = '';
            }
        }

        if (count($img) > 0) {
            return $img[0];
        } else {
            return '';
        }

    }

    /**
     * Parses post's body and returns all images.
     *
     * @return string
     */
    public function images($url=false)
    {
        preg_match_all("/^!\[.*\]\(.*\)$/m", $this->body, $img);

        return implode("", $img[0]);
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
        $posts = $query->with('tags')->whereHas('tags', function($q) use ($name){
            $q->whereName($name);
        } )->paginate(3);

        return $posts;
    }

}
