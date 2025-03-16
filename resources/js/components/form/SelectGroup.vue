<template>
    <div class="input-group">
        <span class="input-group-text"><slot/></span>
        <select
            :value="modelValue"
            class="form-select"
            :disabled="props.disabled"
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
        <span class="input-group-text input-group-close"
              @click="$emit('update:modelValue', '')"
        ><i class="bi bi-x-lg"></i></span>
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
    disabled: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits([
    'update:modelValue',
]);

const handleChange = (event) => {
    emit('update:modelValue', event.target.value);
};
</script>

<style scoped>
.input-group-close {
    cursor: pointer;
    transition: background-color .3s;
}

.input-group-close:hover,
.input-group-close:active {
    background-color: #dfdfdf;
}
</style>
