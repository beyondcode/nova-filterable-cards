<?php

namespace Beyondcode\FilterableCard;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function component()
    {
        return 'filterable-'.$this->component;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @return Builder
     */
    public function applyFiltersToModel($request, $model)
    {
        $model = $model instanceof Builder ? $model : (new $model)->newQuery();

        $filters = collect($request->all())->filter(function($value, $key) {
            return starts_with($key, 'filter') && method_exists(self::class, $key);
        });
        foreach ($filters as $method => $value) {
            $model = $this->$method($model, $value);
        }

        return $model;
    }

    public function filters(array $filters)
    {
        $this->filters = array_merge($this->filters, $filters);

        $this->withMeta([
            'filters' => array_keys($filters)
        ]);
    }

    /**
     * Prepare the metric for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'filters' => collect($this->filters ?? [])->map(function ($definition, $filter) {
                if (is_string($filter)) {
                    $label = $filter;
                    $studly = studly_case($filter);
                } else {
                    $label = $definition;
                    $studly = studly_case($definition);
                }

                if (method_exists($this, 'define'.$studly)) {
                    $definition = $this->{'define'.$studly}();
                }

                return [
                    'label' => $label,
                    'value' => 'filter'.$studly,
                    'definition' => $definition,
                ];
            })->values()->all(),
        ]);
    }

}