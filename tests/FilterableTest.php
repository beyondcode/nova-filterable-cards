<?php

namespace Beyondcode\FilterableCard\Tests;


use Beyondcode\FilterableCard\FilterablePartition;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\Partition;
use Illuminate\Foundation\Auth\User;
use Beyondcode\FilterableCard\FilterableValue;
use Beyondcode\FilterableCard\FilterableTrend;

class FilterableTest extends TestCase
{

    /** @test */
    public function can_filter_value_metrics()
    {
        $filter = new FilterValueMetric();

        $request = Request::create('', 'GET', []);

        $count = $filter->calculate($request);

        $this->assertSame(2.0, $count->value);

        $request = Request::create('', 'GET', [
            'filterName' => 'Marcel',
        ]);

        $count = $filter->calculate($request);

        $this->assertSame(1.0, $count->value);
    }

    /** @test */
    public function can_filter_trend_metrics()
    {
        $filter = new FilterTrendMetric();

        $request = Request::create('', 'GET', ['range' => '30']);

        $count = $filter->calculate($request);

        $this->assertSame(2.0, collect($count->trend)->sum());

        $request = Request::create('', 'GET', [
            'range' => '30',
            'filterName' => 'Marcel',
        ]);

        $count = $filter->calculate($request);

        $this->assertSame(1.0, collect($count->trend)->sum());
    }

    /** @test */
    public function can_filter_partition_metrics()
    {
        $filter = new FilterPartitionMetric();

        $request = Request::create('', 'GET', ['range' => '30']);

        $count = $filter->calculate($request);

        $this->assertSame(2, count($count->value));

        $request = Request::create('', 'GET', [
            'range' => '30',
            'filterName' => 'Marcel',
        ]);

        $count = $filter->calculate($request);

        $this->assertSame(1, count($count->value));
    }

}


class FilterValueMetric extends Value
{
    use FilterableValue;

    protected $filters = [
        'Name' => [
            'type' => 'text'
        ]
    ];

    public function calculate(Request $request)
    {
        return $this->count($request, User::class);
    }

    public function filterName($query, $value)
    {
        return $query->where('name', $value);
    }
}

class FilterTrendMetric extends Trend
{
    use FilterableTrend;

    protected $filters = [
        'Name' => [
            'type' => 'text'
        ]
    ];

    public function calculate(Request $request)
    {
        return $this->countByDays($request, User::class);
    }

    public function filterName($query, $value)
    {
        return $query->where('name', $value);
    }
}

class FilterPartitionMetric extends Partition
{
    use FilterablePartition;

    protected $filters = [
        'Name' => [
            'type' => 'text'
        ]
    ];

    public function calculate(Request $request)
    {
        return $this->count($request, User::class, 'email');
    }

    public function filterName($query, $value)
    {
        return $query->where('name', $value);
    }
}