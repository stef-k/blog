<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Settings;


class IntegrationsController extends Controller
{
    public function index()
    {
        $settings = Settings::firstOrCreate(['settings_ver' => '1']);

        return $settings;
    }

    public function saveAnalytics(Request $request)
    {
        $settings = Settings::firstOrCreate(['settings_ver' => '1']);

        $tracking = $request->input('trackingId');

        if ($tracking != '') {
            $settings->tracking_id = $tracking;

            $settings->save();

            return $settings->tracking_id;
        } else {
            return response('Tracking ID cannot be empty', 400);
        }
    }

    public function clearAnalytics()
    {
        $settings = Settings::firstOrCreate(['settings_ver' => '1']);

        $settings->tracking_id = '';

        $settings->save();

        return response('Tracking ID has been cleared', 200);
    }

    public function saveDisqus(Request $request)
    {
        $settings = Settings::firstOrCreate(['settings_ver' => '1']);

        $disqusUrl = $request->input('disqusUrl');

        if ($disqusUrl != '') {
            $settings->disqus_url = $disqusUrl;

            $settings->save();

            return $settings->disqus_url;
        } else {
            return response('Disqus site URL cannot be empty', 400);
        }
    }

    public function clearDisqus()
    {
        $settings = Settings::firstOrCreate(['settings_ver' => '1']);

        $settings->disqus_url = '';
        $settings->save();

        return response('Disqus URL has been cleared', 200);
    }
}
