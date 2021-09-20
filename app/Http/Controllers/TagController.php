<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Tag;
class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tag::orderBy("id", "desc")->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            "tagName" => 'required'
        ]);
        return $create = Tag::create([
            "tagName" => $request->tagName
        ]);
        /* return response()->json([
            "msg" => "some error occured"
        ], 422); */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, [
            "tagName" => 'required'
        ]);
        $updated = Tag::where("id", $request->id)->update([
            "tagName" => $request->tagName
        ]);
        if($updated){
            return Tag::where("id", $request->id)->get();
        }else{
            return response()->json([
                "message" => "Something went wrong"
            ], 422);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $deleted = Tag::where("id", $request->id)->delete();
        if($deleted){
            return response()->json([
                "message" => "Tag has been deleted"
            ], 200);
        }else{
            return response()->json([
                "message" => "Something went wrong"
            ], 422);
        }
    }
}
