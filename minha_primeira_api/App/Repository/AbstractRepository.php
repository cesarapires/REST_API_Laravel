<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository {

    private $model;

    public function __construct(Model $model){
        $this->model = $model;
    }

    public function selectConditions($conditions){
        $expressions = explode(';', $conditions);

        foreach ($expressions as $ex) {
            $condition = explode(':', $ex);
            $this->model = $this->model->where($condition[0], $condition[1], $condition[2]);
        }

    }

    public function selectFilter($filters) {
        $this->model = $this->model->selectRaw($filters);
    }

    public function getResult(){
        return $this->model;
    }
}
