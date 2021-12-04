<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;


class AdminController extends Controller
{
    //

    public function getUserList()
    {
        $getUsers = User::where('usertype', 'user')->get();
        return response()->json(['success' => true, $getUsers]);
    }

    public function countUser()
    {
        $countUsers = User::where('usertype', 'user')->count();
        return response()->json(['success' => true, $countUsers]);
    }

    public function getAuthorList()
    {
        $getAuthorList = User::where('usertype', 'Author')->get();
        return response()->json(['success' => true, $getAuthorList]);
    }

    public function countAuthor()
    {
        $getAuthor = User::where('usertype', 'Author')->count();
        return response()->json(['success' => true, $getAuthor]);
    }
}
