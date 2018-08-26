<template>
    <loading-card :loading="loading" class="metric px-6 py-4 relative">
        <div class="flex mb-4 items-center">
            <h3 class="mr-3 text-base text-80 font-bold flex-fill">{{ title }}</h3>

            <button class="ml-auto btn btn-sm btn-white px-4 text-80" @click="openModal">
                &middot;&middot;&middot;
            </button>
        </div>

        <p class="flex items-center text-4xl mb-4">
            {{ formattedValue }}
            <span v-if="suffix" class="ml-2 text-sm font-bold text-80">{{ formattedSuffix }}</span>
        </p>

        <div class="flex items-center">
            <p class="text-80 font-bold">
                <svg v-if="increaseOrDecreaseLabel == 'Decrease'" class="text-danger fill-current mr-2" width="20" height="12"><path d="M2 3a1 1 0 0 0-2 0v8a1 1 0 0 0 1 1h8a1 1 0 0 0 0-2H3.414L9 4.414l3.293 3.293a1 1 0 0 0 1.414 0l6-6A1 1 0 0 0 18.293.293L13 5.586 9.707 2.293a1 1 0 0 0-1.414 0L2 8.586V3z"/></svg>
                <svg v-if="increaseOrDecreaseLabel == 'Increase'" class="rotate-180 text-success fill-current mr-2" width="20" height="12"><path d="M2 3a1 1 0 0 0-2 0v8a1 1 0 0 0 1 1h8a1 1 0 0 0 0-2H3.414L9 4.414l3.293 3.293a1 1 0 0 0 1.414 0l6-6A1 1 0 0 0 18.293.293L13 5.586 9.707 2.293a1 1 0 0 0-1.414 0L2 8.586V3z"/></svg>

                <span v-if="increaseOrDecrease != 0">
                    <span v-if="growthPercentage !== 0">
                        {{ growthPercentage }}% {{ increaseOrDecreaseLabel }}
                    </span>

                    <span v-else>
                        No Increase
                    </span>
                </span>

                <span v-else>
                    <span v-if="previous == '0' && value != '0'">
                        No Prior Data
                    </span>

                    <span v-if="value == '0' && previous != '0'">
                        No Current Data
                    </span>

                    <span v-if="value == '0' && previous == '0'">
                        No Data
                    </span>
                </span>
            </p>
        </div>

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
import ValueMetric from '@/components/Metrics/Base/ValueMetric'

export default {

    extends: ValueMetric,

    mixins: [require('./../modal')]
}
</script>
