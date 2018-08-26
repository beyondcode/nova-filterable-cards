<template>
    <loading-card :loading="loading" class="px-6 py-4">
        <h3 class="flex mb-3 text-base text-80 font-bold items-center">
            {{ title }}
            <span class="ml-2 font-semibold text-70 text-sm">({{ formattedTotal}} {{__('total')}})</span>
            <button class="ml-auto text-80 btn btn-sm btn-white px-4 " v-if="filters.length > 0" @click="openModal">
                &middot;&middot;&middot;
            </button>
        </h3>

        <div class="overflow-hidden overflow-y-auto max-h-90px">
            <ul class="list-reset">
                <li v-for="item in formattedItems" class="text-xs text-80 leading-normal">
                    <span class="inline-block rounded-full w-2 h-2 mr-2" :style="{
                        backgroundColor: item.color
                    }"/>{{ item.label }} ({{item.value}} - {{ (item.value * 100 / formattedTotal).toFixed(2) }}%)
                </li>
            </ul>
        </div>

        <div
                ref="chart"
                class="z-40 vertical-center rounded-b-lg ct-chart"
                style="width: 90px; height: 90px; right: 20px; bottom: 30px; top: calc(50% + 15px);"
        />


        <portal to="modals">
            <transition name="fade">
                <filterable-modal
                        v-show="modalOpen"
                        :title="title"
                        :filters="filters"
                        @filtered="filtered"
                        @selected="selected"
                        @closeModal="closeModal"
                        class="modal"
                        tabindex="-1"
                        role="dialog"
                />
            </transition>
        </portal>
    </loading-card>
</template>

<script>
    import PartitionMetric from '@/components/Metrics/Base/PartitionMetric'

    export default {

        extends: PartitionMetric,

        mixins: [
            require('@/base'),
            require('./../modal')
        ]
    }
</script>
