<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TagsRequest;
use App\Models\Tag;
use DB;

class TagsController extends Controller
{

    public function index()
    {
        $tags = Tag::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }


    public function store(TagsRequest $request)
    {


        DB::beginTransaction();

        //validation
        $tag = Tag::create(['slug' => $request -> slug]);

        //save translations
        $tag->name = $request->name;
        $tag->save();
        DB::commit();
        return redirect()->route('admin.tags')->with(['success' =>  __('admin/message.successadd')]);


    }


    public function edit($id)
    {

        //get specific categories and its translations
          $tag = Tag::find($id);

        if (!$tag)
            return redirect()->route('admin.tags')->with(['error' => __('admin/message.notfound')]);

        return view('admin.tags.edit', compact('tag'));

    }


    public function update($id, TagsRequest $request)
    {
        try {
            //validation

            //update DB


             $tag = Tag::find($id);

            if (!$tag)
                return redirect()->route('admin.tags')->with(['error' => __('admin/message.error')]);


            DB::beginTransaction();


            $tag->update($request->except('_token', 'id'));  // update only for slug column

            //save translations
            $tag->name = $request->name;
            $tag->save();

            DB::commit();
            return redirect()->route('admin.tags')->with(['success' =>  __('admin/message.success')]);

        } catch (\Exception $ex) {

            DB::rollback();
            return redirect()->route('admin.tags')->with(['error' =>  __('admin/message.error')]);
        }

    }


    public function destroy($id)
    {
        try {
            //get specific categories and its translations
            $tags = Tag::find($id);

            if (!$tags)
                return redirect()->route('admin.tags')->with(['error' =>  __('admin/message.notfound')]);

            $tags->delete();

            return redirect()->route('admin.tags')->with(['success' =>  __('admin/message.successdelete')]);

        } catch (\Exception $ex) {
            return redirect()->route('admin.tags')->with(['error' =>  __('admin/message.error')]);
        }
    }

    
}
