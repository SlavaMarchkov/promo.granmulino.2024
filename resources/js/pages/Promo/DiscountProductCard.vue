<template>
    <TheCard
        :header-classes="['bg-secondary-subtle py-2 fw-bold text-black']"
        with-footer
    >
        <template #header>
            <h5 class="mb-0">{{ props.product.categoryName }}</h5>
        </template>
        <template #body>
            <h6 class="mb-0 fw-bold text-primary">{{ props.product.productName }}</h6>
            <hr>
            <TwoColumnRow title="Скидка">{{ props.product.discount }}&#8239;%</TwoColumnRow>
            <TwoColumnRow title="Акционная цена">{{ formatNumberWithFractions(props.product.promoPrice) }} руб.</TwoColumnRow>
            <TwoColumnRow title="Продажи 'До'">{{ formatNumber(props.product.salesBefore) }} шт.</TwoColumnRow>
            <TwoColumnRow title="План">{{ formatNumber(props.product.salesPlan) }} шт.</TwoColumnRow>
            <TwoColumnRow title="Прирост">{{ formatNumber(props.product.surplusPlan) }}&#8239;%</TwoColumnRow>
            <TwoColumnRow title="Бюджет">{{ formatNumber(props.product.budgetPlan) }} руб.</TwoColumnRow>
            <TwoColumnRow title="Прибыль на шт.">{{ formatNumberWithFractions(props.product.profitPerUnit) }} руб.</TwoColumnRow>
            <TwoColumnRow title="Прибыль, план">{{ formatNumberWithFractions(props.product.profitPerProductPlan) }} руб.</TwoColumnRow>
            <TwoColumnRow title="Норматив ЧП"><span :class="netProfitClass">&nbsp;&nbsp;{{ formatNumber(props.product.netProfit) }}&#8239;%&nbsp;&nbsp;</span></TwoColumnRow>
            <TwoColumnRow title="Выручка">{{ formatNumber(props.product.revenuePlan) }} руб.</TwoColumnRow>
        </template>
        <template #footer>
            <TheButton
                class="btn-danger w-100"
                @click="removeProduct"
            >Удалить
            </TheButton>
        </template>
    </TheCard>
</template>

<script setup>
import { computed, watch } from 'vue';
import { convertInputStringToNumber, formatNumber, formatNumberWithFractions } from '@/helpers/formatters.js';
import TheButton from '@/components/core/TheButton.vue';
import TheCard from '@/components/core/TheCard.vue';
import TwoColumnRow from '@/components/core/TwoColumnRow.vue';
import { MARKETING_EXPENSES, OFFICE_EXPENSES } from '@/helpers/constants.js';

const props = defineProps({
    index: {
        type: Number,
        default: 1,
    },
    product: {
        type: Object,
        required: true,
    },
    transportRatePerKilo: {
        type: Number,
        default: 0,
    },
});

const emit = defineEmits([
    'removeProduct',
]);

const removeProduct = () => {
    emit('removeProduct', props.index);
};

const netProfitClass = computed(() => {
    return props.product.netProfit >= 20
        ? 'bg-success-light text-success'
        : 'bg-danger-light text-danger';
});

watch(
    () => props.transportRatePerKilo,
    (newValue) => {
        const transportRatePerUnit = calcTransportRatePerUnit(newValue);
        props.product.profitPerUnit =
            (props.product.promoPrice - props.product.productPrice)
            - transportRatePerUnit
            - (props.product.promoPrice * OFFICE_EXPENSES)
            - (props.product.promoPrice * MARKETING_EXPENSES)
        ;
        props.product.netProfit = Math.round((props.product.profitPerUnit / props.product.promoPrice) * 100);
        props.product.profitPerProductPlan = convertInputStringToNumber(props.product.salesPlan) * props.product.profitPerUnit;
    },
);

const calcTransportRatePerUnit = (rate) => {
    return rate * (props.product.productWeight / 1000);
};
</script>
