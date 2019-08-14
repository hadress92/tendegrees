<?php


namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $file = $request->file('profile_picture');
        $thumbnail_path = public_path('uploads/propic/thumbnail/');
        $original_path = public_path('uploads/propic/original/');
        if (!file_exists($thumbnail_path)) {
            mkdir($thumbnail_path, 0777, true);
        }
        if (!file_exists($original_path)) {
            mkdir($original_path, 0777, true);
        }
        $file_name = 'user_'. $user->id .'_'. str_random(32) . '.' . $file->getClientOriginalExtension();
        Image::make($file)
            ->resize(261,null,function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($original_path . $file_name)
            ->resize(90, 90)
            ->save($thumbnail_path . $file_name);

        $user->update(['profile_picture' => $file_name]);
        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }
}
