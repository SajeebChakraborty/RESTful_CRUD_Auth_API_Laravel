<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import the model
use App\Models\User;
use App\Models\Product;

//import the Validator
use Illuminate\Support\Facades\Validator;

use Auth;
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

        //202 request means data updated successfully
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

        //202 request means data updated successfully
        return response()->json([

            'message'=>'User Updated Successfully',

        ],202);


    }

    public function deleteUser($id)
    {

        User::where('id',$id)->delete();

        return response()->json([

            'message'=>'User Deleted Successfully',

        ],200);
    
    }

    public function deleteUserWithJson(Request $req)
    {

        $data=$req->all();

        User::where('id',$data['id'])->delete();

        return response()->json([

            'message'=>'User Deleted Successfully',

        ],200);

    }

    public function deleteMultipleUser($ids)
    {

        $ids=explode(',',$ids);

        User::whereIn('id',$ids)->delete();

        return response()->json([

            'message'=>'User Deleted Successfully',

        ],200);

    }

    public function registerUserWithPassport(Request $req)
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

        if(Auth::attempt(['email'=>$req->email,'password'=>$req->password]))
        {

            $user=User::where('email',$req->email)->first();

            $access_token=$user->createToken($req->email)->accessToken;

            User::where('email',$req->email)->update([

                'access_token'=>$access_token,

            ]);

            return response()->json([

                'message'=>'User registered Successfully',
                'access_token'=>$access_token,

            ],201);


        }
        else
        {

            return response()->json([

                'message'=>'Opps! Something went wrong',

            ],422);

        }


    }

    public function loginUserWithPassport(Request $req)
    {
        //validate the request
        $rules=[

            'email'=>'required|email|exists:users',
            'password'=>'required|min:6',

        ];

        $customMessage=[

            'email.required'=>'Email is required',
            'email.email'=>'Email is invalid',
            'email.exists'=>'Email do not exists',
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

        if(Auth::attempt(['email'=>$req->email,'password'=>$req->password]))
        {

            $user=User::where('email',$req->email)->first();

            $access_token=$user->createToken($req->email)->accessToken;

            User::where('email',$req->email)->update([

                'access_token'=>$access_token,

            ]);

            return response()->json([

                'message'=>'User successfully login',
                'access_token'=>$access_token,

            ],201);


        }
        else
        {

            return response()->json([

                'message'=>'Invalid email or password',

            ],422);

        }
   
    }

}
