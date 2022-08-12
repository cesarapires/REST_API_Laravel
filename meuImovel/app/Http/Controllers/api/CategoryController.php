<?php

namespace App\Http\Controllers\api;

use App\Exceptions\ApiMessages;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller{

    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }

    public function index(){
        $category = $this->category->paginate(10);
        return response()->json($category, 200);
    }

    public function store(CategoryRequest $request){
        $data = $request->all();
        try{
            $category = $this->category->create($data);
            return response()->json([
                'data' => [
                    'msg' => 'Categoria cadastrada com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function show($category_id){
        try{
            $category = $this->category->findOrFail($category_id);
            return response()->json([
                'data' => $category
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function update(CategoryRequest $request, $category_id){
        $data = $request->all();
        try{
            $category = $this->category->findOrFail($category_id);
            $category->update($data);
            return response()->json([
                'data' => [
                    'msg' => 'Categoria atualizada com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($category_id){
        try{
            $category = $this->category->findOrFail($category_id);
            $category->delete();
            return response()->json([
                'data' => [
                    'msg' => 'Categoria removida com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function realState($category_id){
        try {
            $category = $this->category->findOrFail($category_id);
            return response()->json(['data'=>$category->realStates],200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
