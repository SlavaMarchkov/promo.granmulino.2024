<template>
    <div class="row my-3">
        <div class="col-12">
            <TheFilter
                @reset-filter="clearSearch"
            >
                <div class="col-xl-4 col-md-6 mb-2">
                    <InputGroup
                        v-model="searchBy.name"
                        placeholder="Поиск по названию"
                    >
                        Торговая сеть
                    </InputGroup>
                </div>
                <div class="col-xl-4 col-md-6 mb-2">
                    <InputGroup
                        v-model="searchBy.city"
                        placeholder="Поиск по городу"
                    >
                        Город
                    </InputGroup>
                </div>
                <div class="col-xl-4 col-md-6 mb-2">
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
    <div
        v-if="filteredItems.length > 0"
        class="row row-cols-xl-3 row-cols-lg-2 row-cols-md-2 row-cols-sm-1 row-cols-1 g-3"
    >
        <TheCard
            v-for="item in filteredItems"
            :key="item.id"
            :header-classes="['bg-light']"
            with-footer
        >
            <template #header>
                <h4 class="mb-0">{{ item.name }}</h4>
                <p class="mb-0"><span :class="['badge', 'rounded', item.typeBgColor]">{{ item.label }}</span></p>
            </template>
            <template #body>
                <TwoColumnRow title="Дистрибутор">{{ item.customer }}</TwoColumnRow>
                <TwoColumnRow title="Город">{{ item.city }}</TwoColumnRow>
                <TwoColumnRow title="Работает">
                    <TheBadge :is-active="item.isActive"/>
                </TwoColumnRow>
            </template>
            <template #footer>
                <RouterLink
                    :to="{ name: 'Manager.Retailer.View', params: { id: item.id } }"
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
import TwoColumnRow from '@/components/core/TwoColumnRow.vue';
import TheCard from '@/components/core/TheCard.vue';

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
