<?php

namespace App\Http\Controllers;

use App\Models\ViewModels\ValueModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isNull;

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
            ->with('state',function (BelongsTo  $query)use($request,$month,$year){
                $typeVal = $request->typeVal;
                $query->with('registerVal',function ($registerValQuery)use($request,$month,$year,$typeVal){
                switch ($request->type) {
                    case 'month':
                        $registerValQuery->where('month', $month);
                        break;
                    case '3month':
                        switch ($typeVal){
                            case 1:
                                $registerValQuery->whereBetween('month', [1, 3]);
                                break;
                            case 2:
                                $registerValQuery->whereBetween('month', [4,6]);
                                break;
                            case 3:
                                $registerValQuery->whereBetween('month', [7, 9]);
                                break;
                            case 4:
                                $registerValQuery->whereBetween('month', [10, 12]);
                                break;
                        }
                        break;
                    case '6month':
                        switch ($typeVal){
                            case 1:
                                $query->whereBetween('month', [1, 6]);
                                break;
                            case 2:
                                $query->whereBetween('month', [7,12]);
                                break;
                        }
                        break;
                    case 'year':
                        $registerValQuery->whereBetween('year',$year);
                        break;
                }
                });
            });
        $count = $statics->get()->count();
        $statics->where('year', $year);
        if ($request->filled('type')) {
            switch ($request->type) {
                case 'month':
                    $statics->where('month', $month)
                        ->selectRaw('
            RANK() OVER (PARTITION BY month,coefficient_id ORDER BY mvalue DESC) AS rank,
            sum(mvalue) as mvalue,state_id,month,coefficient_id')
                        ->groupBy(['state_id', 'coefficient_id', 'year', 'month']);
                    break;
                case '3month':
                    $typeVal = $request->typeVal;
                    switch ($typeVal){
                        case 1:
                            $statics->whereBetween('month', [1, 3]);
                            break;
                        case 2:
                            $statics->whereBetween('month', [4,6]);
                            break;
                        case 3:
                            $statics->whereBetween('month', [7, 9]);
                            break;
                        case 4:
                            $statics->whereBetween('month', [10, 12]);
                            break;
                    }
                    $statics
                        ->selectRaw('
            RANK() OVER (PARTITION BY month,coefficient_id ORDER BY mvalue DESC) AS rank,
            sum(mvalue) as mvalue,state_id,coefficient_id')
                        ->groupBy(['state_id', 'coefficient_id', 'year']);
                    break;
                case '6month':
                    $typeVal = $request->typeVal;
                    switch ($typeVal){
                        case 1:
                            $statics->whereBetween('month', [1, 6]);
                            break;
                        case 2:
                            $statics->whereBetween('month', [7,12]);
                            break;
                    }
                    $statics
                        ->selectRaw('
            RANK() OVER (PARTITION BY month,coefficient_id ORDER BY mvalue DESC) AS rank,
            sum(mvalue) as mvalue,state_id,coefficient_id')
                        ->groupBy(['state_id', 'coefficient_id', 'year']);
                    break;
                case 'year':
                    $typeVal = $request->typeVal;
                    $statics
                        ->selectRaw('
            RANK() OVER (PARTITION BY year,coefficient_id ORDER BY mvalue DESC) AS rank,
            sum(mvalue) as mvalue,state_id,coefficient_id')
                        ->groupBy(['state_id', 'coefficient_id', 'year']);
                    break;
            }
        }

//        dd($statics->toRawSql());
        $topStatics = clone $statics;
        $downStatics = clone $statics;
        $selfStatics = clone $statics;
        if (!$request->user()->isAdmin) {
            $topStatics->limit(3);
            $result->push(...$topStatics
                ->orderBy('mvalue', 'desc')
                ->get());

            if ($count>=3) {
                $result->push(...$downStatics
                    ->orderBy('mvalue', 'asc')
                    ->selectRaw('sum(mvalue) as mvalue,state_id,month,coefficient_id')
                    ->limit(3)
                    ->get()->reverse()
                );
            }
        }
        else{
            $result->push(...$statics
                ->orderBy('mvalue', 'desc')
                ->selectRaw('sum(mvalue) as mvalue,state_id,month,coefficient_id')
                ->get());
        }

        if (!is_null(
            $state=$request->user()->state
                    )) {
                        if (!$result->where('state_id',$state->id)->first()) {
                            $result->push(...$selfStatics
                                ->orderBy('mvalue', 'asc')
                                ->selectRaw('sum(mvalue) as mvalue,state_id,month,coefficient_id')
                                ->get()
                                ->where('state_id', $state->id)
                            );
                        }
        }
        return $result->sortBy('rank')->values();

    }
}
