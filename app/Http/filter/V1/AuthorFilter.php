<?php

namespace App\Http\Filter\V1;

class AuthorFilter extends QueryFilter{
    protected $sortable=[
        'id',
        'name',
        'email',
        'createdAt'=>'created_at',
        'updatedAt'=>'updatedAt'
    ];

    public function id ($value){
        return $this->builder->whereIn('id',explode(',',$value));
    }
    public function includes($value){
        return $this->builder->with($value);
    }
    public function created_at($value){
        $dates = explode(',',$value);
        if(count($dates) > 1 ){
            return $this->builder->whereBetween('created_at',$dates);
        }
        return $this->builder->where('created_at',$dates);
    }
    public function updated_at($value){
        $dates = explode(',',$value);
        if(count($dates) > 1 ){
            return $this->builder->whereBetween('updated_at',$dates);
        }
        return $this->builder->where('updated_at',$dates);
    }
    public function email ($value){
        $data = str_replace('*','%',$value);
        return $this->builder->whereLike('email',$data);
    }
    public function name ($value){
        $data = str_replace('*','%',$value);
        return $this->builder->whereLike('name',$data);
    }
}