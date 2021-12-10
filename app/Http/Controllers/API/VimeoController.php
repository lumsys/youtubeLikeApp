<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vimeo\Vimeo;
use Vimeo\Laravel\VimeoManager;
use App\VimeoLogs;


class VimeoController extends Controller
{
    public function uploadVideo(Request $request, VimeoManager $vimeo){
        try{
           
            $videoUrl = $vimeo->upload($request->video,[
                'name' => $request->title,
                'description' => $request->description
            ]);

            $log_details = new vimeoLogs();
            $log_details->user_id = user()->id;
            $log_details->video_id = $videoUrl;
            $log_details->save();
        return response()->json([
            'message' => 'Success',
            'response' => $videoUrl
            
        ]);
        }
        catch(\Exception $e){
            return response()->json(
                [
                    'message' => 'An error occurred performing request.',
                    'short_description' => $e->getMessage()
                ],
                400
            );
        }

    }
    public function getAllVideo(VimeoManager $vimeo){
        $allVideo = $vimeo->request('/me/videos', ['per_page' => 10], 'GET');
        return response()->json([
            'response' => $allVideo
        ]);
    }

    public function getUserVideos($user_id){
        try{
            $videos = Vimeologs::where(['user_id' => $user_id]);
            if($videos)
                return response()->json(['message' => $videos->get()]);
    }
        
    catch(\Exception $e){
        return response()->json(
        [
        'message' => 'An error occurred performing request.',
        'short_description' => $e->getMessage()
    ],
    400
);
        
    }

}}