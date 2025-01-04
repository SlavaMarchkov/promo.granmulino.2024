<template>
    <div class="col-4">
        <TheCard class="info-card revenue-card">
            <template #header>
                <h5 class="mb-0 card-title p-0">Бюджет</h5>
                <h5 :class="['mb-0 fw-bold', calcBudgetDiffTextColor]"><i
                    :class="['bi', calcBudgetDiff === '0' ? '' : calcBudgetDiff >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ]"></i>&nbsp;{{
                        calcBudgetDiff
                    }}&#8239;%</h5>
            </template>
            <template #body>
                <div class="d-flex align-items-center">
                    <div
                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ formatNumber(totalBudgetActual) }} &#8381;</h6>
                        <span class="text-success small pt-1 fw-bold">{{
                                formatNumber(totalBudgetPlan)
                            }} &#8381;</span><span
                        class="text-muted small pt-2 ps-1"> | план</span>
                    </div>
                </div>
            </template>
        </TheCard>
    </div>
    <div class="col-4">
        <TheCard class="info-card sales-card">
            <template #header>
                <h5 class="mb-0 card-title p-0">Продажи</h5>
                <h5 :class="['mb-0 fw-bold', calcSurplusTextColor]"><i
                    :class="['bi', calcSurplus === '0' ? '' : calcSurplus >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ]"></i>&nbsp;{{
                        calcSurplus
                    }}&#8239;%</h5>
            </template>
            <template #body>
                <div class="d-flex align-items-center">
                    <div
                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ formatNumber(totalSalesOnTime) }} шт.</h6>
                        <span class="text-success small pt-1 fw-bold">{{
                                formatNumber(totalSalesPlan)
                            }} шт.</span> <span
                        class="text-muted small pt-2 ps-1"> | план</span>
                    </div>
                </div>
            </template>
        </TheCard>
    </div>
    <div class="col-4">
        <TheCard class="info-card profit-card">
            <template #header>
                <h5 class="mb-0 card-title p-0">Общая прибыль</h5>
            </template>
            <template #body>
                <div class="d-flex align-items-center">
                    <div
                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ formatNumber(totalPromoProfit) }} &#8381;</h6>
                    </div>
                </div>
            </template>
        </TheCard>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import TheCard from '@/components/core/TheCard.vue';
import { formatNumber, isNumberNegative } from '@/helpers/formatters.js';
import { useCalculations } from '@/use/useCalculations.js';

const { calcDifferencePercentage } = useCalculations();

const props = defineProps({
    totalBudgetPlan: {
        type: String,
        default: '0',
    },
    totalBudgetActual: {
        type: String,
        default: '0',
    },
    totalSalesBefore: {
        type: String,
        default: '0',
    },
    totalSalesPlan: {
        type: String,
        default: '0',
    },
    totalSalesOnTime: {
        type: String,
        default: '0',
    },
    totalPromoProfit: {
        type: String,
        default: '0',
    },
});

const calcSurplus = computed(() => {
    const result = calcDifferencePercentage(
        props.totalSalesPlan,
        props.totalSalesOnTime,
    );
    if ( !isNaN(result) ) {
        return formatNumber(result);
    }
});

const calcBudgetDiff = computed(() => {
    const result = calcDifferencePercentage(
        props.totalBudgetPlan,
        props.totalBudgetActual,
    );
    if ( !isNaN(result) ) {
        return formatNumber(result);
    }
});

const calcSurplusTextColor = computed(() => {
    return isNumberNegative(calcSurplus.value)
        ? 'text-danger'
        : calcSurplus.value === '0'
            ? 'text-secondary'
            : 'text-success';
});

const calcBudgetDiffTextColor = computed(() => {
    return !isNumberNegative(calcBudgetDiff.value)
        ? 'text-danger'
        : calcBudgetDiff.value === '0'
            ? 'text-secondary'
            : 'text-success';
});
</script>
