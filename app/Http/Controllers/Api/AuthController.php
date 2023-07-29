<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\DB;
    use App\Models\User;
    use App\Models\Absensi;
    use Tymon\JWTAuth\Facades\JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;


    class AuthController extends Controller {
        public function register(Request $request){
            $data = $request->all();

            $validator = Validator::make($data,[
                'nama' => 'required|string',
                'email' => 'required|email',
                'username' => 'required|string|min:6',
                'password' => 'required|string|min:6',
                'type_user' => 'required|in:admin,karyawan',
            ]);

            if($validator -> fails()){
                return response()->json(['errors' => $validator->messages()], 400);
            }

            $user = User::where('email', $request->email)->exists();

            if($user){
                return response()->json(['message' => 'Email already token'],  409);
            }

            
            try {
              DB::beginTransaction();
  
              $user = User::create([
                  'nama' => $request->nama,
                  'email' => $request->email,
                  'username' => $request->username,
                  'password' => bcrypt($request->password),
                  'type_user' => $request->type_user,
                  'created_at' => now(),
                  'updated_at' => now(),
                  
              ]);
              
              
              
  
            DB::commit();

            $token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password]);

            $userResponse = getUser($request->email);
                $userResponse->token = $token;
                $userResponse->token_expires_in = auth()->factory()->getTTL() * 60;
                $userResponse->token_type = 'admin/karyawan';

                

                return response()->json($userResponse);    
            
          } catch (\Throwable $th) {
            
            return response()->json(['message' => $th->getMessage()], 500);
        }

        }

        public function login(Request $request){
            $credentials = $request->only('email','password');

            $validator = Validator::make($credentials, [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            if($validator->fails()){
                return response()->json(['errors' => $validator->messages()], 400);
            }

            try {
                $token = JWTAuth::attempt($credentials);


                if(!$token){
                    return response()->json(['message' => 'Login credentials are invalid'], 300);


                }

                $userResponse = getUser($request->email);
                $userResponse->token = $token;
                $userResponse->token_expires_in = auth()->factory()->getTTL() * 60;
                $userResponse->token_type = 'admin';


                return response()->json($userResponse);
            } catch (\JWTException $th) {
                return response()->json(['message' => $th->getMessage()], 500);
            }
        }

        
    }
?>