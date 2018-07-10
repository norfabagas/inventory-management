<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use DataTables;
use Validator;

class CategoryController extends Controller
{
    public function table()
    {
        $category = Category::get();
        return DataTables::of($category)
          ->addColumn('Category', function ($category) {
            return $category->name;
          })
          ->addColumn('Create Date', function ($category) {
            return $category->created_at;
          })
          ->addColumn('action', function ($category) {
            return '
              <button class="btn btn-danger btn-sm delete" data-id="'. $category->id .'"><i class="fa fa-times"></i></button>
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
          $category = new Category;
          $category->name = $request->name;
          $category->save();

          return response()->json([
            'msg' => $category,
          ]);
        }
    }

    public function update()
    {

    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return response()->json([
          'msg' => $category,
        ]);
    }
}
