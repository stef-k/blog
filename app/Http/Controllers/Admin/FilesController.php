<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilesRequest;
use App\Http\Requests\FilesDeleteRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;


class FilesController extends Controller
{
    public function index($start = 0, $batch = 6)
    {
        $path   = storage_path() . '/app/public/images';
        $public = '/public/images/';
        $paths  = File::files($path);
        $psize  = sizeof($paths);
        $urls   = array();
        $output = array(
            'total' => $psize, // total items
            'start' => $start, // pagination start
            'pages' => ceil($psize / $batch), // total pages
            'batch' => $batch, // items per page
        );
        $i      = $start;

        for ($i; ($i < $psize) && $i < ($start + $batch); $i++) {
            $file = [
                'link'     => $public . File::name($paths[$i]) . '.' . File::extension($paths[$i]),
                'name'     => File::name($paths[$i]) . '.' . File::extension($paths[$i]),
                'size'     => $this->humanReadableSize(File::size($paths[$i])),
                'selected' => false,
            ];
            array_push($urls, $file);
        }

        $output['urls'] = $urls;

        return $output;
    }

    public function image($image)
    {
        $path = storage_path() . '/app/public/images/' . $image;
        if ( ! File::exists($path)) {
            abort(404);
        } else {
            return response()->file($path);
        }
    }

    public function upload(FilesRequest $request)
    {

        $paths  = array();
        $files  = $request->file('image');
        $public = $path = storage_path() . '/app/public/images/';

        foreach ($files as $key => $file) {
            // If filename exists append it with Unix now timestamp
            $append   = round(microtime(true) * 1000);;
//            $name     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $ext      = $file->getClientOriginalExtension();
            $filename = $append . '.' . $ext;

            $path = $file->storeAs('public/images', $filename);
            array_push($paths, asset($path));
        }

        return $paths;
    }

    public function delete(FilesDeleteRequest $request)
    {
        $deletables = $request->input('deletable');
        $output     = [];
        foreach ($deletables as $deletable) {

            $path = storage_path() . '/app/public/images/' . $deletable;
            if (File::exists($path)) {
                File::delete($path);
            } else {
                array_push($output, $deletable . ' does not exist');
            }
        }
        if (sizeof($output) != 0) {
            return $output;
        } else {
            return response('', 200);
        }
    }

    private function humanReadableSize(int $size)
    {
        $i = floor(log($size) / log(1000));

        return round($size / pow(1000, $i), 2) * 1 . ' ' . ['B', 'kB', 'MB', 'GB', 'TB'][$i];
    }
}
