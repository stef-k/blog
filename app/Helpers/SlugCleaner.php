<?php
/**
 * User: stef
 * Date: 10/1/2017
 * Time: 11:52 μμ
 */

namespace app\Helpers;

/**
 * Class SlugCleaner removes
 * @package app\Helpers
 */
class SlugCleaner
{
    private static $toRemove = [
        'a',
        'an',
        'to',
        'the',
        'is',
        'me',
        'you',
        'are',
        'he',
        'she',
        'it',
        'they',
        'them',
        'i',
        'am',
        'we',
        'her',
        'him',
        '\'s',
        '\'',
    ];

    public static function clean($slug)
    {

    }
}
