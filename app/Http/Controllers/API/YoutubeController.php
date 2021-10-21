<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vimeo\Laravel\Facades\Vimoe;
use Vimeo\Laravel\VimeoManager;

class YoutubeController extends Controller
{
    

    protected $client;

    public function _construct()
    {
        $this->client = new Vimeo(env('VIMEO_CLIENT'), env('VIMEO_SECRET'), env('VIMEO_ACCESS'));

    }


    public function index()
    {
        $video = $this->client->request('/me/video');
        return response()->json(['message' => 'done'], 200);
    }

        public function store(Request $request)
        {
            if($request->hasFile('file')){
                $response = $this->client->upload($request->file, [
                    'name' => $request->file->getClientOriginalName(),
                    'privacy' => [
                        'view' => 'anybody'
                    ]
                    ]);
            }
            dd($response);
            $response->save();
            return response()->json(['message' => 'uploaded'], 200); 
            
        }


    //     public function watch()
    //     {
    //         return view('watch');
    //     }
    // public function create()
    // {
    //         return view('index');       
    // }

//     public function store(Request $request, vimeoManager $vimeo)

//     {
//         $request->validation([
//             'file'=> 'required|video',
//         ]);

//         $url = $vimeo->upload($request->video,
//         [
//             'title' => $request -> title,
//             'description' => $request -> description,
//         ]
        
//     );
// dd($url);
// $url->save();
// return response()->json(['message' => 'uploaded'], 200); 

// }
}
