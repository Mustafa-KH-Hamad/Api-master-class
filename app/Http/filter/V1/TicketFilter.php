<?php

namespace App\Http\Filter\V1;

class TicketFilter extends QueryFilter{
    protected $sortable=[
        'status',
        'title',
        'createdAt'=>'created_at',
        'updatedAt'=>'updatedAt'
    ];
    public function status ($value){
        return $this->builder->whereIn('status',explode(',',$value));
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
    public function title ($value){
        $data = str_replace('*','%',$value);
        return $this->builder->whereLike('title',$data);
    }
}