<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\DB;
    use App\Models\User;
    use App\Models\Absensi;


    class AbsensiController extends Controller {
        
        public function absensi(Request $request){
            
            $data = $request->all();

            $validator = Validator::make($data,[
                
                'nama' => 'required|string',
                'status' => 'required|string',
            ]);

            if($validator->fails()){
                return response()->json(['errors' => $validator->messages()], 400);
            }
            try {
                DB::beginTransaction();
    
                $user = Absensi::create([
                    
                    'nama' => $request->nama,
                    'status' => $request->status,
                    'created_at' => now(),
                    'updated_at' => now(),
                    
                ]);
                
                
                return response()->json($user);
    
              DB::commit();
              
            } catch (\Throwable $th) {
                DB::rollback();
                return response()->json(['message' => $th->getMessage()], 500);
              }
            
            
        } 

        public function get(){
            $data = Absensi::make()->get();

            return response()->json(['message' => "Berhasil mendapatkan data", "data" => $data], 200);
        }
         
    }
?>
        