<template>
    <RouterLink
        :to="{ name: 'Promo.View', params: { id: props.promo.id } }"
        class="list-group-item list-group-item-action promo-item"
    >
        <div class="d-flex w-100 align-items-center">
            <div class="col-md-3">
                <h5 class="mb-1">{{ props.promo.customerName }} | {{ props.promo.retailerName }}</h5>
                <small>{{ props.promo.startDate }} - {{ props.promo.endDate }}</small>
            </div>
            <div class="col-md-3 text-center">
                <h5 class="mb-0">
                    <span :class="['badge', props.promo.statusColor]">{{ props.promo.statusLabel }}</span>
                </h5>
            </div>
            <div class="col-md-2">
                <p class="mb-0">Бюджет, факт: <span class="fw-bold" v-html="formatAsRUB(props.promo.totalBudgetActual)"></span></p>
                <p class="mb-0">Бюджет, план: <span class="fw-bold" v-html="formatAsRUB(props.promo.totalBudgetPlan)"></span></p>
            </div>
            <div class="col-md-2 text-center">
                <h5 class="mb-0">
                    <span :class="['badge', props.promo.promoBgColor]">{{ props.promo.promoCode }} - {{ props.promo.promoLabel }}</span>
                </h5>
            </div>
            <div class="col-md-2 text-center">
                <h4 class="mb-0">
                    <span :class="[ 'badge', promoMarkBgColor ]">{{ props.promo.totalMark }}</span>
                </h4>
            </div>
        </div>
    </RouterLink>
</template>

<script setup>
import { computed } from 'vue';
import { formatAsRUB } from '@/helpers/formatters.js';

const props = defineProps({
    promo: {
        type: Object,
        required: true,
    },
});

const promoMarkBgColor = computed(() => {
    return props.promo.totalMark > 0 && props.promo.totalMark <= 3
        ? 'bg-danger'
        : props.promo.totalMark > 3 && props.promo.totalMark <= 5
            ? 'bg-success' : 'bg-secondary';
});
</script>
