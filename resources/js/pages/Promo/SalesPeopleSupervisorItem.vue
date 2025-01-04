<template>
    <li class="list-group-item m-0 px-2">
        <div class="row g-2">
            <div class="col-md-5 col-sm-12">
                <div class="input-group">
                    <span class="input-group-text">{{ index + 1 }}</span>
                    <input
                        :value="props.supervisor.shortName"
                        class="form-control fw-bold"
                        readonly
                        type="text"
                        :tabindex="-1"
                    >
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <TheInput
                    :id="`${props.index}_SV_salesBefore`"
                    class="fw-bold border-primary text-end"
                    readonly
                    :tabindex="-1"
                />
            </div>
            <div class="col-md-2 col-sm-6">
                <TheInput disabled="disabled" />
            </div>
            <div class="col-md-2 col-sm-6">
                <TheInput
                    :id="`${props.index}_SV_salesPlan`"
                    class="fw-bold border-success text-end"
                    readonly
                    :tabindex="-1"
                />
            </div>
            <div class="col-md-1 col-sm-6 text-center"></div>
        </div>
    </li>
    <template
        v-for="(seller, index) in props.sellers"
        :key="seller.id"
    >
        <SalesPeopleSellerItem
            v-if="seller.supervisorId === props.supervisor.id"
            :seller="seller"
            :index="index"
            @add-seller="addSeller"
        />
    </template>
</template>

<script setup>
import { computed, reactive, watch } from 'vue';
import SalesPeopleSellerItem from '@/pages/Promo/SalesPeopleSellerItem.vue';
import TheInput from '@/components/form/TheInput.vue';
import { convertInputStringToNumber, formatNumber, formatNumberWithFractions } from '@/helpers/formatters.js';

const props = defineProps({
    supervisor: {
        type: Object,
        required: true,
    },
    index: {
        type: Number,
        default: 0,
    },
    sellers: {
        type: Array,
        required: true,
        default: () => [],
    },
});

const emit = defineEmits([
    'addToCheckedSellers',
]);

const state = reactive({
    sellers: [],
});

watch(
    () => props.supervisor.compensationPlan,
    (newValue) => onCompensationPlanChange(newValue),
);

const addSeller = (seller) => {
    emit('addToCheckedSellers', seller);

    const itemIdx = state.sellers.findIndex(ss => ss.id === seller.id);

    if (itemIdx === -1) {
        state.sellers.push(seller);
    } else {
        state.sellers[itemIdx] = { ...seller };
    }

    const salesBeforeEl = document.getElementById(`${props.index}_SV_salesBefore`);
    const salesPlanEl = document.getElementById(`${props.index}_SV_salesPlan`);

    salesBeforeEl.value = salesBefore.value === 0 ? '' : formatNumber(salesBefore.value);
    salesPlanEl.value = salesPlan.value === 0 ? '' : formatNumberWithFractions(salesPlan.value);

    const supervisorObj = props.supervisor;

    supervisorObj.sellerId = supervisorObj.id;
    supervisorObj.salesBefore = salesBefore.value;
    supervisorObj.salesPlan = salesPlan.value;
    supervisorObj.budgetPlan = calcBudgetPlan(salesPlan.value, props.supervisor.compensationPlan);

    emit('addToCheckedSellers', supervisorObj);
};

const onCompensationPlanChange = (compensationPlan) => {
    const salesBeforeEl = document.getElementById(`${props.index}_SV_salesBefore`);
    const salesPlanEl = document.getElementById(`${props.index}_SV_salesPlan`);

    const salesBefore = convertInputStringToNumber(salesBeforeEl.value);
    const salesPlan = salesPlanEl.value === '' ? 0 : convertInputStringToNumber(salesPlanEl.value);
    const budgetPlan = calcBudgetPlan(salesPlan, compensationPlan);

    const supervisorObj = props.supervisor;

    supervisorObj.sellerId = supervisorObj.id;
    supervisorObj.salesBefore = salesBefore;
    supervisorObj.salesPlan = salesPlan;
    supervisorObj.budgetPlan = budgetPlan;

    emit('addToCheckedSellers', supervisorObj);
};

const salesBefore = computed(() => {
    return state.sellers.reduce((acc, el) => {
        if (isNaN(el.salesBefore)) el.salesBefore = 0;
        return +(acc + el.salesBefore).toFixed(0);
    }, 0);
});

const salesPlan = computed(() => {
    return state.sellers.reduce((acc, el) => {
        return +(acc + el.salesPlan).toFixed(0);
    }, 0);
});

const calcBudgetPlan = (salesPlan, compensationPlan) => {
    const boostSupervisorQuotient = convertInputStringToNumber(compensationPlan.toString());
    return +(salesPlan * boostSupervisorQuotient / 100).toFixed(2);
};
</script>
