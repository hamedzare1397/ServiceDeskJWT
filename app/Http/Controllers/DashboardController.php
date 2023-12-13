<?php

namespace App\Http\Controllers;

use App\Models\ViewModels\ValueModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function staticsData(Request $request)
    {
        $request->validate([
            'year_month' => 'required',
        ]);
        $year=Str::substr($request->year_month,0,4);
        $month=Str::substr($request->year_month,5,2);

        $statics = ValueModel::query();
        if (!$request->user()->isAdmin) {
            $statics->limit(3);
        }
        $statics->where('year', $year);
        if (!$request->filled('type')) {

        }
        else {
            switch ($request->type) {
                case 'month':
                    $statics->where('month', $month);
                    break;
                case '3month':
                    $statics->whereBetween('month', [$request->month[0], $request->month[1]]);
                    break;
            }
        }
        return $statics
            ->with('state')
            ->groupBy(['state_id', 'coefficient_id', 'year','month'])
            ->orderBy('mvalue', 'desc')
            ->selectRaw('sum(mvalue) as mvalue,state_id,month,coefficient_id,year,month')
            ->get()
            ;
    }
}
