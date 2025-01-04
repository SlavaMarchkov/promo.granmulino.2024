<template>
    <li class="list-group-item m-0 px-2">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <TheInput
                    :value="props.seller.name"
                    :class="{ 'border-warning': !props.seller.supervisorId }"
                    readonly
                    :tabindex="-1"
                />
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <TheInput
                            :class="[
                                'text-end',
                                { 'border-warning': !props.seller.supervisorId }
                            ]"
                            :model-value="state.seller.salesBefore"
                            readonly
                            :tabindex="-1"
                        />
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <TheInput
                            :class="[
                                'text-end',
                                { 'border-warning': !props.seller.supervisorId }
                            ]"
                            :model-value="state.seller.salesPlan"
                            readonly
                            :tabindex="-1"
                        />
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <TheInput
                            :id="`${index}_salesAfter`"
                            :class="[
                                'text-end',
                                { 'border-warning': !props.seller.supervisorId }
                            ]"
                            v-model="state.seller.salesAfter"
                            :tabindex="0"
                            @blur="processInputValue($event.target.value, `${index}_salesAfter`)"
                        />
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <TheInput
                            :class="[
                                'text-end',
                                { 'border-warning': !props.seller.supervisorId },
                                calcSalesAfterClass,
                            ]"
                            :model-value="calcSalesDiff"
                            readonly
                            :tabindex="-1"
                        />
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <TheInput
                            :class="[
                                'text-end',
                                { 'border-warning': !props.seller.supervisorId }
                            ]"
                            :model-value="state.seller.compensationPlan"
                            readonly
                            :tabindex="-1"
                        />
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <TheInput
                            :class="[
                                'text-end',
                                { 'border-warning': !props.seller.supervisorId }
                            ]"
                            :model-value="state.seller.budgetPlan"
                            readonly
                            :tabindex="-1"
                        />
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <TheInput
                            :class="[
                                'text-end',
                                { 'border-warning': !props.seller.supervisorId },
                                calcSalesAfterClass
                            ]"
                            :model-value="calcBudgetActual"
                            readonly
                            :tabindex="-1"
                        />
                    </div>
                </div>
            </div>
        </div>
    </li>
</template>

<script setup>
import { computed, onMounted, reactive, watch } from 'vue';
import TheInput from '@/components/form/TheInput.vue';
import {
    convertInputStringToNumber,
    formatNumber,
    formatNumberWithFractions,
    processInputValue,
} from '@/helpers/formatters.js';
import { useCalculations } from '@/use/useCalculations.js';

const { calcPercentage } = useCalculations();

onMounted(() => {
    const el = document.getElementById('0_salesAfter');
    el.focus();
});

const props = defineProps({
    seller: {
        type: Object,
        required: true,
    },
    index: {
        type: Number,
        default: 0,
    },
});

const emit = defineEmits([
    'updateSeller',
]);

const initialFormData = () => ({
    id: props.seller.id,
    name: props.seller.name,
    sellerId: props.seller.sellerId,
    supervisorId: props.seller.supervisorId,
    isSupervisor: props.seller.isSupervisor,
    salesBefore: formatNumber(props.seller.salesBefore),
    salesPlan: formatNumber(props.seller.salesPlan),
    salesAfter: formatNumber(props.seller.salesAfter),
    compensationPlan: props.seller.compensationPlan,
    compensationActual: props.seller.compensationActual,
    budgetPlan: formatNumberWithFractions(props.seller.budgetPlan),
    budgetActual: formatNumberWithFractions(props.seller.budgetActual),
});

const state = reactive({
    seller: initialFormData(),
});

watch(
    () => state.seller.salesAfter,
    (newValue) => {
        const salesAfterNum = convertInputStringToNumber(String(newValue));
        const salesAfter = !isNaN(salesAfterNum) ? salesAfterNum : 0;
        const sellerObj = state.seller;
        sellerObj.salesAfter = salesAfter;
        emit('updateSeller', sellerObj);
    },
);

const calcSalesDiff = computed(() => {
    if ( state.seller.salesAfter === 0 ) {
        return formatNumberWithFractions(0);
    } else {
        const result = calcPercentage(state.seller.salesPlan, state.seller.salesAfter);
        return formatNumberWithFractions(result);
    }
});

const calcSalesAfterClass = computed(() => {
    const diff = convertInputStringToNumber(calcSalesDiff.value);
    return diff < 90
        ? 'border-danger bg-sales-fail text-danger'
        : 'border-success bg-sales-success text-black';
});

const calcBudgetActual = computed(() => {
    const boostSellerQuotient = convertInputStringToNumber(state.seller.compensationPlan.toString());
    const salesAfter = convertInputStringToNumber(state.seller.salesAfter.toString());
    const result = convertInputStringToNumber(calcSalesDiff.value) < 90
        ? 0 : (salesAfter * boostSellerQuotient / 100).toFixed(2);
    state.seller.budgetActual = result;
    return formatNumberWithFractions(result);
});
</script>
