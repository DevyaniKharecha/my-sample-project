<?php

namespace App\ChartHelpers;

use DB;
use Illuminate\Http\Request;

class BuildsCharts
{

    public function buildChart(Request $request, Array $tables)
    {

        if ($request->has('period')) {

            switch ($request->get('period')) {

                case '3months' :


                    $chart =  new FormatsThreeMonths($tables);

                    return response()->json($chart->data);

                    break;


                case '1week' :


                    $chart = new FormatsOneWeek($tables);

                    return response()->json($chart->data);

                    break;


                case '30days' :

                    $chart = new FormatsThirtyDays($tables);

                    return response()->json($chart->data);

                    break;


            }


        }

        // One year is default for chart

        $chart = new FormatsOneYear($tables);

        return response()->json($chart->data);


    }

    

}