<?php
namespace App\Http\Filter\V1;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter{

    protected $builder; 
    protected $request;
    protected $sortable; 

    public function __construct(Request $request) {
        $this->request = $request;
    }
    protected function filter($arr) {//lera arrya war nagre balkw class wardagre
        
        foreach($arr as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }
    }
    public function apply(Builder $builder){
        $this->builder = $builder; 
        foreach($this->request->all() as $key => $value){
            if(method_exists($this,$key)){
                return $this->$key($value);
            }
        }
        return $builder ; 
        
    }
    public function sort($value){
        $attributes = explode(',' , $value);
        
        foreach ($attributes as $attribute){
            $order = 'asc';
            if ( strpos( $attribute , '-' ) === 0 ){
                $order = 'desc';
                $attribute = substr($attribute,1);
            }
            if(!array_key_exists($attribute,$this->sortable) && !in_array($attribute,$this->sortable) ){
                continue; 
            }
            $column = $this->sortable[$attribute] ?? null;
            if($column === null ){
                $column = $attribute;
            }
            $this->builder->orderBy($column,$order);
        }

    }
}