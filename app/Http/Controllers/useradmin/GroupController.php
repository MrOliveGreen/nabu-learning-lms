<?php

namespace App\Http\Controllers\useradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroupModel;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = GroupModel::create([
            'name'=>$request->post('name'),
            'description'=>$request->post('description'),
            'status'=>$request->post('status')
        ]);

        return response('successfully created', 200)->json($group);
        //
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
        $group = GroupModel::find($id);

        return response()->json($group);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = GroupModel::find($id);

        return response('ok', 200)->json($group);
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
        $group = GroupModel::find($id);
        $group->name = $request->input('category_name');
        $group->description = $request->input('category_description');
        // print_r($request->input('cate-status'));exit;
        $group->status = $request->input('cate_status');

        $group->update();
        //
        return response()->json($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = GroupModel::find($id);

        $group->status = 0;

        $group->update();

        return response('successfully deleted!', 200);
        //
    }
}
