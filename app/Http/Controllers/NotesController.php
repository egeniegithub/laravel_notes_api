<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class NotesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $notes = Note::all();
        return response()->json(["status" => "success", "message" => "Notes Listed!", "data" => $notes]);
    }

    /**
     * Get my notes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function my_notes(Request $request,Note $note)
    {
        $query = $request->input('query');
        $my_notes=[];
        if (!empty($query) && $query !== null && $query !== '') {
            $user_notes = Note::where('name', 'LIKE', "%" . $request->input('query') . "%")
                ->orwhere('description', 'LIKE', "%" . $request->input('query') . "%")
                ->where('user_id', auth()->user()->id)->get();
        } else {
            $user_notes = $note->where('user_id', auth()->user()->id)->get();
        }

        return response()->json(["status" => "success", "message" => "Notes Listed!", "data" => $user_notes]);
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
            return response()->json(["status" => "failed", "data" => $validator->errors()->toJson()], 400);
        }

        $user = ["user_id" => auth()->user()->id];
        $data = array_merge($request->all(), $user);
        $note = Note::create($data);
        if ($note) {
            return response()->json([
                "status" => "success",
                'message' => 'note created successfully',
                'data' => $note,
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

        $note = Note::findorfail($request->id);
        $note->name = $request->name;
        $note->description = $request->description;

        if ($note) {
            return response()->json([
                "status" => "success",
                'message' => 'note updated successfully',
                'data' => $note,
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
        $note = Note::findOrFail($request->id);
        $note->delete();
        if ($note) {
            return response()->json([
                "status" => "success",
                'message' => 'note deleted successfully',
                "data" => [],
            ], 201);
        }
    }

    /**
     * Like notes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(Request $request)
    {
        $note_id = $request->input('note_id');

        $note = Note::where('id', $note_id)->get()->toArray();
    
        if ($note[0]['user_id']!== Auth::user()->id) {
            $like = Like::create(["user_id" => Auth::user()->id, 'note_id' => $note_id]);
            return response()->json([
                "status" => "success",
                'message' => 'you have liked the note',
                'data' => $like,
            ], 201);
        } else {
            return response()->json([
                "status" => "failed",
                'message' => 'You cannot Like your own note!',
                "data" => [],
            ], 203);
        }
    }
}
