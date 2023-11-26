<?php

namespace App\Http\Controllers;

use App\Models\Ostan;
use Illuminate\Http\Request;

class OstanController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('ostan-page', 1);
        $perPage = $request->query('perPage', 10);
        if ($request->user()->isAdmin) {
            return Ostan::query()
                ->orderBy('sal','desc')
                ->orderBy('mah','desc')
                ->orderBy('ostan','asc')
                ->paginate($perPage,'*','ostan-page',$page);
        }
    }
}
