<?php

namespace App\Http\Controllers;

use App\Jobs\UploadImageJob;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getIndex(){
        return view('index');
    }

    public function postUploadSimple(Request $request){

        $start = microtime(true);

        $request->validate([
            'images' => 'required|array'
        ]);

        $folderName = 'upload-'.time().sha1(rand(1, 10000));

        $images = $request->images;
        $imageNames = ImageService::upload($images, $folderName);
        ImageService::resizeFromFolder($imageNames, $folderName);


        $duree = microtime(true) - $start;

        return back()
                ->with('success-simple-upload', 'Image uploader avec succès en '. $duree * 10);
    }

    public function postUploadWithJob(Request $request){

        $start = microtime(true);

        $request->validate([
            'images' => 'required|array'
        ]);

        $folderName = 'upload-'.time().sha1(rand(1, 10000));

        $images = $request->images;
        $imageNames = ImageService::upload($images, $folderName);
        
        dispatch(new UploadImageJob($imageNames, $folderName));

        $duree = microtime(true) - $start;

        return back()
                ->with('success-upload-with-job', 'Image uploader avec succès en '. $duree * 10);
    }
}
