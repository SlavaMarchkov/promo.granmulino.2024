<template>
    <div class="row mb-4">
        <div class="col-12">
            <button class="btn btn-primary" type="button" @click="createCityInit">
                Новый город
            </button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <Filter @reset-filter="clearSearch">
                <div class="col-md-4 mb-2">
                    <InputGroup v-model="searchBy.name" placeholder="Поиск по названию города">Город
                    </InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <InputGroup v-model="searchBy.regionName" placeholder="Поиск по названию региона">Регион
                    </InputGroup>
                </div>
            </Filter>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-0">
                    <div v-if="filteredItems.length > 0" class="table-responsive">
                        <table class="table table-bordered my-4 text-center align-middle text-nowrap"
                               style="width: 100%;">
                            <thead>
                            <tr>
                                <template
                                    v-for="{ column, label, sortable, is_num, width } in thFields"
                                    :key="column"
                                >
                                    <ThSort
                                        :is-numeric="is_num"
                                        :sort-by-asc="arrayHandlers.sortBy.asc"
                                        :sort-by-column="arrayHandlers.sortBy.column === column"
                                        :sortable="sortable"
                                        :width="width"
                                        @setSort="arrayHandlers.setSort(column, is_num)"
                                    >{{ label }}
                                    </ThSort>
                                </template>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in filteredItems" :key="item.id">
                                <th scope="row">
                                    {{ item.id }}
                                </th>
                                <td class="text-start">
                                    {{ item.name }}
                                </td>
                                <td class="text-start">
                                    {{ item.regionName }}
                                </td>
                                <TdButton
                                    :id="item.id"
                                    intent="view"
                                    @initModal="viewCityInit"
                                >View
                                </TdButton>
                                <TdButton
                                    :id="item.id"
                                    intent="edit"
                                    @initModal="editCityInit"
                                >Edit
                                </TdButton>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <p v-else class="mt-3 text-center lead">
                        {{ cityStore.isContentLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
                    </p>
                    <p>Всего записей: <span class="fw-bold">{{ filteredItems.length }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <Modal
        id="modalPopUp"
        :close-func="closeModal"
        :custom-classes="['']"
    >
        <template #title>
            <span v-if="state.isEditing">Редактирование города <b>{{ state.city.name }}</b></span>
            <span v-else>Добавление города</span>
        </template>
        <template #body>
            <Alert/>
            <div class="row g-3">
                <div class="col-12">
                    <Label for="name" required>Наименование города</Label>
                    <Input
                        id="name"
                        v-model="state.city.name"
                        placeholder="Например: Новосибирск"
                        type="text"
                    />
                </div>
                <div class="col-12">
                    <Label for="region_id" required>Регион</Label>
                    <select id="region_id" v-model="state.city.regionId" class="form-select">
                        <option disabled selected value="">-- Выберите регион --</option>
                        <option
                            v-for="region in state.regions"
                            :key="region.id"
                            :value="region.id"
                        >{{ region.name }}
                        </option>
                    </select>
                </div>
            </div>
        </template>
        <template #footer>
            <Button :class="state.isEditing ? 'btn-warning' : 'btn-primary'" :disabled="cityStore.isButtonDisabled"
                    :loading="cityStore.isButtonDisabled" class="w-25" type="button" @click="saveCity">
                <span v-if="state.isEditing">Сохранить</span>
                <span v-else>Создать</span>
            </Button>
        </template>
    </Modal>

    <Modal
        id="viewModalPopUp"
        :close-func="closeViewModal"
        :custom-classes="['']"
    >
        <template #title>
            Просмотр города <b>{{ state.city.name }}</b>
        </template>
        <template #body>
            <pre>
                {{ state.city }}
            </pre>
            <!--            <div v-if="state.region.citiesCount > 0">
                            <p>Всего городов в регионе: <span class="fw-bold">{{ state.region.citiesCount }}</span></p>
                            <table class="table table-bordered text-center align-middle text-nowrap"
                                   style="width: 100%;">
                                <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th class="text-start">Название города</th>
                                </tr>
                                <tr v-for="city in state.region.cities" :key="city.id">
                                    <td>{{ city.id }}</td>
                                    <td class="text-start">{{ city.name }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>-->
            <!--            <div v-else>
                            <p class="mb-0">Регион пустой. Наполните регион городами во вкладке <b>Справочники | Города</b>.</p>
                        </div>-->
        </template>
        <template #footer>
            <Button class="btn btn-light"></Button>
        </template>
    </Modal>
</template>

<script setup>
import Input from '@/components/form/Input.vue';
import Label from '@/components/form/Label.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import { computed, onMounted, reactive, watch } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useCityStore } from '@/stores/cities.js';
import { useRegionStore } from '@/stores/regions.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import InputGroup from '@/components/form/InputGroup.vue';
import Filter from '@/components/core/Filter.vue';
import Modal from '@/components/Modal.vue';
import ThSort from '@/components/table/ThSort.vue';
import TdButton from '@/components/table/TdButton.vue';

const cityStore = useCityStore();
const regionStore = useRegionStore();
const alertStore = useAlertStore();
const arrayHandlers = useArrayHandlers();

const initialFormData = () => ({
    name: '',
    regionId: '',
});

const state = reactive({
    cities: [],
    regions: [],
    city: initialFormData(),
    isEditing: false,
});

const thFields = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Город', sortable: true, is_num: false },
    { column: 'regionName', label: 'Регион', sortable: true, is_num: false },
    { column: 'view', label: 'Просмотр', width: 10 },
    { column: 'edit', label: 'Ред.', width: 10 },
];

const searchBy = reactive({
    name: '',
    regionName: '',
});

let modalPopUp = null;
let viewModalPopUp = null;

onMounted(async () => {
    await getCities();
    await getRegions();

    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', () => {
        state.isEditing = false;
        state.city = initialFormData();
    });
});

const getCities = async () => {
    const { data } = await cityStore.all();
    state.cities = data.data;
};

const getRegions = async () => {
    const { data } = await regionStore.all();
    state.regions = data.data;
};

const createCityInit = () => {
    alertStore.clear();
    state.isEditing = false;
    state.city = initialFormData();
    modalPopUp.show();
};

const editCityInit = (id) => {
    alertStore.clear();
    state.isEditing = true;
    state.city = cityStore.oneCity(id);
    modalPopUp.show();
};

// TODO: make view of the city
const viewCityInit = (id) => {
    viewModalPopUp = new bootstrap.Modal(document.getElementById('viewModalPopUp'));
    state.city = cityStore.oneCity(id);
    viewModalPopUp.show();
    viewModalPopUp._element.addEventListener('hide.bs.modal', () => {
        state.isEditing = false;
        state.city = initialFormData();
    });
};

const closeModal = () => {
    modalPopUp.hide();
};

const closeViewModal = () => {
    viewModalPopUp.hide();
};

watch(searchBy, () => {
    state.cities = arrayHandlers.filterArray(cityStore.getCities, searchBy);
});

const clearSearch = () => {
    arrayHandlers.resetSearchKeys(searchBy);
    arrayHandlers.resetSortKeys();
};

const saveCity = async () => {
    if ( state.isEditing ) {
        const response = await cityStore.update(state.city);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            modalPopUp.hide();
            await getCities();
        }
    } else {
        const response = await cityStore.save(state.city);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            state.city = initialFormData();
            modalPopUp.hide();
            arrayHandlers.resetSearchKeys(searchBy);
            arrayHandlers.resetSortKeys('id', false);
            await getCities();
        }
    }
};

const sortedItems = computed(() => {
    return arrayHandlers.sortArray(state.cities);
});

const filteredItems = computed(() => {
    return arrayHandlers.filterArray(sortedItems.value, searchBy);
});
</script>
