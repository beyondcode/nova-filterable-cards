<?php

namespace Beyondcode\FilterableCard;

trait FilterablePartition
{
    use Filterable;

    /**
     * Return a partition result showing the segments of a aggregate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $function
     * @param  string  $column
     * @param  string  $groupBy
     * @return \Laravel\Nova\Metrics\PartitionResult
     */
    protected function aggregate($request, $model, $function, $column, $groupBy)
    {
        $model = $this->applyFiltersToModel($request, $model);

        return parent::aggregate($request, $model, $function, $column, $groupBy);
    }
}