<?php
/**
 * Created by PhpStorm.
 * User: Faby's
 * Date: 16/1/2018
 * Time: 8:32 PM
 */

namespace App\Search;


use App\Models\Proyecto;
use App\Search\Filters\NombreFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Search
{
    public static function apply(Request $filters)
    {
        $query = static::applyDecoratorsFromRequest($filters, (new Proyecto)->newQuery());
        return static::getResults($query);
    }

    private static function applyDecoratorsFromRequest(Request $request, Builder $query)
    {
        foreach ($request->all() as $filterName => $value) {
            $decorator = static::createFilterDecorator($filterName);
            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }
        }
        return $query;
//        return $decorator;
    }

    private static function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\Filters\\' . studly_case($name.'Filter');
    }

    private static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    private static function getResults(Builder $query)
    {
        return $query->with('categoria')->get();
    }


}