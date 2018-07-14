<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use Validator;
use DataTables;

class PersonController extends Controller
{
    public function table()
    {
        $person = Person::get();

        return DataTables::of($person)
          ->addColumn('Name', function ($person) {
            return $person->name;
          })
          ->addColumn('Create Date', function ($person) {
            return $person->created_at;
          })
          ->addColumn('action', function ($person) {
            return '
              <button class="btn btn-danger btn-sm delete" data-id="'. $person->id .'"><i class="fa fa-times"></i></button>
            ';
          })
          ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'name' => 'required',
        ]);

        if ($validator->fails()) {
          return response()->json([
            'errors' => $validator->getMessageBag()->toArray(),
          ]);
        } else {
          $person = new Person;
          $person->name = $request->name;
          $person->save();

          return response()->json([
            'msg' => $person,
          ]);
        }
    }

    public function destroy($id)
    {
        $person = Person::find($id);
        $person->delete();

        return response()->json([
          'msg' => $person,
        ]);
    }
}
