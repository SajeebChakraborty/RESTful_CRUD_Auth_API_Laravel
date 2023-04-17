<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import the model
use App\Models\User;
use App\Models\Product;

class ProductApiController extends Controller
{
    
    public function productList(Request $req)
    {

        $header= $req->header('Authorization');

        if($header=='')
        {
            return response()->json([

                'message'=>'Authorization is required',

            ]);
        }
        else
        {

            if($header=="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c")
            {

                $products=Product::all();
                return response()->json($products);

            }
            else
            {

                return response()->json([

                    'message'=>'Invalid Authorization',

                ]);

            }

        }


   
    }

}
