<template>
    <div class="input-group">
        <TheButton
            class="dropdown-toggle"
            data-bs-toggle="dropdown"
        >
            <slot/>
        </TheButton>
        <ul class="dropdown-menu">
            <li v-for="(value, index) in props.items" :key="index">
                <div class="form-check">
                    <input
                        :id="`filter_${ index }`"
                        class="form-check-input mt-0"
                        type="checkbox"
                        v-model="checked"
                        :value="value"
                        @change="handleFilter"
                    >
                    <label
                        :for="`filter_${ index }`"
                        class="form-check-label"
                    >{{ value }}</label>
                </div>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <div class="form-check">
                    <input
                        class="form-check-input mt-0"
                        type="checkbox"
                        :checked="checked.length === 0"
                        id="filter_all"
                        @change="clearFilter"
                    >
                    <label
                        class="form-check-label"
                        for="filter_all"
                    >Показывать все</label>
                </div>
            </li>
        </ul>
        <TheInput
            readonly="readonly"
            :placeholder="getChecked"
        />
        <span
            class="input-group-text input-group-close"
            @click="clearFilter"
        ><i class="bi bi-x-lg"></i></span>
    </div>
</template>

<script setup>
import TheInput from '@/components/form/TheInput.vue';
import TheButton from '@/components/core/TheButton.vue';
import { computed, ref } from 'vue';

const props = defineProps({
    items: {
        type: Array,
        required: true,
    },
});

const checked = ref([]);

const emit = defineEmits([
    'filter',
]);

const getChecked = computed(() => checked.value.length > 0
    ? checked.value.join(', ')
    : 'Выберите вес',
);

const handleFilter = (evt) => {
    emit('filter', evt.target.value);
};

const clearFilter = () => {
    emit('filter', null);
    checked.value = [];
};
</script>

<style scoped>
.dropdown-toggle {
    color: var(--bs-body-color);
    text-align: center;
    white-space: nowrap;
    background-color: var(--bs-tertiary-bg);
    border: var(--bs-border-width) solid var(--bs-border-color);
    border-radius: var(--bs-border-radius);
}

.dropdown-toggle:active {
    border: var(--bs-border-width) solid var(--bs-border-color);
    background-color: var(--bs-tertiary-bg);
}

.dropdown-toggle::after {
    margin-left: .6em;
    vertical-align: .1em;
}

.dropdown-menu {
    padding: 0;
}

.dropdown-menu li {
    padding: 0.25rem 0.75rem 0;
}

.input-group-close {
    cursor: pointer;
    transition: background-color .3s;
}

.input-group-close:hover,
.input-group-close:active {
    background-color: #dfdfdf;
}
</style>
