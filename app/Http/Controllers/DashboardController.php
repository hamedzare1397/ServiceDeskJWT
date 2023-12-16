<?php

namespace App\Http\Controllers;

use App\Models\ViewModels\ValueModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function staticsData(Request $request)
    {
        $result = collect();
        $request->validate([
            'year_month' => 'required',
        ]);
        $year=Str::substr($request->year_month,0,4);
        $month=Str::substr($request->year_month,5,2);

        $statics = ValueModel::query()
            ->with('state')
            ->groupBy(['state_id', 'coefficient_id', 'year', 'month'])
            ->selectRaw('sum(mvalue) as mvalue,state_id,month,coefficient_id');
        $count = $statics->count();
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
        if ($request->user()->isAdmin) {
            $statics1 = clone $statics;
            $statics2 = clone $statics;
            $statics1->limit(3);
            $result->push(...$statics1
                ->orderBy('mvalue', 'desc')
                ->get());

            if ($count<=3) {
            }
            else{
                $result->push(...$statics2
                    ->orderBy('mvalue', 'asc')
                    ->selectRaw('sum(mvalue) as mvalue,state_id,month,coefficient_id')
                    ->limit($count-3)
                    ->get()->reverse());
            }
        }
        else{
            $result->push(...$statics
                ->orderBy('mvalue', 'desc')
                ->selectRaw('sum(mvalue) as mvalue,state_id,month,coefficient_id')
                ->get());
        }
        return $result;
    }
}
