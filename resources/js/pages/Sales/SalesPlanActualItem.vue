<template>
    <TheCard :header-classes="['bg-pale py-2']" class="mb-3">
        <template #header><h5 class="mb-0 card-title p-0">{{ props.entry.customerName }}</h5></template>
        <template #body>
            <div style="overflow-x: auto;">
                <table class="table table-bordered text-center align-middle" style="width: auto;">
                    <thead>
                    <tr>
                        <th class="align-middle sticky-col">Группа товаров</th>
                        <th v-for="month in props.months" :key="month.id">
                            <p class="mb-1 pb-1 border-bottom">{{ month.month }}</p>
                            <table class="table table-sm mt-2 mb-0 table-borderless fw-normal">
                                <tr style="font-size: 0.85rem;">
                                    <td class="border-end" style="min-width: 110px;">План, кг</td>
                                    <td class="border-end" style="min-width: 110px;">Факт, кг</td>
                                    <td class="border-end" style="min-width: 130px;">Отклонение, %</td>
                                    <td style="min-width: 130px;">Выполнение, %</td>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="category in props.categories" :key="category.id">
                        <th class="text-start sticky-col">{{ category.name }}</th>
                        <td v-for="month in props.months" :key="month.id" class="py-0">
                            <template v-for="(salesArr, index) in salesPerMonth" :key="index">
                                <template v-for="(salesRow, index) in salesArr" :key="index">
                                    <table v-if="salesRow.salesMonth === month.id" class="table table-sm m-0 p-0 table-borderless fw-normal">
                                        <CategorySalesRowItem
                                            v-if="salesRow.categoryId === category.id"
                                            :item="salesRow"
                                            @update-sales-actual="updateSalesActualHandler"
                                        />
                                    </table>
                                </template>
                            </template>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="text-start sticky-col">ИТОГО</th>
                        <th v-for="month in props.months" :key="month.id" class="py-0">
                            <template v-for="(item, index) in salesPerMonth" :key="index">
                                <table v-if="item.month === month.id" class="table table-sm m-0 p-0 table-borderless">
                                    <tr class="font-monospace">
                                        <td class="border-end text-end pe-3" style="min-width: 110px;">{{ formatNumber(item.totalSalesPlan) }}</td>
                                        <td class="border-end text-end pe-3" style="min-width: 110px;">{{ formatNumber(item.totalSalesActual) }}</td>
                                        <td class="border-end text-end pe-3" style="min-width: 130px;">
                                            <span
                                                :class="calcDiffPercentColorInverse(calcPercentage(item.totalSalesPlan, item.totalSalesActual) - 100)"
                                            >{{ formatNumberWithFractions(calcPercentage(item.totalSalesPlan, item.totalSalesActual) - 100) }}</span>
                                        </td>
                                        <td class="text-end pe-3" style="min-width: 130px;">
                                            {{ formatNumberWithFractions(calcPercentage(item.totalSalesPlan, item.totalSalesActual)) }}
                                        </td>
                                    </tr>
                                </table>
                            </template>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </template>
    </TheCard>
</template>

<script setup>
import { computed } from 'vue';
import { formatNumber, formatNumberWithFractions } from '@/helpers/formatters.js';
import TheCard from '@/components/core/TheCard.vue';
import { MONTHS } from '@/helpers/constants.js';
import CategorySalesRowItem from '@/pages/Sales/CategorySalesRowItem.vue';
import { useCalculations } from '@/use/useCalculations.js';

const { calcPercentage, calcDiffPercentColorInverse } = useCalculations();

const props = defineProps({
    entry: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    months: {
        type: Array,
        default: MONTHS,
    },
});

const emit = defineEmits([
    'updateSalesActual',
]);

const salesPerMonth = computed(() => {
    const salesArray = [];
    const sales = props.entry.sales.data;
    Object.keys(props.months).forEach(key => {
        Object.keys(sales).forEach(el => {
            if (props.months[key].id === el) {
                sales[el].totalSalesPlan = sales[el].reduce((total, it) => {
                    return total + it.salesPlan;
                }, 0);
                sales[el].totalSalesActual = sales[el].reduce((total, it) => {
                    return total + it.salesActual;
                }, 0);
                sales[el].month = el;
                salesArray.push(sales[el]);
            }
        });
    });
    return salesArray;
});

const updateSalesActualHandler = (salesActual) => {
    emit('updateSalesActual', salesActual);
};
</script>
