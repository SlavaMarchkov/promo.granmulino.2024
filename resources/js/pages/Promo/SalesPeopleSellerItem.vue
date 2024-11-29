<template>
    <li class="list-group-item m-0 px-2">
        <div class="row g-2">
            <div class="col-md-5 col-sm-12">
                <TheInput
                    :value="props.seller.shortName"
                    :class="{ 'border-danger': !props.seller.supervisorId }"
                    readonly
                />
            </div>
            <div class="col-md-2 col-sm-6">
                <TheInput
                    :id="`${index}_salesBefore`"
                    :class="[
                        'text-end',
                        { 'border-danger': !props.seller.supervisorId }
                    ]"
                    @input="onSalesBeforeChange($event, index)"
                />
            </div>
            <div class="col-md-2 col-sm-6">
                <TheInput
                    :id="`${index}_surplusPlan`"
                    :class="[
                        'text-end',
                        { 'border-danger': !props.seller.supervisorId }
                    ]"
                    :model-value="DEFAULT_SURPLUS_PERCENT"
                    @input="onSurplusPlanChange($event, index)"
                    maxlength="3"
                    readonly="readonly"
                />
            </div>
            <div class="col-md-2 col-sm-6">
                <TheInput
                    :id="`${index}_salesPlan`"
                    :class="[
                        'text-end',
                        { 'border-danger': !props.seller.supervisorId }
                    ]"
                    @input="onSalesPlanChange($event, index)"
                    readonly="readonly"
                />
            </div>
            <div class="col-md-1 col-sm-6 text-center">
                <TheButton
                    class="btn-outline-danger"
                    @click="removeSeller(index)"
                ><i class="bi-x-lg"></i></TheButton>
            </div>
        </div>
    </li>
</template>

<script setup>
import { BOOST_SELLER_QUOTIENT, DEFAULT_SURPLUS_PERCENT } from '@/helpers/constants.js';
import TheButton from '@/components/core/TheButton.vue';
import TheInput from '@/components/form/TheInput.vue';
import { convertInputStringToNumber, formatNumber, formatNumberWithFractions } from '@/helpers/formatters.js';

const props = defineProps({
    seller: {
        type: Object,
        required: true,
    },
    index: {
        type: Number,
        default: 1,
    },
});

const emit = defineEmits([
    'addSeller',
]);

const onSalesBeforeChange = (evt, index) => {
    let sellerObj = props.seller;

    const salesBeforeEl = document.getElementById(`${index}_salesBefore`);
    const surplusPlanEl = document.getElementById(`${index}_surplusPlan`);
    const salesPlanEl = document.getElementById(`${index}_salesPlan`);

    let salesBefore = convertInputStringToNumber(evt.target.value);

    let surplusPlan;
    let salesPlan;
    let budgetPlan;

    if (isNaN(salesBefore)) {
        surplusPlan = 0;
        salesPlan = 0;
        budgetPlan = 0;

        salesBeforeEl.value = '';
        surplusPlanEl.value = '';
        salesPlanEl.value = '';
        surplusPlanEl.setAttribute('readonly', 'readonly');
        salesPlanEl.setAttribute('readonly', 'readonly');
    } else if (salesBefore === 0) {
        salesBefore = 0;
        surplusPlan = 0;
        salesPlan = 0;
        budgetPlan = 0;

        surplusPlanEl.value = surplusPlan;
        salesPlanEl.value = salesPlan;
        surplusPlanEl.setAttribute('readonly', 'readonly');
        salesPlanEl.removeAttribute('readonly');
    } else {
        surplusPlan = surplusPlanEl.value === ''
            ? DEFAULT_SURPLUS_PERCENT
            : convertInputStringToNumber(surplusPlanEl.value);
        salesPlan = +(salesBefore + (salesBefore * surplusPlan) / 100).toFixed(2);
        budgetPlan = calcBudgetPlan(salesPlan);

        salesBeforeEl.value = formatNumber(salesBefore);
        salesPlanEl.value = formatNumberWithFractions(salesPlan);
        salesPlanEl.setAttribute('readonly', 'readonly');
        surplusPlanEl.removeAttribute('readonly');
        surplusPlanEl.value = surplusPlan;
    }

    sellerObj.sellerId = sellerObj.id;
    sellerObj.salesBefore = salesBefore;
    sellerObj.surplusPlan = surplusPlan;
    sellerObj.salesPlan = salesPlan;
    sellerObj.budgetPlan = budgetPlan;

    emit('addSeller', sellerObj);
};

const onSurplusPlanChange = (evt, index) => {
    let sellerObj = props.seller;

    const salesBeforeEl = document.getElementById(`${index}_salesBefore`);
    const surplusPlanEl = document.getElementById(`${index}_surplusPlan`);
    const salesPlanEl = document.getElementById(`${index}_salesPlan`);

    let salesBefore = convertInputStringToNumber(salesBeforeEl.value);
    let surplusPlan = convertInputStringToNumber(evt.target.value);
    let salesPlan;
    let budgetPlan;

    if (isNaN(surplusPlan)) {
        surplusPlan = 0;
        surplusPlanEl.value = surplusPlan;
    }

    salesPlan = +(salesBefore + (salesBefore * surplusPlan) / 100).toFixed(2);
    budgetPlan = calcBudgetPlan(salesPlan);

    surplusPlanEl.value = formatNumber(surplusPlan);
    salesPlanEl.value = formatNumberWithFractions(salesPlan);

    sellerObj.sellerId = sellerObj.id;
    sellerObj.salesBefore = salesBefore;
    sellerObj.surplusPlan = surplusPlan;
    sellerObj.salesPlan = salesPlan;
    sellerObj.budgetPlan = budgetPlan;

    emit('addSeller', sellerObj);
};

const onSalesPlanChange = (evt, index) => {
    let sellerObj = props.seller;

    const salesPlanEl = document.getElementById(`${index}_salesPlan`);

    let salesPlan = convertInputStringToNumber(evt.target.value);
    let salesBefore = 0;
    let surplusPlan = 0;
    let budgetPlan;

    if ( isNaN(salesPlan) ) {
        salesPlan = 0;
        salesPlanEl.value = salesPlan;
    } else {
        budgetPlan = calcBudgetPlan(salesPlan);
        salesPlan = +(salesPlan).toFixed(2);
        salesPlanEl.value = formatNumber(salesPlan);
    }

    sellerObj.salesBefore = salesBefore;
    sellerObj.surplusPlan = surplusPlan;
    sellerObj.salesPlan = salesPlan;
    sellerObj.budgetPlan = budgetPlan;

    emit('addSeller', sellerObj);
};

const calcBudgetPlan = (salesPlan) => {
    return +(salesPlan * BOOST_SELLER_QUOTIENT / 100).toFixed(2);
};

const removeSeller = (index) => {
    let sellerObj = props.seller;

    const salesBeforeEl = document.getElementById(`${index}_salesBefore`);
    const surplusPlanEl = document.getElementById(`${index}_surplusPlan`);
    const salesPlanEl = document.getElementById(`${index}_salesPlan`);

    salesBeforeEl.value = '';
    surplusPlanEl.value = '';
    salesPlanEl.value = '';

    surplusPlanEl.setAttribute('readonly', 'readonly');
    salesPlanEl.setAttribute('readonly', 'readonly');

    sellerObj.salesBefore = 0;
    sellerObj.surplusPlan = 0;
    sellerObj.salesPlan = 0;
    sellerObj.budgetPlan = 0;

    emit('addSeller', sellerObj);
};
</script>
