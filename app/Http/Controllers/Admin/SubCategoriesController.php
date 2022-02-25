<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\SubCategoryRequest;
use DB;
class SubCategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::child()->orderBy('id','DESC') -> paginate(PAGINATION_COUNT);
        return view('admin.subcategories.index', compact('categories'));
    }

    public function create()
    {
         $categories = Category::parent()->orderBy('id','DESC') -> get();
        return view('admin.subcategories.create',compact('categories'));
    }


    public function store(SubCategoryRequest $request)
    {

        try {

            DB::beginTransaction();

            //validation

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category = Category::create($request->except('_token'));

            //save translations
            $category->name = $request->name;
            $category->save();
            DB::commit();
            return redirect()->route('admin.subcategories')->with(['success' => __('admin/message.successadd')]);
           

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.subcategories')->with(['error' => __('admin/message.error')]);
        }

    }


    public function edit($id)
    {


        //get specific categories and its translations
        $category = Category::orderBy('id', 'DESC')->find($id);

        if (!$category)
            return redirect()->route('admin.subcategories')->with(['errsubcategoriesor' => __('admin/message.notfound')]);

        $categories = Category::parent()->orderBy('id','DESC') -> get();


        return view('admin.subcategories.edit', compact('category','categories'));

    }


    public function update($id, SubCategoryRequest $request)
    {
        try {
            //validation

            //update DB


            $category = Category::find($id);

            if (!$category)
                return redirect()->route('admin.subcategories')->with(['errsubcategoriesor' => __('admin/message.notfound')]);

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category->update($request->all());

            //save translations
            $category->name = $request->name;
            $category->save();

            return redirect()->route('admin.subcategories')->with(['success' => __('admin/message.success')]);
        } catch (\Exception $ex) {

            return redirect()->route('admin.subcategories')->with(['error' => __('admin/message.error')]);
        }

    }


    public function destroy($id)
    {

        try {
            //get specific categories and its translations
            $category = Category::orderBy('id', 'DESC')->find($id);

            if (!$category)
               return redirect()->route('admin.subcategories')->with(['errsubcategoriesor' => __('admin/message.notfound')]);

            $category->delete();

            return redirect()->route('admin.subcategories')->with(['success' => __('admin/message.successdelete')]);
            } catch (\Exception $ex) {

                     return redirect()->route('admin.subcategories')->with(['error' => __('admin/message.error')]);
           }
    }

}
