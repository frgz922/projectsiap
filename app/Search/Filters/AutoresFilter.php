<?php
/**
 * Created by PhpStorm.
 * User: Faby's
 * Date: 16/1/2018
 * Time: 8:31 PM
 */

namespace App\Search\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class AutoresFilter implements Filter
{

    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param $value
     * @return mixed
     */
    public static function apply(Builder $builder, $value)
    {
        return $builder->where(DB::raw('LOWER(autores)'), 'LIKE', '%' . $value . '%');
    }
}