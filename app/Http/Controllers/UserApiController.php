<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import the model
use App\Models\User;
use App\Models\Product;

class UserApiController extends Controller
{

    public function allUser()
    {

        $users=User::all();
        return response()->json($users);

    }

    public function userDetails($id)
    {

        $userDetails=User::find($id);

        $userProduct=Product::where('user_id',$id)->get();

        return response()->json([

           'userDetails'=>$userDetails,
           'userProduct'=>$userProduct,
           'name'=>$userDetails->name,

        ]);

    }

}
