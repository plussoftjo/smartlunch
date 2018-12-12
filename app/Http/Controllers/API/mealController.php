<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\meal;
use Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 
use Validator;
class mealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(meal::orderBy('id','desc')->firstOrFail());
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
            'name' => 'required', 
            'price' => 'required', 
            'image' => 'required|image64:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],401);
        }

        $imageData = $request->get('image');
        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
        Image::make($request->get('image'))->resize(600,300)->save(public_path('images/meal/').$fileName);

        meal::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => 'images/meal/'.$fileName
        ]);
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
