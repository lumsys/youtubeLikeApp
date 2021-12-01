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

public function Edit(Request $request, $id)
        {
        $videoEdit  = video::find($id);
        $videoEdit ->link =$request->link;
        $videoEdit ->tag =$request->tag;
        $videoEdit ->description=$request->description;
        $image=request('video_image'); 
        if($image){
            $file_name = time().'.'.$request->profile_picture->extension();
            $request->profile_picture->move(public_path('Videoimg'),$file_name);
            $path = "public/Videoimg/$file_name";
            $videoEdit->video_image = $path;
            DB::table('video')
                ->where('id',$id)
                ->update([
                    'video_image'=>$image,
                    'link' => $videoEdit->link,
                    'tag' => $videoEdit->tag,
                    'description' => $videoEdit->description,
                ]);
                return response()->json(['status'=>'true', 'message'=>"profile Edited suuccessfully"]);  
               
        }
}

}



