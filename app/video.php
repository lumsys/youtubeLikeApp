<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class video extends Model
{
    //

    protected $fillable = [
        'link', 'description', 'video_image', 'tag'
    ];

    public function category()  
{  
    return $this->belongTo('App\category','category_id');  
}  
}
