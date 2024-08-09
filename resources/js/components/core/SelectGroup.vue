<template>
    <div class="input-group">
        <span class="input-group-text"><slot/></span>
        <select
            :value="modelValue"
            class="form-select"
            @change="handleChange"
        >
            <option disabled selected value="">{{ chooseFrom }}</option>
            <option
                v-for="item in items"
                :key="item.id"
                :value="item.id"
            >{{ item[selectedOption] }}
            </option>
        </select>
        <span class="input-group-text" style="cursor: pointer;"
              @click="$emit('update:modelValue', '')"><i
            class="bi bi-x-lg"></i></span>
    </div>
</template>

<script setup>
const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    items: {
        type: Array,
        default: () => [],
    },
    chooseFrom: {
        type: String,
        default: '-- Выберите --',
    },
    selectedOption: {
        type: String,
        default: 'name',
    },
});

const emit = defineEmits([
    'update:modelValue',
]);

const handleChange = (event) => {
    emit('update:modelValue', event.target.value);
};
</script>
