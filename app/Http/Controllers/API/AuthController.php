<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\User;
use DB;


class AuthController extends Controller
{
    //Register

    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => '|required|same:password',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $user->save();
        return response()->json(['message' => 'user has been registered'], 200);       
}

//login function

    public function login(Request $request)
    {
        $request-> validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'remember' => 'boolean'
            
        ]);

        $login = request(['email', 'password']);

        if(!Auth::attempt($login))
        {
            return response(['message'=> 'Invalid login credentials'], 401);
        }

        $user = $request->user();
        $accessToken = $user->createToken('Personal Access Token');
        $token = $accessToken->token;
        $token ->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json(['data'=>[
            'user' => Auth::user(),
            'access_token' => $accessToken->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($accessToken->token->expires_at)->toDateTimeString()
        ]]);
    }
    //logout function

    public function socialLogin(Request $request)
{
    $request->input('provider_name');
    $token = $request->input('access_token');
    // get the provider's user. (In the provider server)
    $providerUser = Socialite::driver($provider)->userFromToken($token);
    // check if access token exists etc..
    // search for a user in our server with the specified provider id and provider name
    $user = User::where('provider_name', $provider)->where('provider_id', $providerUser->id)->first();
    // if there is no record with these data, create a new user
    if($user == null){
        $user = User::create([
            'provider_name' => $provider,
            'provider_id' => $providerUser->id,
        ]);
    }
    // create a token for the user, so they can login
    $token = $user->createToken(env('APP_NAME'))->accessToken;
    // return the token for usage
    return response()->json([
        'success' => true,
        'token' => $token
    ]);
}

    public function logout() {

        if(Auth::check()) {
        Auth::user()->token()->revoke();
        return response()->json(["status" => "success", "error" => false, "message" => "Success! You are logged out."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! You are already logged out."], 403);
    }

    public function updateProfile(Request $request){
        try {
                $validator = Validator::make($request->all(),[
                'first_name' => 'nullable|min:2|max:45',
                'last_name' => 'nullable|min:2|max:45',
                'phone' => 'nullable',
                'address' => 'nullable|min:2|max:200',
                'profile_picture' => 'nullable|image'
            ]);
                if($validator->fails()){
                    $error = $validator->errors()->all()[0];
                    return response()->json(['status'=>'false', 'message'=>$error, 'data'=>[]],422);
                }else{
                    $user = user::find($request->user()->id);
                    $user->first_name = $request->first_name;
                    $user->last_name = $request->last_name;
                    $user->phone = preg_replace('/^0/','+234',$request->phone);
                    $user->address = $request->address;
                    if($request->profile_picture && $request->profile_picture->isValid())
                    {
                        $file_name = time().'.'.$request->profile_picture->extension();
                        $request->profile_picture->move(public_path('images'),$file_name);
                        $path = "images/$file_name";
                        $user->profile_picture = $path;
                    }
                            $user->update();
                            return response()->json(['status'=>'true', 'message'=>"profile updated suuccessfully", 'data'=>$user]);
                }
    
        }catch (\Exception $e){
                    return response()->json(['status'=>'false', 'message'=>$e->getMessage(), 'data'=>[]], 500);
        }
    }



    public function updateProfileLater(Request $request){
        try {
                $validator = Validator::make($request->all(),[
                    'country' => 'nullable',
                    'state' => 'nullable',
                    'facebook' => 'nullable',
                    'instalgram' => 'nullable',
                    'organisation' => 'nullable',
                    'twitter' => 'nullable',
                    'note' => 'nullable'
            ]);
                if($validator->fails()){
                    $error = $validator->errors()->all()[0];
                    return response()->json(['status'=>'false', 'message'=>$error, 'data'=>[]],422);
                }else{
                    $user = user::find($request->user()->id);
                    $user->state = $request->state;
                    $user->country = $request->country;
                    $user->facebook = $request->facebook;
                    $user->instalgram = $request->instalgram;
                    $user->organisation = $request->organisation;
                    $user->note = $request->note;
                    $user->twitter = $request->twitter;
                            $user->update();
                            return response()->json(['status'=>'true', 'message'=>"profile updated suuccessfully", 'data'=>$user]);
                }
    
        }catch (\Exception $e){
                    return response()->json(['status'=>'false', 'message'=>$e->getMessage(), 'data'=>[]], 500);
        }
    }


    public function getProfile(){
        $id = Auth::user();
        $getProfileFirst = user::where('id', $id->id)->select('first_name', 'last_name', 'phone', 'address', 'profile_picture')->get();
        return response()->json($getProfileFirst);

    }


    public function getProfileLater() {
        try {
            $id = Auth::user();
            $getProfileFirst = user::where('id', $id->id)->select('state', 'country', 'twitter', 'facebook', 'instalgram', 'organisation', 'note')->get();
            return response()->json($getProfileFirst);
        }
        catch(NotFoundHttpException $exception) {
            return response()->json(["status" => "failed", "error" => $exception], 401);
        }
    }

    public function updateUsertype(Request $request)
    {
    $user = User::where('id', $request->user()->id)->firstOrFail(); 
    $user->usertype = $request->usertype;
    $user->saveOrFail();
    return response()->json(['success' => true]);
    }
    
    public function edit(Request $request, $id){    
    {
        //
        $user=user::find($id);
        $this->validate($request,[
                'last_name'=>'nullable',
                'phone'=>'nullable',
                'facebook' => 'nullable',
                'instalgram' => 'nullable',
                'twitter' => 'nullable',
                'profile_picture' => 'nullable|image'

        ]);
        $name=request('last_name');
        $phone= preg_replace('/^0/','+234',request('phone'));
                    $facebook = request('facebook');
                    $instalgram = request('instalgram');
                    $twitter = request('twitter');
        $image=request('profile_picture'); 
        if($image){
            $file_name = time().'.'.$request->profile_picture->extension();
            $request->profile_picture->move(public_path('images'),$file_name);
            $path = "public/images/$file_name";
            $user->profile_picture = $path;
            DB::table('users')
                ->where('id',$id)
                ->update([
                    'profile_picture'=>$image,
                ]);
        }
        DB::table('users')
                ->where('id',$id)
                ->update([
                    'name'=>$name,
                    'email'=>$email,
                    'phone'=>$phone,
                    'facebook'=>$facebook,
                    'instalgram'=>$instalgram,
                    'twitter'=>$twitter,
                ]);
       
                return response()->json(['status'=>'true', 'message'=>"profile Edited suuccessfully"]);  
    }


    
    }



    
}

