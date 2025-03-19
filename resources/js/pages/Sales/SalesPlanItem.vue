<template>
    <li class="list-group-item m-0">
        <div class="row g-2 align-items-center p-0">
            <div class="col-md-5">
                <div class="input-group">
                    <div class="input-group-text">
                        <input
                            class="form-check-input mt-0"
                            type="checkbox"
                            v-model="state.form.isAdded"
                            disabled="disabled"
                            :tabindex="-1"
                        />
                    </div>
                    <TheInput
                        :model-value="props.category.name"
                        readonly="readonly"
                        :tabindex="-1"
                    />
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text">кг</span>
                    <TheInput
                        class="text-center"
                        :value="props.category.salesPlan ? formatNumber(props.category.salesPlan) : ''"
                        @input="handleInput"
                    />
                    <span class="input-group-text">00</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text">%</span>
                    <TheInput
                        class="text-center"
                        :model-value="salesPlanShare"
                        readonly="readonly"
                        :tabindex="-1"
                    />
                    <span class="input-group-text">%</span>
                </div>
            </div>
        </div>
    </li>
</template>

<script setup>
import TheInput from '@/components/form/TheInput.vue';
import { computed, reactive, watch } from 'vue';
import { convertInputStringToNumber, formatNumber, formatNumberWithFractions } from '@/helpers/formatters.js';
import { useCalculations } from '@/use/useCalculations.js';

const { calcPercentage } = useCalculations();

const props = defineProps({
    category: {
        type: Object,
        required: true,
    },
    totalSalesPlan: {
        type: Number,
        default: 0,
    },
});

const emit = defineEmits([
    'updateSalesPlan',
]);

const initialFormData = () => ({
    categoryId: props.category.categoryId,
    salesPlan: '',
    isAdded: false,
});

const state = reactive({
    form: initialFormData(),
});

watch(
    () => props.category.salesPlan,
    (newValue) => {
        state.form.salesPlan = newValue;
        state.form.isAdded = !!newValue;
    },
);

const handleInput = (evt) => {
    const plan = convertInputStringToNumber(evt.target.value);
    if ( isNaN(plan) ) {
        evt.target.value = ''
        state.form.salesPlan = '';
        state.form.isAdded = false;
    } else {
        evt.target.value = formatNumber(plan);
        state.form.salesPlan = evt.target.value;
        state.form.isAdded = true;
    }
    emit('updateSalesPlan', state.form);
};

const salesPlanShare = computed(() => {
    const share = calcPercentage(props.totalSalesPlan, state.form.salesPlan);
    return (isNaN(share) || !state.form.salesPlan) ? '' : formatNumberWithFractions(share);
});
</script>
