<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('isadmin');
    }

    public function table()
    {
        $user = User::get()
          ->where('role', '=', 'user');

        return DataTables::of($user)
        ->addColumn('action', function ($user) {
          return '
            <button class="btn btn-info btn-sm edit" data-id="'. $user->id .'"><i class="fa fa-pencil"></i></button>
            <button class="btn btn-danger btn-sm delete" data-id="'. $user->id .'"><i class="fa fa-times"></i></button>
          ';
        })
          ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'email' => 'required|email|unique:users',
          'name' => 'required',
          'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
          return response()->json([
            'errors' => $validator->getMessageBag()->toArray(),
          ]);
        } else {
          $user = new User;
          $user->email = $request->email;
          $user->name = $request->name;
          $user->password = bcrypt($request->password);
          $user->save();

          return response()->json([
            'msg' => $user,
          ]);
        }
    }

    public function edit($id)
    {
        $user = User::find($id);

        return response()->json([
          'msg' => $user,
        ]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
          'name' => 'required',
          'password' => 'nullable|min:6',
        ]);

        if ($validator->fails()) {
          return response()->json([
            'errors' => $validator->getMessageBag()->toArray(),
          ]);
        } else {
          $user = User::find($id);
          $user->name = $request->name;
          if ($request->password) {
            $user->password = bcrypt($request->password);
          }
          $user->save();

          return response()->json([
            'msg' => $user,
          ]);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
          'msg' => $user,
        ]);
    }
}
