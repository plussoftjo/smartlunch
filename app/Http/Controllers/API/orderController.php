<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 
use App\meal;
use App\order;
class orderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return response()->json(order::where('user_id',Auth::id())->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [ 
            'time' => 'required', 
           
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],401);
        }

        /// $now 
        $now = Carbon::now();

        $day = $now->toDateString();

        $meal = meal::orderBy('id','desc')->firstOrFail();
        $id = $meal->id;

        order::create([
            'user_id' => Auth::id(),
            'meal_id' => $id,
            'time' => $request->time,
            'day' => $day
        ]);

        return response()->json('ok',200);


    }

    public function today() 
    {
        $now = Carbon::now();
        $day = $now->toDateString();

        return response()->json(order::where('day',$day)->get());

    }


    public function approve($id)
    {
        order::where('id',$id)->delete();
        return response()->json('ok',200);
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
