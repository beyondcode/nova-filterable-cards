<template>
    <base-trend-metric
        @selected="handleRangeSelected"
        @filtered="handleFilter"
        :filters="card.filters"
        :title="card.name"
        :value="value"
        :chart-data="data"
        :ranges="card.ranges"
        :prefix="prefix"
        :suffix="suffix"
        :selected-range-key="selectedRangeKey"
        :loading="loading"
    />
</template>

<script>
import { Minimum } from 'laravel-nova'
import BaseTrendMetric from './Base/TrendMetric'
import TrendMetric from '@/components/Metrics/TrendMetric'

export default {

    extends: TrendMetric,

    components: {
        'base-trend-metric': BaseTrendMetric
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
                         value: { labels, trend, value, prefix, suffix },
                     },
                 }) => {
                    this.value = value
                    this.labels = Object.keys(trend)
                    this.data = {
                        labels: Object.keys(trend),
                        series: [
                            _.map(trend, (value, label) => {
                                return {
                                    meta: label,
                                    value: value,
                                }
                            }),
                        ],
                    }
                    this.prefix = prefix || ''
                    this.suffix = suffix || ''
                    this.loading = false
                }
            )
        },

        filterPayload() {
            const payload = {
                params: {
                    timezone: this.userTimezone,
                    twelveHourTime: this.usesTwelveHourTime,
                },
            }

            if (this.hasRanges) {
                payload.params.range = this.selectedRangeKey
            }

            this.card.filters.forEach((filter) => {
                if (typeof(this.selectedFilters[filter.value]) !== 'undefined') {
                    payload.params[filter.value] = this.selectedFilters[filter.value];
                }
            });

            return payload;
        },
    }
}
</script>
