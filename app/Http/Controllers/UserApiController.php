<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import the model
use App\Models\User;
use App\Models\Product;

//import the Validator
use Illuminate\Support\Facades\Validator;

use Hash;

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

    //create single user
    public function createUser(Request $req)
    {

        //validate the request
        $rules=[

            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',

        ];

        $customMessage=[

            'name.required'=>'Name is required',
            'email.required'=>'Email is required',
            'email.email'=>'Email is invalid',
            'email.unique'=>'Email is already taken',
            'password.required'=>'Password is required',
            'password.min'=>'Password must be at least 6 characters',

        ];

        $validation=Validator::make($req->all(),$rules,$customMessage);

        //here 422 means unprocessable entity
        if($validation->fails())
        {

            return response()->json([

                'message'=>$validation->errors(),

            ],422);

        }

        User::create([

            'name'=>$req->name,
            'email'=>$req->email,
            'password'=>Hash::make($req->password),

        ]);

        //201 request means data created successfully
        return response()->json([

            'message'=>'User Created Successfully',

        ],201);

    }
    public function createMultipleUser(Request $req)
    {

        $data=$req->all();

        //validate the request
        $rules=[

            'users.*.name'=>'required',
            'users.*.email'=>'required|email|unique:users',
            'users.*.password'=>'required|min:6',

        ];

        $customMessage=[

            'users.*.name.required'=>'Name is required',
            'users.*.email.required'=>'Email is required',
            'users.*.email.email'=>'Email is invalid',
            'users.*.email.unique'=>'Email is already taken',
            'users.*.password.required'=>'Password is required',
            'users.*.password.min'=>'Password must be at least 6 characters',

        ];

        $validation=Validator::make($req->all(),$rules,$customMessage);

        //here 422 means unprocessable entity
        if($validation->fails())
        {

            return response()->json([

                'message'=>$validation->errors(),

            ],422);

        }

        foreach($data['users'] as $user)
        {

            User::create([

                'name'=>$user['name'],
                'email'=>$user['email'],
                'password'=>Hash::make($user['password']),

            ]);

        }
     

        //201 request means data created successfully
        return response()->json([

            'message'=>'User Created Successfully',

        ],201);


    }

    public function updateUser(Request $req,$id)
    {

        //validate the request
        $rules=[

            'name'=>'required',
            'password'=>'required|min:6',

        ];

        $customMessage=[

            'name.required'=>'Name is required',
            'password.required'=>'Password is required',
            'password.min'=>'Password must be at least 6 characters',

        ];

        $validation=Validator::make($req->all(),$rules,$customMessage);

        //here 422 means unprocessable entity
        if($validation->fails())
        {

            return response()->json([

                'message'=>$validation->errors(),

            ],422);

        }

        User::where('id',$id)->Update([

            'name'=>$req->name,
            'password'=>Hash::make($req->password),

        ]);

        //201 request means data created successfully
        return response()->json([

            'message'=>'User Updated Successfully',

        ],202);
    }

    public function updateUserSingleRecord(Request $req,$id)
    {

          //validate the request
          $rules=[

            'name'=>'required',

        ];

        $customMessage=[

            'name.required'=>'Name is required',

        ];

        $validation=Validator::make($req->all(),$rules,$customMessage);

        //here 422 means unprocessable entity
        if($validation->fails())
        {

            return response()->json([

                'message'=>$validation->errors(),

            ],422);

        }

        User::where('id',$id)->Update([

            'name'=>$req->name,

        ]);

        //201 request means data created successfully
        return response()->json([

            'message'=>'User Updated Successfully',

        ],202);


    }

}
