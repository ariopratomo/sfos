<?php

namespace App\Http\Controllers\API;

use App\Models\Food;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;

class FoodController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if ($can = can('food-list')) {
            $foods = Food::all();
            return $this->sendResponse($foods->toArray(), 'Foods retrieved successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($can = can('food-create')){
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'category_id' => 'required',
            ]);
            // random food image url
            $input['image'] = 'https://picsum.photos/200/300';
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $food = Food::create($input);
            return $this->sendResponse($food->toArray(), 'Food created successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Food $food)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        //
    }
}
