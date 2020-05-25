<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = User::all();
        $message['success'] = true;
        $message['data'] = $result;
        return response($message,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = User::create($request->all());
        if($result){
            $message['success'] = true;
            $message['data'] = $result;
            return response($message,200);
        } else {
            $message['success'] = false;
            return response($message,404);
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
        $record = User::find($id);
        $message['success'] = true;
        $message['data'] = $record;
        return response($message,200);
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
        $record = User::findOrFail($id);
        if($record->update($request->all())){
            $message['success'] = true;
            $message['data'] = $record;
        } else {
            $message['success'] = false;
        }
        return response($message,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = User::findOrFail($id);
        if($record->delete()){
            $message['success'] = true;
            return response($message,200);
        } else {
            $message['success'] = false;
            return response($message,404);
        }
    }
}
