<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register', 'googleSign']]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'account doesn\'t exist. please sign up first'], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    public function register(Request $request){

        $this->validate($request, [
            'firstName' => 'required|string|max:25',
            'familyName' => 'required|string|max:25',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'firstName' => $request->firstName,
            'familyName' => $request->familyName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function googleSign(Request $request){
        $user = User::where('email','=',$request->email)->get();
        if( count($user) > 0 ){
            $user = $request->only(['email', 'password']);
            $token = Auth::attempt($user);
            $user = Auth::user();

            return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

        }
        else{
            $this->validate($request, [
                'firstName' => 'required|string|max:25',
                'familyName' => 'required|string|max:25',
                'email' => 'required|string|email|max:255|unique:users',
            ]);

            $user = User::create([
                'firstName' => $request->firstName,
                'familyName' => $request->familyName,
                'email' => $request->email,
                'password' => Hash::make(null)
            ]);

            $token = Auth::login($user);
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

        }


    }

}


// print(user?.displayName);
//           print(user?.displayName);

//           List<String>? username = user?.displayName?.split(' ');
//           print('firstName= ${username?[0]}');
//           print('firstName= ${username?[1]}');

//           userGoogleSign(user?.email, username?[0], username?[1] );


// void _loadUserInfo(BuildContext contxt) async {
//     String token = await getToken();
//     if (token != '') {
//       ApiResponse response = await getUserInfo();
//       if (response.error == null ){
//         Navigator.pushNamed(contxt,HomeScreen.routeName);
//       } else {
//         Navigator.pushNamed(contxt,SplashScreen.routeName);
//       }
//     }
//   }




