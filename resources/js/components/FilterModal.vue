<template>
    <modal
            class="modal"
            tabindex="-1"
            role="dialog"
    >
        <div class="bg-white rounded-lg shadow-lg overflow-hidden" style="width: 600px">
            <div>
                <heading :level="2" class="pt-8 px-8">Filter "{{ title }}"</heading>

                <div class="px-8 py-6">
                    <table class="w-full table table-primary">
                        <tr v-if="ranges && ranges.length > 0">
                            <td>Time Range</td>
                            <td class="text-right">
                                <select
                                        @change="handleChange"
                                        class="ml-auto min-w-24 h-6 text-xs no-appearance bg-40"
                                >
                                    <option
                                            v-for="option in ranges"
                                            :key="option.value"
                                            :value="option.value"
                                            :selected="option.value == selectedRangeKey"
                                    >
                                        {{ option.label }}
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr v-for="filter in filters">
                            <td>{{ filter.label }}</td>
                            <td class="text-right">
                                <input
                                        :class="inputClasses(filter.definition.type)"
                                        v-if="filter.definition.type !== 'select'"
                                        @change="handleFilter(filter, $event)"
                                        :type="filter.definition.type"
                                        :checked="selectedFilters[filter.value] === 1"
                                        :value="selectedFilters[filter.value]" />
                                <select
                                        v-if="filter.definition.type === 'select'"
                                        @change="handleFilter(filter, $event)"
                                        class="ml-auto min-w-24 h-6 text-xs no-appearance bg-40"
                                >
                                    <option
                                            v-for="(option, value) in filter.definition.options"
                                            :value="value"
                                            :selected="value == selectedFilters[filter.value]"
                                    >{{ option }}</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>

            <div class="bg-30 px-6 py-3 flex">
                <div class="flex items-center ml-auto">
                    <button @click.prevent="closeModal"
                            type="submit"
                            class="btn btn-default btn-primary"
                    >
                        <span>Save</span>
                    </button>
                </div>
            </div>
        </div>
    </modal>
</template>
<script>
    export default {

        props: [
            'title',
            'ranges',
            'filters',
            'selectedRangeKey'
        ],

        data() {
            return {
                modalOpen: false,
                selectedFilters: {},
            };
        },

        methods: {
            inputClasses(inputType) {
                if (inputType !== 'checkbox') {
                    return 'form-control form-input form-input-bordered';
                }
            },

            closeModal() {
                this.$emit('closeModal');
            },

            handleChange(event) {
                this.$emit('selected', event.target.value)
            },

            handleFilter(filter, event) {
                let value = event.target.value;
                if (filter.definition.type === 'checkbox') {
                    value = event.target.checked ? 1 : 0;
                }

                this.selectedFilters[filter.value] = value;

                this.$emit('filtered', {
                    filter,
                    value
                })
            },

        }

    }
</script>