<template>
    <tr class="font-monospace" style="font-size: small;">
        <th scope="row">{{ index + 1 }}</th>
        <td class="text-start">{{ product.categoryName }} <br> {{ product.productName }}</td>
        <td>{{ product.discount }}</td>
        <td><span :class="[ 'fw-bold', netProfitClass(product.netProfit) ]">&nbsp;{{ product.netProfit }}&nbsp;</span></td>
        <td>до: {{ formatNumber(product.salesBefore) }} | план: {{ formatNumber(product.salesPlan) }} <br> во время: <span class="fw-bold">{{ formatNumber(product.salesOnTime) }}</span></td>
        <td>{{ formatNumber(product.budgetPlan) }} <br> {{ formatNumber(product.budgetActual) }}</td>
        <td>{{ product.compensation }}</td>
        <td>{{ formatNumber(product.profitPerProductPlan) }} <br> {{ formatNumber(product.profitPerProductActual) }}</td>
        <td>{{ formatNumber(product.surplusPlan) }} <br> {{ formatNumber(product.surplusActual) }}</td>
        <td>{{ formatNumber(product.revenuePlan) }} <br> {{ formatNumber(product.revenueActual) }}</td>
        <td><span :class="[ 'fw-bold', calcDiffClassInverse(calcSalesDiffPercent) ]">&nbsp;{{ calcSalesDiffPercent }}&#8239;%&nbsp;</span></td>
    </tr>
</template>

<script setup>
import { computed } from 'vue';
import { formatNumber } from '@/helpers/formatters.js';
import { useCalculations } from '@/use/useCalculations.js';

const { calcDifferencePercentage, calcDiffClassInverse, netProfitClass } = useCalculations();

const props = defineProps({
    product: {
        type: Object,
        default: () => {},
    },
    index: {
        type: Number,
        default: 1,
    },
});

const calcSalesDiffPercent = computed(() => {
    return calcDifferencePercentage(props.product.salesPlan, props.product.salesOnTime);
});
</script>
