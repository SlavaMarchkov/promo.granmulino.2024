<template>
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-0">{{ $route.meta.title }}</h3>
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
                        v-model="searchBy.userId"
                        :chooseFrom="'-- Выберите статус --'"
                    >Статус
                    </SelectGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <SelectGroup
                        v-model="searchBy.userId"
                        :chooseFrom="'-- Выберите тип акции --'"
                    >Тип акции
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
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import TheFilter from '@/components/core/TheFilter.vue';
import SelectGroup from '@/components/form/SelectGroup.vue';
import { ADMIN_URLS } from '@/helpers/constants.js';
import TheCard from '@/components/core/TheCard.vue';
import AdminPromoItem from '@/pages/PromoActual/AdminPromoItem.vue';

const arrayHandlers = useArrayHandlers();
const spinnerStore = useSpinnerStore();
const { get } = useHttpService();

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
