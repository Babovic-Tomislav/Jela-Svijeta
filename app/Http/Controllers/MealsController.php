<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListMeals;
use App\Repositories\MealsRepositoryInterface;
use Illuminate\Routing\Controller;

class MealsController extends Controller
{
    public function mealList(
        ListMeals $request,
        MealsRepositoryInterface $meals
    ) {
        $requestedData = $request->requestChecker();
        return $meals->getOutput($requestedData);
    }
}
