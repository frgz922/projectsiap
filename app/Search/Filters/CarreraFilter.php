<?php
/**
 * Created by PhpStorm.
 * User: Faby's
 * Date: 20/1/2018
 * Time: 12:52 AM
 */

namespace App\Search\Filters;


use Illuminate\Database\Eloquent\Builder;

class CarreraFilter implements Filter
{

    /**
     * @param Builder $builder
     * @param $value
     * @return mixed
     */
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('carrera_id', $value);
    }
}