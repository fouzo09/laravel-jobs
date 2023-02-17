<?php

namespace App\Services;

use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Facades\Storage;
use Image;

use function PHPUnit\Framework\fileExists;

class ImageService{

    public static function upload(array $images, string $folderName){

        if(!is_array($images)) return;
        $imageNames = [];
            
        foreach($images as $image){
            $imageName = time().sha1(rand(1, 10000)).'.'.$image->extension();
            $image->move(public_path('images/'.$folderName), $imageName);
            $imageNames[] = $imageName;
        }

        return $imageNames;
    }

    public static function resizeFromFolder(array $imageNames, string $folderName){

        if(!$folderName) return;

        $source = public_path('images/'.$folderName);

        
        foreach($imageNames as $imageName){   
            $destination = public_path("images/resized-$folderName");
            
            if (!is_dir($destination)) {
                mkdir($destination, 0775, true);
            }

            $img = Image::make($source."/".$imageName);
            $img->resize(320, 240);
            $img->save($destination."/".$imageName, 80);
        }
    }
}