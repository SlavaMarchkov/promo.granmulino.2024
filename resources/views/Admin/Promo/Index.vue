<template>
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1">{{ $route.meta.title }}</h3>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <TheFilter
                @reset-filter="clearSearch"
            >
                <div class="col-md-4 mb-2">
                    <SelectGroup
                        v-model="searchBy.userId"
                        :chooseFrom="'-- Выберите менеджера --'"
                        :items="state.users"
                        selectedOption="fullName"
                    >Менеджер
                    </SelectGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <SelectGroup
                        v-model="searchBy.status"
                        :chooseFrom="'-- Выберите статус --'"
                        :items="PROMO_STATUSES"
                    >Статус
                    </SelectGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <SelectGroup
                        v-model="searchBy.promoType"
                        :chooseFrom="'-- Выберите тип акции --'"
                        :items="PROMO_TYPES"
                        selectedOption="promoLabel"
                    >Тип акции
                    </SelectGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <SelectGroup
                        v-model="searchBy.year"
                        :chooseFrom="'-- Выберите год --'"
                        :items="years"
                        selected-option="year"
                    >Год промо-акции
                    </SelectGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <SelectGroup
                        v-model="searchBy.dateFilterMonth"
                        :chooseFrom="'-- Выберите месяц --'"
                        :items="years"
                        selected-option="month"
                    >Месяц промо-акции
                    </SelectGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <SelectGroup
                        :disabled="searchBy.year === ''"
                        v-model="searchBy.dateFilterQuarter"
                        :chooseFrom="'-- Выберите период года --'"
                        :items="QUARTERS"
                        selected-option="period"
                    >Квартал / Полугодие
                    </SelectGroup>
                </div>
            </TheFilter>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <TheCard
                v-if="filteredItems.length > 0"
                with-footer
            >
                <template #header><h4 class="mb-0">Список промо-акций {{ searchBy }}</h4></template>
                <template #body>
                    <div class="list-group">
                        <AdminPromoItem
                            v-for="item in filteredItems"
                            :key="item.id"
                            :promo="item"
                        />
                    </div>
                </template>
                <template #footer>
                    <p class="mb-0">Всего записей: <span class="fw-bold">{{ filteredItems.length }}</span></p>
                </template>
            </TheCard>
            <p v-else class="mt-3 text-center lead">
                {{ spinnerStore.isLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
            </p>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive } from 'vue';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useAuthStore } from '@/stores/auth.js';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import TheFilter from '@/components/core/TheFilter.vue';
import SelectGroup from '@/components/form/SelectGroup.vue';
import { ADMIN_URLS, PROMO_STATUSES, PROMO_TYPES, QUARTERS } from '@/helpers/constants.js';
import TheCard from '@/components/core/TheCard.vue';
import AdminPromoItem from '@/pages/PromoActual/AdminPromoItem.vue';
import { storeToRefs } from 'pinia';

const arrayHandlers = useArrayHandlers();
const spinnerStore = useSpinnerStore();
const authStore = useAuthStore();
const { get } = useHttpService();
const { getYears: years } = storeToRefs(authStore);

const state = reactive({
    promos: [],
});

onMounted(async () => {
    await getPromos();
    await getUsers();
});

const getPromos = async () => {
    const { data } = await get(ADMIN_URLS.PROMO);
    state.promos = data.promos;
};

const getUsers = async () => {
    const { data } = await get(ADMIN_URLS.USER, {
        params: {
            is_active: true,
        },
    });
    state.users = data.users;
};

const searchBy = reactive({
    userId: '',
    status: '',
    promoType: '',
    year: '',
    dateFilterQuarter: '',
});

const clearSearch = () => {
    arrayHandlers.resetSearchKeys(searchBy);
    arrayHandlers.resetSortKeys();
};

const sortedItems = computed(() => {
    return arrayHandlers.sortArray(state.promos);
});

const filteredItems = computed(() => {
    return arrayHandlers.filterArray(sortedItems.value, searchBy);
});
</script>
