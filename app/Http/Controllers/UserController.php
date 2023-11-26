<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('user-page', 1);
        $perPage = $request->query('perPage', 10);
        if ($request->user()->isAdmin) {
            return User::query()
                ->paginate($perPage,'*','user-page',$page);
        }
    }

    public function update(Request $request)
    {
        $request->dd();
    }
}
