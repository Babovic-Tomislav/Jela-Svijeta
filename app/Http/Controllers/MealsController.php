<?php

namespace App\Http\Controllers;


use App\Http\Requests\ListMeals;
use App\Repositories\MealsRepositoryInterface;

use Illuminate\Routing\Controller;




class MealsController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mealList(ListMeals $request, MealsRepositoryInterface $meals)
    {

        $requestedData = $request->RequestChecker();

        $output = $meals->getOutput($requestedData);

        


        return $output;
    }
    

   
}
