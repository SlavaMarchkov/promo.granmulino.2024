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
                                    v-for="{ column, label, sortable, is_num, width } in CITY_TH_FIELDS"
                                    :key="column"
                                >
                                    <ThSort
                                        :column="column"
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
                                    <RouterLink :to="{
                                        name: 'Region.View',
                                        params: {
                                            'id': item.regionId
                                        },
                                    }">{{ item.regionName }}
                                    </RouterLink>
                                </td>
                                <TdButton
                                    :id="item.id"
                                    intent="view"
                                    @runButtonHandler="viewCityInit"
                                >View
                                </TdButton>
                                <TdButton
                                    :id="item.id"
                                    intent="edit"
                                    @runButtonHandler="editCityInit"
                                >Edit
                                </TdButton>
                                <TdButton
                                    :id="item.id"
                                    intent="delete"
                                    @runButtonHandler="deleteCity"
                                >Delete
                                </TdButton>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <p v-else class="mt-3 text-center lead">
                        {{ spinnerStore.isLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
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
                    <TheLabel for="name" required>Наименование города</TheLabel>
                    <Input
                        id="name"
                        v-model="state.city.name"
                        placeholder="Например: Новосибирск"
                        type="text"
                    />
                </div>
                <div class="col-12">
                    <TheLabel for="region_id" required>Регион</TheLabel>
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
            <Button
                :class="state.isEditing
                    ? 'btn-warning'
                    : 'btn-primary'"
                :disabled="spinnerStore.isButtonDisabled"
                :loading="spinnerStore.isButtonDisabled"
                class="w-25"
                type="button"
                @click="saveCity"
            >
                <span v-if="state.isEditing">Сохранить</span>
                <span v-else>Создать</span>
            </Button>
        </template>
    </Modal>

    <Modal
        id="viewModalPopUp"
        :close-func="closeViewModal"
        :custom-classes="['modal-dialog-scrollable']"
    >
        <template #title>
            Просмотр города <b>{{ state.city.name }}</b>
        </template>
        <template #body>
            <table class="table table-bordered mt-3 align-middle text-wrap"
                   style="width: 100%;">
                <tbody>
                <tr>
                    <th style="width: 30%;">ID</th>
                    <td>{{ state.city.id }}</td>
                </tr>
                <tr>
                    <th>Название</th>
                    <td>{{ state.city.name }}</td>
                </tr>
                <tr>
                    <th>Регион</th>
                    <td>{{ state.city.regionName }}</td>
                </tr>
                </tbody>
            </table>
        </template>
        <template #footer>
            <span></span>
        </template>
    </Modal>
</template>

<script setup>
import Input from '@/components/form/Input.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import { computed, onMounted, reactive, watch } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import InputGroup from '@/components/form/InputGroup.vue';
import Filter from '@/components/core/Filter.vue';
import Modal from '@/components/Modal.vue';
import ThSort from '@/components/table/ThSort.vue';
import TdButton from '@/components/table/TdButton.vue';
import { CITY_TH_FIELDS, URLS } from '@/helpers/constants.js';

const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();
const { get, post, update, destroy } = useHttpService();

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

const searchBy = reactive({
    name: '',
    regionName: '',
});

let modalPopUp = null;
let viewModalPopUp = null;

function resetState() {
    state.isEditing = false;
    state.city = initialFormData();
}

onMounted(async () => {
    await getCities();
    await getRegions();
    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', resetState);
});

const getCities = async () => {
    const { data } = await get(URLS.CITY);
    state.cities = data.cities;
};

const getOneCity = (id) => state.cities.find(city => city.id === id);

const getRegions = async () => {
    const { data } = await get(URLS.REGION);
    state.regions = data.regions;
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
    state.city = getOneCity(id);
    modalPopUp.show();
};

const viewCityInit = (id) => {
    viewModalPopUp = new bootstrap.Modal(document.getElementById('viewModalPopUp'));
    state.city = getOneCity(id);
    viewModalPopUp.show();
    viewModalPopUp._element.addEventListener('hide.bs.modal', resetState);
};

const closeModal = () => {
    modalPopUp.hide();
    modalPopUp._element.removeEventListener('hide.bs.modal', resetState);
};

const closeViewModal = () => {
    viewModalPopUp.hide();
    viewModalPopUp._element.removeEventListener('hide.bs.modal', resetState);
};

const clearSearch = () => {
    arrayHandlers.resetSearchKeys(searchBy);
    arrayHandlers.resetSortKeys();
};

const saveCity = async () => {
    if ( state.isEditing ) {
        const response = await update(`${ URLS.CITY }/${ state.city.id }`, state.city);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            modalPopUp.hide();
            await getCities();
        }
    } else {
        const response = await post(URLS.CITY, state.city);
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

const deleteCity = async (id) => {
    if ( confirm('Точно удалить город? Уверены?') ) {
        const response = await destroy(`${ URLS.CITY }/${ id }`);
        if ( response && response.status === 'success' ) {
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

watch(searchBy, () => {
    filteredItems.value = arrayHandlers.filterArray(state.cities, searchBy);
});
</script>
