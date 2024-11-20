<template>
    <div class="row my-3">
        <div class="col-12">
            <TheFilter
                @reset-filter="clearSearch"
            >
                <div class="col-md-4 mb-2">
                    <InputGroup
                        v-model="searchBy.name"
                        placeholder="Поиск по названию"
                    >
                        Торговая сеть
                    </InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <InputGroup
                        v-model="searchBy.city"
                        placeholder="Поиск по городу"
                    >
                        Город
                    </InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <TheCheckbox
                        id="is_active"
                        v-model="searchBy.isActive"
                    >
                        Показать только активных
                    </TheCheckbox>
                </div>
            </TheFilter>
        </div>
    </div>
    <div v-if="filteredItems.length > 0" class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1 g-3">
        <div class="col" v-for="item in filteredItems" :key="item.id">
            <div class="card mb-0">
                <h5 class="card-header d-flex justify-content-between">
                    {{ item.name }}
                    <span :class="['badge', 'rounded', item.typeBgColor]">{{ item.label }}</span>
                </h5>
                <div class="card-body mt-3">
                    <ul class="mb-2 list-unstyled">
                        <li><strong>Дистрибутор</strong>: {{ item.customer }}</li>
                        <li><strong>Город</strong>: {{ item.city }}</li>
                        <li><strong>Работает</strong>: <TheBadge :is-active="item.isActive" /></li>
                    </ul>
                </div>
                <div class="card-footer">
                    <RouterLink
                        :to="{ name: 'Manager.Retailer.View', params: { id: item.id } }"
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
            <p>Всего записей: <span class="fw-bold">{{ filteredItems.length }}</span></p>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import { useHttpService } from '@/use/useHttpService.js';
import InputGroup from '@/components/form/InputGroup.vue';
import TheCheckbox from '@/components/form/TheCheckbox.vue';
import TheFilter from '@/components/core/TheFilter.vue';
import { MANAGER_URLS } from '@/helpers/constants.js';
import TheBadge from '@/components/core/TheBadge.vue';

const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();
const { get } = useHttpService();

const state = reactive({
    retailers: [],
});

const searchBy = reactive({
    name: '',
    city: '',
    isActive: false,
});

onMounted(async () => {
    await getRetailers();
});

const getRetailers = async () => {
    const { data } = await get(MANAGER_URLS.RETAILER);
    state.retailers = data.retailers;
};

const clearSearch = () => {
    arrayHandlers.resetSearchKeys(searchBy);
    arrayHandlers.resetSortKeys();
};

const sortedItems = computed(() => {
    return arrayHandlers.sortArrayByStringColumn(state.retailers, 'name');
});

const filteredItems = computed(() => {
    return arrayHandlers.filterArray(sortedItems.value, searchBy);
});
</script>
