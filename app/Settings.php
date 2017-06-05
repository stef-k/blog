<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Settings
 *
 * @property int $id
 * @property string $settings_ver
 * @property string $tracking_id
 * @property string $disqus_url
 * @method static \Illuminate\Database\Query\Builder|\App\Settings whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Settings whereSettingsVer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Settings whereTrackingId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Settings whereDisqusUrl($value)
 * @mixin \Eloquent
 */
class Settings extends Model
{
    protected $fillable = ['tracking_id', 'disqus_url'];
    public $timestamps = false;
}
