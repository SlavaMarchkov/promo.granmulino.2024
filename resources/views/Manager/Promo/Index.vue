<template>
    <div
        v-if="state.promos.length > 0"
        class="row row-cols-xl-3 row-cols-lg-2 row-cols-md-2 row-cols-sm-1 row-cols-1 g-3"
    >
        <TheCard
            v-for="promo in state.promos"
            :key="promo.id"
            :header-classes="['bg-light']"
            :body-classes="['pb-2']"
            with-footer
        >
            <template #header>
                <h3 class="mb-0">{{ promo.promoCode }}{{ promo.discount !== null ? `-${promo.discount}` : '' }}</h3>
                <h4 class="mb-0"><span :class="[ 'badge', promo.statusColor ]">{{ promo.statusLabel }}</span></h4>
            </template>
            <template #body>
                <TwoColumnRow title="Дистрибутор">{{ promo.customerName }}</TwoColumnRow>
                <TwoColumnRow title="Торговая сеть">{{ promo.retailerName ?? '&mdash;' }}</TwoColumnRow>
                <TwoColumnRow title="Дата начала">{{ promo.startDate }}</TwoColumnRow>
                <TwoColumnRow title="Дата окончания">{{ promo.endDate }}</TwoColumnRow>
                <hr>
                <TwoColumnRow class="fs-5" title="Бюджет, план">{{ formatNumber(promo.totalBudgetPlan) }} руб.
                </TwoColumnRow>
                <TwoColumnRow class="fs-5" title="Бюджет, факт">{{ formatNumber(promo.totalBudgetActual) }} руб.
                </TwoColumnRow>
            </template>
            <template #footer>
                <RouterLink
                    :to="{ name: 'Manager.Promo.View', params: { id: promo.id }}"
                    class="btn btn-outline-primary"
                >Подробнее
                </RouterLink>
            </template>
        </TheCard>
    </div>
    <div v-else class="row mb-4">
        <div class="col-12">
            <p class="mt-3 lead">
                {{ spinnerStore.isLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
            </p>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-12">
            <p>Всего записей: <span class="fw-bold">{{ state.promos.length }}</span></p>
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive } from 'vue';
import { useSpinnerStore } from '@/stores/spinners.js';
import { MANAGER_URLS } from '@/helpers/constants.js';
import { useHttpService } from '@/use/useHttpService.js';
import TheCard from '@/components/core/TheCard.vue';
import { formatNumber } from '@/helpers/formatters.js';
import TwoColumnRow from '@/components/core/TwoColumnRow.vue';

const spinnerStore = useSpinnerStore();
const { get } = useHttpService();

const state = reactive({
    promos: [],
});

onMounted(async () => {
    await getPromos();
});

const getPromos = async () => {
    const { data } = await get(MANAGER_URLS.PROMO);
    state.promos = data.promos;
};
</script>
