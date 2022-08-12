<?php

namespace App\Http\Controllers\api;

use App\Exceptions\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\Models\RealState;
use Illuminate\Http\Request;

class RealStateController extends Controller{
    private $realState;

    public function __construct(RealState $realState){
        $this->realState = $realState;
    }

    public function index(){
        $realState = $this->realState->paginate(10);
        return response()->json($realState, 200);
    }

    public function show($real_state_id){
        try {
            $realState = $this->realState->findOrFail($real_state_id);
        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json([$message->getMessage()]);
        }
        return response()->json(['data'=>$realState], 200);
    }

    public function store(RealStateRequest $request){
        $data = $request->all();
        try {
           $realState = $this->realState->create($data);
           if (isset($data['categories']) && count($data['categories'])){
               $realState->categories()->sync($data['categories']);
           }
           return response()->json([
               'data'=>[
                   'msg'=>'Imóvel Cadastrado com sucesso!'
               ]
           ], 200);
        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json([$message->getMessage()]);
        }
    }

    public function update($real_state_id, RealStateRequest $request){
        $data = $request->all();
        try {
            $realState = $this->realState->findOrFail($real_state_id);
            $realState->update($data);
            if (isset($data['categories']) && count($data['categories'])){
                $realState->categories()->sync($data['categories']);
            }
            return response()->json([
                'data'=>[
                    'msg'=>'Imóvel Alterado com sucesso!'
                ]
            ], 200);
        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json([$message->getMessage()]);
        }
    }

    public function destroy($real_state_id){
        try {
            $realState = $this->realState->findOrFail($real_state_id);
            $realState->delete();
            return response()->json([
                'data'=>[
                    'msg'=>'Imóvel Removido com sucesso!'
                ]
            ], 200);
        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json([$message->getMessage()]);
        }
    }
}
