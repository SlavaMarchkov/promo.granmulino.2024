<template>
    <div class="col">
        <div class="card mb-0">
            <div class="card-header bg-light d-flex justify-content-between">
                <h3 class="mb-0">{{ promo.promoCode }}{{ promo.discount !== null ? `-${promo.discount}` : '' }}</h3>
                <h4 class="mb-0"><span :class="[ 'badge', promo.statusColor ]">{{ promo.statusLabel }}</span></h4>
            </div>
            <div class="card-body mt-3">
                <div class="row">
                    <div class="col-6">Контрагент</div>
                    <div class="col-6 fw-bold text-end">{{ promo.customerName }}</div>
                </div>
                <div class="row">
                    <div class="col-6">Торговая сеть</div>
                    <div class="col-6 fw-bold text-end">{{ promo.retailerName }}</div>
                </div>
                <div class="row">
                    <div class="col-6">Дата начала</div>
                    <div class="col-6 fw-bold text-end">{{ promo.startDate }}</div>
                </div>
                <div class="row">
                    <div class="col-6">Дата окончания</div>
                    <div class="col-6 fw-bold text-end">{{ promo.endDate }}</div>
                </div>
                <hr>
                <div class="row fs-5">
                    <div class="col-6">Бюджет, план</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(promo.totalBudgetPlan) }} руб.</div>
                </div>
                <div class="row fs-5">
                    <div class="col-6">Бюджет, факт</div>
                    <div class="col-6 fw-bold text-end">{{ formatNumber(promo.totalBudgetActual) }} руб.</div>
                </div>
            </div>
            <div class="card-footer">
                <RouterLink
                    :to="{ name: 'Manager.Promo.View', params: { id: promo.id }}"
                    class="btn btn-outline-primary"
                >Подробнее
                </RouterLink>
            </div>
        </div>
    </div>
</template>

<script setup>
import { formatNumber } from '@/helpers/formatters.js';

const props = defineProps({
    promo: {
        type: Object,
    },
});
</script>
