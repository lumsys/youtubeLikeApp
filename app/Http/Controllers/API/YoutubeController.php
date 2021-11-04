<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vimeo\Laravel\Facades\Vimoe;
use Vimeo\Laravel\VimeoManager;

class YoutubeController extends Controller
{
    
    public function uploadYoutube(Request $request){
    $video = Youtube::upload($fullPathToVideo, [
        'title'       => $request->title,
        'description' => $request->description,
        'category_id' => $request->category_id,
    ]);
    return response()->json(['message' => 'done', $video->getVideoId()], 200);
}

}
