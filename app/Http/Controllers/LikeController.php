<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\notes;
use App\Models\like;
use Validator;

class LikeController extends Controller
{
    //
	/**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }
	
	/**
     * create notes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
	public function like_note(Request $request){
		
        $note = like::where('user_id',auth()->user()->id)->where('note_id',$request->note_id)->get();
		if(count($note)==1){
			return response()->json([
            'message' => 'you have already liked this note',
        ], 203);
		}
		else{
            $user=["user_id"=>auth()->user()->id];
            $data=array_merge($request->all(),$user);
			$like=like::create($data);
			if($like){
			return response()->json([
            'message' => 'you have liked the note',
            'data'=>$like
        ], 201);
			}else{
			return response()->json([
            'message' => 'you are unable to like this note',
        ], 203);
				
			}
			
			
		}
        
		
		
	}
}
