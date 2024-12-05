<template>
    <div v-if="state.promos.length > 0" class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1 g-3">
        <div class="col" v-for="item in state.promos" :key="item.id">
            <div class="card mb-0">
                <h5 class="card-header">{{ item.name }}</h5>
                <div class="card-body mt-3">
                    <ul class="mb-0 list-unstyled">
                        <li><strong>Регион</strong>: </li>
                        <li><strong>Город</strong>: </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <RouterLink
                        :to="{ name: 'Manager.Promo.View', params: { id: item.id }}"
                        class="btn btn-outline-primary"
                    >Подробнее</RouterLink>
                </div>
            </div>
        </div>
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
