<template>
    <base-value-metric
            @selected="handleRangeSelected"
            @filtered="handleFilter"
            :title="card.name"
            :previous="previous"
            :value="value"
            :ranges="card.ranges"
            :filters="card.filters"
            :prefix="prefix"
            :suffix="suffix"
            :selected-range-key="selectedRangeKey"
            :loading="loading"
    />
</template>

<script>
import { Minimum } from 'laravel-nova'
import BaseValueMetric from './Base/ValueMetric'
import ValueMetric from '@/components/Metrics/ValueMetric'

export default {

    extends: ValueMetric,

    components: {
        'base-value-metric': BaseValueMetric
    },

    data() {
        return {
            selectedFilters: {}
        };
    },

    props: ['card'],

    methods: {
        handleFilter(payload) {
            this.selectedFilters[payload.filter.value] = payload.value;

            this.fetch()
        },

        fetch() {
            this.loading = true

            Minimum(Nova.request().get(this.metricEndpoint, this.filterPayload())).then(
                ({
                     data: {
                         value: { value, previous, prefix, suffix },
                     },
                 }) => {
                    this.value = value
                    this.prefix = prefix || ''
                    this.suffix = suffix || ''
                    this.previous = previous
                    this.loading = false
                }
            )
        },

        filterPayload() {
            let params = {};

            if (this.hasRanges) {
                params['range'] = this.selectedRangeKey;
            }

            this.card.filters.forEach((filter) => {
                if (typeof(this.selectedFilters[filter.value]) !== 'undefined') {
                    params[filter.value] = this.selectedFilters[filter.value];
                }
            });

            return {params};
        },
    }
}
</script>
