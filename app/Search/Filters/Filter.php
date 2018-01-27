<?php
/**
 * Created by PhpStorm.
 * User: Faby's
 * Date: 16/1/2018
 * Time: 8:22 PM
 */

namespace App\Search\Filters;


use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    /**
     * @param Builder $builder
     * @param $value
     * @return mixed
     */
    public static function apply(Builder $builder, $value);
}