<?php

namespace App\Http\Controllers;

use App\Model\Tap;
use Illuminate\Http\Request;

class TapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Tap::all();

        if(count($result) > 0) {
            $message['success'] = true;
            $message['data'] = $result;
        } else {
            $message['success'] = false;
        }
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
        $tap_parent_id = $request->tap_parent_id;
        $tap_collection_id = $request->tap_collection_id;

        if($tap_parent_id == ''){
            $result = new Tap();
            $result->tap_parent_id = bin2hex(random_bytes(8));
            $result->tap_collection_id = bin2hex(random_bytes(8));
            $result->tap_in = date('Y-m-d H:i:s');
        } elseif ($tap_collection_id == '') {
            $result = new Tap();
            $result->tap_parent_id = $tap_parent_id;
            $result->tap_collection_id = bin2hex(random_bytes(8));
            $result->tap_in = date('Y-m-d H:i:s');
        } else {
            $result = Tap::where(['tap_parent_id' => $tap_parent_id, 'tap_collection_id' => $tap_collection_id])->first();
            $result->tap_parent_id = $tap_parent_id;
            $result->tap_collection_id = $tap_collection_id;
            $result->tap_out = date('Y-m-d H:i:s');
            if($result->save()){
                $message['success'] = true;
                $message['data'] = $result;
                return response($message,200);
            } else {
                $message['success'] = false;
                return response($message,404);
            }
        }

        $result->user_id = $request->user_id;
        $result->tap_date = date('Y-m-d');
        //$result->tap_time = date('H:i:s');
        $result->tap_day = date('l');

        try
        {
            if($result->save()){
                $message['success'] = true;
                $message['data'] = $result;
                return response($message,200);
            } else {
                $message['success'] = false;
                return response($message,404);
            }
        }
        catch(\Exception $e)
        {
            $error_code = $e->errorInfo[1];
            $error_message = '';
            if($error_code == 1062){
                $error_message = 'Duplicate tapout entry problem. Already tapped out for provided collection ID';
            }
            $message['success'] = false;
            $message['message'] = $error_message;
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
        $result = Tap::where('user_id', $id)->orderBy('id', 'asc')->get();

        $output = array();
        $index = 0;

        $collection_array = array();
        $index2 = 0;
        foreach ($result as $key => $value){
            $collection_array[$value['tap_parent_id']][$value['tap_date']]['id'] = $value['tap_parent_id'];
            $collection_array[$value['tap_parent_id']][$value['tap_date']]['date'] = $value['tap_date'];
            $collection_array[$value['tap_parent_id']][$value['tap_date']]['weekDay'] = $value['tap_day'];

            $collection_array[$value['tap_parent_id']][$value['tap_date']]['tapCollection'][$index2]['id'] = $value['tap_collection_id'];
            $collection_array[$value['tap_parent_id']][$value['tap_date']]['tapCollection'][$index2]['tap_in'] = $value['tap_in'];
            $collection_array[$value['tap_parent_id']][$value['tap_date']]['tapCollection'][$index2]['tap_out'] = $value['tap_out'];
            $index2++;
        }

        $new_array = array();
        foreach ($collection_array as $key => $value){
            $new_array[] = $value;
        }

        if(!empty($new_array)) {
            $message['success'] = true;
            $message['data'] = $new_array;
        } else {
            $message['success'] = false;
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
