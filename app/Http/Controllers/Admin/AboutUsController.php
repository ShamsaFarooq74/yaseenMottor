<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ResponseController;
use App\Http\Controllers\Controller;

use App\Http\Models\AboutUs;
use App\Http\Models\AboutUsImage;
use App\Http\Models\AboutUsVideo;
use Illuminate\Http\Request;

class AboutUsController extends ResponseController
{
    public function getAboutUsDetails()
    {
        $images = AboutUsImage::all();
        for($i=0;$i<count($images);$i++)
        {
            $images[$i]['image'] = getImageUrl($images[$i]['image'], 'images');
        }
        $videos = AboutUsVideo::all();
        for($i=0;$i<count($videos);$i++)
        {
            $videos[$i]['video'] = getImageUrl($videos[$i]['video'], 'images');
        }
        $aboutUs = AboutUs::all();
        $aboutUsDetails = [
            'images' => $images,
            'videos' => $videos,
            'aboutUs' => $aboutUs

        ];
        return $this->sendResponse(1, 'success', $aboutUsDetails);
//        if($request->hasfile('attachment'))
//        {
//
//            foreach($request->file('attachment') as $file)
//            {
//                $name = date("dmyHis.").gettimeofday()["usec"].''.'tracking'.$file->getClientOriginalName();
//                $file_type='image';
//                $extension = $file->getClientOriginalExtension();
//                if($extension === 'mp3' || $extension === 'mp4' || $extension === 'mov' || $extension === 'MOV' || $extension === 'mkv'){
//                    $file_type='video';
//                }
//
//                $file->move(public_path().'/assets/tracking_files/', $name);
//                $attachments[] = $name;
//                Tracking_image::create([
//                    'tracking_id' => $tracking_id,
//                    'file' => $name,
//                    'file_type' => $file_type,
//                    'created_by' =>request()->user()->id,
//                    'updated_by' => request()->user()->id
//                ]);
//
//            }
//        }
    }

}
