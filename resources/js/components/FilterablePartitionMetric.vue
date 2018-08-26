<template>
    <base-partition-metric
            @filtered="handleFilter"
            :filters="card.filters"
            :title="card.name"
            :chart-data="chartData"
            :loading="loading"
    />
</template>

<script>
    import { Minimum } from 'laravel-nova'
    import BasePartitionMetric from './Base/PartitionMetric'
    import PartitionMetric from '@/components/Metrics/PartitionMetric'

    export default {

        extends: PartitionMetric,

        components: {
            'base-partition-metric': BasePartitionMetric
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

                Minimum(Nova.request().get(this.cardEndpoint, this.filterPayload())).then(({ data: { value: { value } } }) => {
                    this.chartData = value
                    this.loading = false
                })
            },

            filterPayload() {
                const payload = {
                    params: {
                        timezone: this.userTimezone,
                        twelveHourTime: this.usesTwelveHourTime,
                    },
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
