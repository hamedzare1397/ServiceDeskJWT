<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\State;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Coefficient;

class RegisterController extends Controller
{
    protected $typeClass = 'register';
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

    public function edit(Request $request)
    {
        $coefficeint=$request->input('coefficeint');
        $yaerMonth=$request->input('yearMonth');
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        $query = State::query();
        $res=$query->get(['id','name','title','user_id']);
        $result = collect();
        foreach ($res as $state){
            $result->put(
                $state->name,
                [
                    ...$state->toArray(),
                    'registers'=>$state->registers()
                        ->where('year_month', $request->yearMonth)
                        ->where('coefficient_id', $request->coefficient)
                        ->get(['state_id','news_id','coefficient_id','id','value','year_month',])
                        ->keyBy('news_id')
                        ->toArray()
                ]

            );
        }
        $existsAnOther=Register::query()->whereNot('coefficient_id',$request->coefficient)
            ->where('year_month',$request->yearMonth)
            ->exists();

        return ['state'=>$result,'existsAnOther'=>$existsAnOther];
    }

    public function store(Request $request)
    {
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        $coefficients = $request->coefficient;
        $val=$request->val;
        $result = collect();
        foreach ($coefficients as $item){
            $register=Register::query()->where('news_id', $item['pivot']['news_id'])
                ->where('coefficient_id', $item['pivot']['coefficient_id'])
                ->where('state_id', $request->state)
                ->where('year_month', $request->yearMonth)
                ->first()
            ;
            if (is_null($register))
            {
                $register = new Register();
            }
            $register->coefficient_id = $item['pivot']['coefficient_id'];
            $register->news_id = $item['pivot']['news_id'];

            $register->value = $val[$item['pivot']['news_id']];
            $register->state_id=$request->state;
            $register->year_month=$request->yearMonth;
            $register->creator_id=$request->user()->id;
            $register->save();
            $result->put($register->news_id, $register);
        }
        return $result;
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
