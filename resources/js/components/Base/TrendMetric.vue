<template>
    <loading-card :loading="loading" class="px-6 py-4">
        <div class="flex mb-4 items-center">
            <h3 class="mr-3 text-base text-80 font-bold">{{ title }}</h3>

            <button class="ml-auto btn btn-sm btn-white px-4 text-80" @click="openModal">
                &middot;&middot;&middot;
            </button>
        </div>

        <p class="flex items-center text-4xl mb-4">
            {{ formattedValue }}
            <span v-if="suffix" class="ml-2 text-sm font-bold text-80">{{ formattedSuffix }}</span>
        </p>

        <div
                ref="chart"
                class="z-40 absolute pin rounded-b-lg ct-chart"
                style="top: 60%"
        />

        <portal to="modals">
            <transition name="fade">
                <filterable-modal
                        v-show="modalOpen"
                        :selected-range-key="selectedRangeKey"
                        :title="title"
                        :ranges="ranges"
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
import TrendMetric from '@/components/Metrics/Base/TrendMetric'

export default {

    extends: TrendMetric,

    mixins: [require('./../modal')]
}
</script>
