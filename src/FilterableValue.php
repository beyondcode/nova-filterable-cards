<?php

namespace Beyondcode\FilterableCard;

trait FilterableValue
{
    use Filterable;

    /**
     * Return a value result showing the growth of a model over a given time frame.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $function
     * @param  string|null  $column
     * @return \Laravel\Nova\Metrics\ValueResult
     */
    protected function aggregate($request, $model, $function, $column = null, $dateColumn = null)
    {
        $model = $this->applyFiltersToModel($request, $model);

        return parent::aggregate($request, $model, $function, $column, $dateColumn = null);
    }
}
