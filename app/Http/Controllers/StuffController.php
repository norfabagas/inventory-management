<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Stuff;
use Validator;
use DataTables;

class StuffController extends Controller
{
    public function table()
    {
        $stuff = Stuff::get();
        return DataTables::of($stuff)
          ->addColumn('Name', function ($stuff) {
            return $stuff->name;
          })
          ->addColumn('Category', function ($stuff) {
            $category = Category::find($stuff->category_id);
            return $category->name;
          })
          ->addColumn('Location', function ($stuff) {
            return $stuff->location;
          })
          ->addColumn('Quantity', function ($stuff) {
            return $stuff->quantity;
          })
          ->addColumn('Detail', function ($stuff) {
            return $stuff->detail;
          })
          ->addColumn('action', function ($stuff) {
            return '
              <button class="btn btn-warning btn-sm show" data-id="'. $stuff->id .'"><i class="fa fa-eye"></i></button>
              <button class="btn btn-info btn-sm edit" data-id="'. $stuff->id .'"><i class="fa fa-pencil"></i></button>
              <button class="btn btn-danger btn-sm delete" data-id="'. $stuff->id .'"><i class="fa fa-times"></i></button>
            ';
          })
          ->make(true);
    }

    public function index()
    {

    }

    public function show($id)
    {
        $stuff = Stuff::find($id);
        $cat_id = $stuff->category_id;
        $category = Category::find($cat_id);
        return response()->json([
          'msg' => $stuff,
          'category' => $category->name,
        ]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'name' => 'required',
          'category' => 'required',
          'condition' => 'required',
          'location' => 'required',
          'quantity' => 'required|integer',
          // 'detail' => 'required',
        ]);

        if ($validator->fails()) {
          return response()->json([
            'errors' => $validator->getMessageBag()->toArray(),
          ]);
        } else {
          $stuff = new Stuff;
          $stuff->name = $request->name;
          $stuff->category_id = $request->category;
          $stuff->condition = $request->condition;
          $stuff->location = $request->location;
          $stuff->quantity = $request->quantity;
          if ($request->size != '') {
              $stuff->size = $request->size;
          }
          if ($request->detail != '') {
              $stuff->detail = $request->detail;
          }
          $stuff->save();
          return response()->json([
            'msg' => $stuff,
          ]);
        }
    }

    public function edit($id)
    {
        $stuff = Stuff::find($id);

        return response()->json([
          'msg' => $stuff,
        ]);
    }

    public function update($id, Request $request)
    {
        $stuff = Stuff::find($id);

        $validator = Validator::make($request->all(), [
          'name' => 'required',
          'condition' => 'required',
          'location' => 'required',
          'quantity' => 'required|integer',
          // 'detail' => 'required',
        ]);

        if ($validator->fails()) {
          return response()->json([
            'errors' => $validator->getMessageBag()->toArray(),
          ]);
        } else {
          $stuff->name = $request->name;
          $stuff->condition = $request->condition;
          $stuff->location = $request->location;
          $stuff->quantity = $request->quantity;
          $stuff->size = $request->size;
          if ($request->category) {
            $stuff->category_id = $request->category;
          }
          $stuff->detail = $request->detail;
          $stuff->save();
          return response()->json([
            'msg' => $stuff,
          ]);
        }
    }

    public function destroy($id)
    {
        $stuff = Stuff::find($id);
        $stuff->delete();

        return response()->json([
          'msg' => $stuff,
        ]);
    }
}
