<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Coefficient;

class CoefficientController extends Controller
{
    protected $typeClass = 'coefficient';
    public function index(Request $request)
    {
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        $page = $request->query($this->typeClass.'-page', 1);
        $perPage = $request->query('perPage', 10);
        if ($request->user()->isAdmin) {
            return $class::query()
                ->with('news')
                ->paginate($perPage,'*',$this->typeClass.'-page',$page);
        }
    }

    public function indexAll(Request $request)
    {
        $result = collect();
        $coefficients=Coefficient::query()
            ->groupBy('name')
            ->get('name');

        foreach ($coefficients as $item){
            $result->put($item->name, [
                'news' => Coefficient::query()
                    ->where('name', $item->name)
                    ->with('news:id,name,title')
                    ->get(['title','name','id']),
            ]);
        }
        return $result;
    }

    public function store(Request $request)
    {
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        $class::unguard();
        $stored=$class::create($request->all());
        $class::reguard();
        return $stored;
    }

    public function update(Request $request)
    {
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        $class::unguard();
        $result=$class::find($request->id);
        $data = $request->except(['news','id', 'edit', 'show','deletedShow', 'deleted_at', 'created_at', 'updated_at', 'deleteShow']);
        if($result->update($data)){
            $class::reguard();
            return $result->refresh();
        }
        $class::reguard();
        return ['updated'=>false];
    }

    public function delete(Request $request)
    {
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        $result=$class::find($request->id);
        if($result->delete()){
            return ['deleted' => true,];
        }
        return ['deleted'=>false];
    }
}
