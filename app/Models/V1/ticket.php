<?php

namespace App\Models\V1;

use App\Http\Filter\V1\QueryFilter;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ticket extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['title','status','discription','user_id'];
    // protected $guard = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopefilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
    }

}
