<?php

namespace App\Http\Controllers;

use App\Models\ViewModels\ValueModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function staticsData(Request $request)
    {
        $statics = ValueModel::query();
        if (!$request->user()->isAdmin) {
            $statics->limit(3);
        }
        if ($request->filled('year')) {
            $statics->where('year', $request->year);
        }
        if ($request->filled('type')) {
            switch ($request->type) {
                case 'month':
                    $statics->where('month', $request->month);
                    break;
                case '3month':
                    $statics->whereBetween('month', [$request->month[0], $request->month[1]]);
                    break;
            }
        }
        return $statics
            ->with('state')
            ->orderBy('mval','desc')
            ->get();
    }
}
