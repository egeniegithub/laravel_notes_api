<?php

namespace App\Http\Controllers;

use App\Models\notes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class NotesController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api');
    }
	

    public function index()
    {
        $notes = notes::all();
        return response()->json($notes);
    }

    /**
     * Get my notes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function my_notes(notes $notes)
    {
        return response()->json($notes->where('user_id',auth()->user()->id)->get());
    }

    /**
     * Get all notes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter_notes(Request $request)
    {
        $notes = notes::where('name', 'LIKE', "%".$request->input('query')."%")
                ->orwhere('description', 'LIKE', "%".$request->input('query')."%")   
                ->get();
        return response()->json($notes);
    }

    /**
     * create notes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create_note(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'description' => 'required|string|between:2,100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user=["user_id"=>auth()->user()->id];
		$data=array_merge($request->all(),$user);
        $note = notes::create($data);
        if ($note) {
            return response()->json([
                'message' => 'note created successfully',
                'data'=> $note
            ], 201);
        }
    }

    /**
     * update notes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_note(Request $request)
    {
        
    
        $note = notes::findorfail($request->id);
        $note->name = $request->name;
        $note->description = $request->description;

        if ($note) {
            return response()->json([
                'message' => 'note updated successfully',
                'data'=> $note
            ], 201);
        }

    }

    /**
     * Delete note.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_note(Request $request)
    {
        $note = notes::findOrFail($request->id);
		$note->delete();
        if ($note) {
            return response()->json([
                'message' => 'note deleted successfully',
            ], 201);
        }
    }
}
