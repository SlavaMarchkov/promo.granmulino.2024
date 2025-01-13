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
            <TwoColumnRow title="Прибыль, план">{{ formatNumberWithFractions(props.product.profitPerProduct) }} руб.</TwoColumnRow>
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
import { computed } from 'vue';
import { formatNumber, formatNumberWithFractions } from '@/helpers/formatters.js';
import TheButton from '@/components/core/TheButton.vue';
import TheCard from '@/components/core/TheCard.vue';
import TwoColumnRow from '@/components/core/TwoColumnRow.vue';

const props = defineProps({
    index: {
        type: Number,
        default: 1,
    },
    product: {
        type: Object,
        required: true,
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
</script>
