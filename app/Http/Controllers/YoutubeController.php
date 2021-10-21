<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YoutubeController extends Controller
{
    //

    protected $client;

    public function _construct()
    {
        $this->client = new Vimeo(env('VIMEO_CLIENT'), env('VIMEO_SECRET'), env('VIMEO_ACCESS'));

    }


    // public function index()
    // {
    //     $video = $this->client->request('/me/video');
    //    // $vimeo->upload('/home/aaron/foo.mp4');
    //     return response()->json(['message' => 'done'], 200);
    // }

    //     public function store(Request $request)
    //     {
    //         if($request->hasFile('file')){
    //             $response = $this->client->upload($request->file, [
    //                 'name' => $request->file->getClientOriginalName(),
    //                 'privacy' => [
    //                     'view' => 'anybody'
    //                 ]
    //                 ]);
    //         }
    //         dd($response);
    //         $response->save();
    //         return response()->json(['message' => 'uploaded'], 200); 
            
    //     }

        public function index()
    {
            return view('index');       
    }

    public function store(Request $request, vimeoManager $vimeo)

    {
        $request->validation([
            'video'=> 'required|mimetypes:video/avi,video/mpeg,video/quicktime|60000',
        ]);

        $url = $vimeo->upload($request->video,
        [
            'title' => $request -> title,
            'description' => $request -> description,
        ]
        
    );
dd($url);
$url->save();
return response()->json(['message' => 'uploaded'], 200); 

}


}
