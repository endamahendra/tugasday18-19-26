<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use DataTables;

class UserController extends Controller
{
    public function index(){
        return view('users.index');
    }

    public function getdata(){
        $users = User::all();
        return DataTables::of($users)->addColumn('action', function($user){
                return '<button class="btn btn-sm btn-warning" onclick="editUser(' . $user->id . ')">Edit</button>' .
                        '<button class="btn btn-sm btn-danger" onclick="deleteUser(' . $user->id . ')">Delete</button>';
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
        ]);

        return response()->json(['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:6',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->role = $request->input('role');
        $user->save();

        return response()->json(['user' => $user]);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return view('errors.404');
        }

        return response()->json(['user' => $user]);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return response()->json([], 204);
    }
}
