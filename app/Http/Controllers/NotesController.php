<?php

namespace App\Http\Controllers;

use App\Models\notes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class NotesController extends Controller
{

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
    public function my_notes()
    {
        $my_notes = notes::where('user_id', auth()->user()->id)->get();
        return response()->json($my_notes);
    }

    /**
     * Get all notes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter($query)
    {
        $notes = notes::where('name', 'like', '%' . $query . '%')
            ->orwhere('description', 'like', '%' . $query . '%')
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

        $note = notes::create($request->all());
        if ($note) {
            return response()->json([
                'message' => 'note created successfully',
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'description' => 'required|string|between:2,100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $note = notes::find($request->id);
        $note->name = $request->name;
        $note->description = $request->description;

        if ($note) {
            return response()->json([
                'message' => 'note updated successfully',
            ], 201);
        }

    }

    /**
     * Delete note.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_note($id)
    {
        $note = notes::find($id)->delete();
        if ($note) {
            return response()->json([
                'message' => 'note deleted successfully',
            ], 201);
        }
    }
}
