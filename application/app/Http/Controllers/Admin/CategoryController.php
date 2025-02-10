<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $pageTitle = 'Category';
        $categories = Category::latest()->with('parent')->paginate(getPaginate(10));
//        dd($categories);
        $parentCategories = Category::query()->whereNull('parent_id')->get();
        return view('admin.category.index',compact('pageTitle','categories','parentCategories'));
    }

    public function store(Request $request) {
      $request->validate(
        [
            'name' =>'required',
            'image' => ['required','image',new FileTypeValidate(['jpg','jpeg','png','gif'])],
            'parent_id' => 'nullable|exists:categories,id' // Validate if parent_id exists in categories table

        ]);

        $category = new Category();
        $category->name=$request->name;
        $category->description=$request->description;
        $category->status=1 ;
//      Assign parent_id if provided in the request
        if ($request->filled('parent_id')) {
            $category->parent_id = $request->parent_id;
        }
        if ($request->hasFile('image')) {
            try {
                $category->image = fileUploader($request->image, getFilePath('category'), getFileSize('category'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $category->save();
        $notify[] = ['success','Category has been created successfully'];
        return back()->withNotify($notify);

    }
    public function update(Request $request) {
      $request->validate(
        [
            'name' =>'required',
            'image' => ['nullable','image',new FileTypeValidate(['jpg','jpeg','png','gif'])],
            'parent_id' => 'nullable|exists:categories,id' // Validate if parent_id exists in categories table

        ]);

        $category =  Category::findOrFail($request->id);
        $category->name=$request->name;
        $category->description=$request->description;
        $category->status=$request->status ? 1 : 0;
        //Assign parent_id if provided in the request
        if ($request->filled('parent_id')) {
            $category->parent_id = $request->parent_id;
        }

        if ($request->hasFile('image')) {
            try {
                $old = $category->image;
                $category->image = fileUploader($request->image, getFilePath('category'), getFileSize('category'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $category->save();
        $notify[] = ['success','Category has been Updated successfully'];
        return back()->withNotify($notify);

    }
    public function delete(Request $request) {
        $category =  Category::findOrFail($request->id);
        $filePath  =  getFilePath('category') . '/' . $category->image;
        fileManager()->removeFile($filePath);
        $category->delete();
        $notify[] = ['success','Category has been deleted successfully'];
        return back()->withNotify($notify);
    }
}
