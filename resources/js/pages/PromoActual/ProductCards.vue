<template>
    <div class="col-md-4">
        <TheCard class="info-card revenue-card">
            <template #header>
                <h5 class="mb-0 card-title p-0">Бюджет</h5>
                <h5 :class="[ 'mb-0 fw-bold', calcDiffPercentColor(calcBudgetDiffPercent) ]">
                    <span
                        :class="['bi', calcBudgetDiffPercent === 0 ? '' : calcBudgetDiffPercent > 0 ? 'bi-arrow-up' : 'bi-arrow-down' ]"
                        v-html="formatAsPercent(calcBudgetDiffPercent)"
                    ></span>
                </h5>
            </template>
            <template #body>
                <div class="d-flex align-items-center">
                    <div
                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                        <h6 v-html="formatAsRUB(props.totalBudgetActual)"></h6>
                        <span
                            class="text-success small pt-1 fw-bold"
                            v-html="formatAsRUB(props.totalBudgetPlan)"
                        ></span><span
                        class="text-muted small pt-2 ps-1"> | план</span>
                    </div>
                </div>
            </template>
        </TheCard>
    </div>
    <div class="col-md-4">
        <TheCard class="info-card sales-card">
            <template #header>
                <h5 class="mb-0 card-title p-0">Продажи</h5>
                <h5 :class="[ 'mb-0 fw-bold', calcDiffPercentColorInverse(calcSalesDiffPercent) ]">
                    <span
                        :class="['bi', calcSalesDiffPercent === 0 ? '' : calcSalesDiffPercent > 0 ? 'bi-arrow-up' : 'bi-arrow-down' ]"
                        v-html="formatAsPercent(calcSalesDiffPercent)"
                    ></span>
                </h5>
            </template>
            <template #body>
                <div class="d-flex align-items-center">
                    <div
                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                        <h6 v-html=formatAsItems(props.totalSalesOnTime)></h6>
                        <span
                            class="text-success small pt-1 fw-bold"
                            v-html="formatAsItems(props.totalSalesPlan)"
                        ></span> <span
                        class="text-muted small pt-2 ps-1"> | план</span>
                    </div>
                </div>
            </template>
        </TheCard>
    </div>
    <div class="col-md-4">
        <TheCard class="info-card profit-card">
            <template #header>
                <h5 class="mb-0 card-title p-0">Общая прибыль</h5>
                <h5 :class="[ 'mb-0 fw-bold', calcDiffPercentColorInverse(calcPromoProfitDiffPercent) ]">
                    <span
                        :class="['bi', calcPromoProfitDiffPercent === 0 ? '' : calcPromoProfitDiffPercent > 0 ? 'bi-arrow-up' : 'bi-arrow-down' ]"
                        v-html="formatAsPercent(calcPromoProfitDiffPercent)"
                    ></span>
                </h5>
            </template>
            <template #body>
                <div class="d-flex align-items-center">
                    <div
                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="ps-3">
                        <h6 v-html=formatAsRUB(props.totalPromoProfitActual)></h6>
                        <span
                            class="text-success small pt-1 fw-bold"
                            v-html="formatAsRUB(props.totalPromoProfitPlan)"
                        ></span> <span
                        class="text-muted small pt-2 ps-1"> | план</span>
                    </div>
                </div>
            </template>
        </TheCard>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import TheCard from '@/components/core/TheCard.vue';
import { formatAsItems, formatAsPercent, formatAsRUB } from '@/helpers/formatters.js';
import { useCalculations } from '@/use/useCalculations.js';

const {
    calcDifferencePercentage,
    calcDiffPercentColor,
    calcDiffPercentColorInverse,
} = useCalculations();

const props = defineProps({
    totalBudgetPlan: {
        type: String,
        default: '0',
    },
    totalBudgetActual: {
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
    totalPromoProfitPlan: {
        type: String,
        default: '0',
    },
    totalPromoProfitActual: {
        type: String,
        default: '0',
    },
});

const calcBudgetDiffPercent = computed(() => {
    return calcDifferencePercentage(props.totalBudgetPlan, props.totalBudgetActual);
});

const calcSalesDiffPercent = computed(() => {
    return calcDifferencePercentage(props.totalSalesPlan, props.totalSalesOnTime);
});

const calcPromoProfitDiffPercent = computed(() => {
    return calcDifferencePercentage(props.totalPromoProfitPlan, props.totalPromoProfitActual);
});
</script>
