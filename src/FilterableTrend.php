<?php

namespace Beyondcode\FilterableCard;

trait FilterableTrend
{
    use Filterable;

    /**
     * Return a value result showing a aggregate over time.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $unit
     * @param  string  $function
     * @param  string  $column
     * @param  string  $dateColumn
     * @return \Laravel\Nova\Metrics\TrendResult
     */
    protected function aggregate($request, $model, $unit, $function, $column, $dateColumn = null)
    {
        $model = $this->applyFiltersToModel($request, $model);

        return parent::aggregate($request, $model, $unit, $function, $column, $dateColumn);
    }
}