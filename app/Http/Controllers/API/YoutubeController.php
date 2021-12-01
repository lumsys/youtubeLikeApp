<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\video;
use App\cate;
use App\user;

class YoutubeController extends Controller
{
    
public function storeVideo(Request $request)
{
        $video = new video();
        $video ->link =$request->input('link');
        $video ->tag =$request->input('tag');
        $video->user_id = $request->user()->id;
        $category = cate::where('user_id',$request->user()->id)->first();
        $video->category_id = $category->id;
        $video ->description=$request->input('description');
        if($request->video_image && $request->video_image->isValid())
                {
                    $file_name = time().'.'.$request->video_image->extension();
                    $request->video_image->move(public_path('Videoimg'),$file_name);
                    $path = "public/Videoimg/$file_name";
                    $video->video_image = $path;
                }
        $video -> save();
        $user = User::where('id',$request->user()->id)->first()->id;
        $shows = video::where(['user_id' => $user])->get();
        return response()->json(['success' => true, $shows]);
        }
}



