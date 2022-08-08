<?php

namespace App\Http\Controllers\api;

use App\Exceptions\ApiMessages;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(){
        $user = $this->user->paginate(10);
        return response()->json($user, 200);
    }

    public function store(Request $request){
        $data = $request->all();
        if (!$request->has('password') || !$request->get('password')){
            $message = new ApiMessages("É necessário informa uma senha para usuário");
            return response()->json($message->getMessage(), 401);
        }
        try {
            $data['password'] = bcrypt($data['password']);
            $user = $this->user->create($data);
            return response()->json([
                'data'=>[
                    'msg'=>'Usuário Cadastrado com sucesso!'
                ]
            ], 200);
        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json([$message->getMessage()]);
        }
    }

    public function show($user_id){
        try {
            $user = $this->user->findOrFail($user_id);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
        return response()->json(['data'=>$user], 200);
    }

    public function update(Request $request, $user_id){
        $data = $request->all();
        if (!$request->has('password') && !$request->get('password')){
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        try {
            $user = $this->user->findOrFail($user_id);
            $user->update($data);
            return response()->json([
                'data'=>[
                    'msg'=>'Usuário Alterado com sucesso!'
                ]
            ], 200);
        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json([$message->getMessage()]);
        }
    }

    public function destroy($user_id){
        try {
            $user = $this->user->findOrFail($user_id);
            $user->delete();
            return response()->json([
                'data'=>[
                    'msg'=>'Usuário Removido com sucesso!'
                ]
            ], 200);
        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json([$message->getMessage()]);
        }
    }
}
