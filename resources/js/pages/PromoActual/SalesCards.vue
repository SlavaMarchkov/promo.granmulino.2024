<template>
    <div class="col-4">
        <TheCard class="info-card revenue-card">
            <template #header>
                <h5 class="mb-0 card-title p-0">Бюджет</h5>
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
                <h5 class="mb-0 card-title p-0">Продажи, план</h5>
                <h5 :class="['mb-0 fw-bold', calcPlanSurplusTextColor]"><i
                    :class="['bi', calcPlanSurplus >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ]"></i>&nbsp;{{
                        calcPlanSurplus
                    }}&#8239;%</h5>
            </template>
            <template #body>
                <div class="d-flex align-items-center">
                    <div
                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ formatNumber(totalSalesPlan) }} шт.</h6>
                        <span class="text-success small pt-1 fw-bold">{{
                                formatNumber(totalSalesBefore)
                            }} шт.</span> <span
                        class="text-muted small pt-2 ps-1"> | до акции</span>
                    </div>
                </div>
            </template>
        </TheCard>
    </div>
    <div class="col-4">
        <TheCard class="info-card sales-card">
            <template #header>
                <h5 class="mb-0 card-title p-0">Продажи, факт</h5>
                <h5 :class="['mb-0 fw-bold', calcAfterSurplusTextColor]"><i
                    :class="['bi', calcAfterSurplus === '0' ? '' : calcAfterSurplus >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ]"></i>&nbsp;{{
                        calcAfterSurplus
                    }}&#8239;%</h5>
            </template>
            <template #body>
                <div class="d-flex align-items-center">
                    <div
                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ formatNumber(totalSalesAfter) }} шт.</h6>
                        <span class="text-success small pt-1 fw-bold">{{
                                formatNumber(totalSalesPlan)
                            }} шт.</span> <span
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
    totalSalesAfter: {
        type: String,
        default: '0',
    },
});

const calcPlanSurplus = computed(() => {
    const result = calcDifferencePercentage(
        props.totalSalesBefore,
        props.totalSalesPlan,
    );
    if ( !isNaN(result) ) {
        return formatNumber(result);
    }
});

const calcAfterSurplus = computed(() => {
    const result = calcDifferencePercentage(
        props.totalSalesAfter,
        props.totalSalesPlan,
    );
    if ( !isNaN(result) ) {
        return formatNumber(result);
    }
});

const calcPlanSurplusTextColor = computed(() => {
    return isNumberNegative(calcPlanSurplus.value)
        ? 'text-danger'
        : calcPlanSurplus.value === '0'
            ? 'text-secondary'
            : 'text-success';
});

const calcAfterSurplusTextColor = computed(() => {
    return isNumberNegative(calcAfterSurplus.value)
        ? 'text-danger'
        : calcAfterSurplus.value === '0'
            ? 'text-secondary'
            : 'text-success';
});
</script>
