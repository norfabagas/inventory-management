<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stuff;
use App\Drop;
// use App\Person;
use DataTables;
use Validator;
use DB;

class DropController extends Controller
{
    public function table()
    {
        $drop = DB::table('drops')
          ->join('stuffs', 'drops.stuff_id', '=', 'stuffs.id')
          // ->join('people', 'drops.person_id', '=', 'people.id')
          // ->select('drops.*', 'stuffs.name as stuff_name', 'people.name as person_name')
          ->select('drops.*', 'stuffs.name as stuff_name')
          ->get();
        return DataTables::of($drop)
          ->addColumn('action', function ($drop) {
            return '
              <button class="btn btn-warning btn-sm show" data-id="'. $drop->id .'"><i class="fa fa-eye"></i></button>
              <button class="btn btn-info btn-sm edit" data-id="'. $drop->id .'"><i class="fa fa-pencil"></i></button>
              <button class="btn btn-danger btn-sm delete" data-id="'. $drop->id .'"><i class="fa fa-times"></i></button>
            ';
          })
          ->make(true);
    }

    public function show($id)
    {
        $drop = Drop::find($id);
        $stuff = Stuff::get()->where('id', '=', $drop->stuff_id)->first();
        // $person = Person::get()->where('id', '=', $drop->person_id)->first();

        return response()->json([
          'drop' => $drop,
          'stuff' => $stuff,
          'person' => $drop->person,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'stuff' => 'required',
          'detail' => 'required',
          'quantity' => 'required|integer',
          'person' => 'required',
        ]);

        if ($validator->fails()) {
          return response()->json([
            'errors' => $validator->getMessageBag()->toArray(),
          ]);
        } else {
          $drop = new Drop;
          $drop->stuff_id = $request->stuff;
          $drop->detail = $request->detail;
          $drop->quantity = $request->quantity;
          // $drop->person_id = $request->person;
          $drop->person = $request->person;
          $drop->save();

          $stuff = Stuff::get()->where('id', '=', $request->stuff)->first();
          $stuff->quantity = $stuff->quantity - $request->quantity;
          $stuff->save();

          return response()->json([
            'msg' =>  $drop,
          ]);
        }
    }

    public function edit($id)
    {
        $drop = Drop::find($id);

        return response()->json([
          'msg' => $drop,
        ]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
          'detail' => 'required',
          'quantity' => 'required|integer',
          'person' => 'required',
        ]);

        if ($validator->fails()) {
          return response()->json([
            'errors' => $validator->getMessageBag()->toArray(),
          ]);
        } else {
          $drop = Drop::find($id);

          $adder = $drop->quantity;
          $stuff_id = $drop->stuff_id;

          $drop->detail = $request->detail;
          $drop->quantity = $request->quantity;
          // if ($request->person) {
          //   $drop->person_id = $request->person;
          // }
          $drop->person = $request->person;
          $drop->save();

          $stuff = Stuff::get()->where('id', '=', $stuff_id)->first();
          $stuff->quantity = $stuff->quantity + $adder - $request->quantity;
          $stuff->save();

          return response()->json([
            'msg' => $drop,
          ]);
        }
    }

    public function destroy($id)
    {
        $drop = Drop::find($id);

        $adder = $drop->quantity;
        $stuff_id =  $drop->stuff_id;

        $drop->delete();
        $stuff = Stuff::get()->where('id', '=', $stuff_id)->first();
        $stuff->quantity = $stuff->quantity + $adder;
        $stuff->save();

        return response()->json([
          'msg' => $drop,
        ]);
    }
}
