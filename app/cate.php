<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cate extends Model
{
    //

    public function video()  
    {  
        return $this->hasMany('App\video');  
    }  
}
