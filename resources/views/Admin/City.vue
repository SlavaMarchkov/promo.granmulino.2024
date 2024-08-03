<template>
    <div class="row mb-4">
        <div class="col-12">
            <button @click="showNewCityModal" type="button" class="btn btn-primary me-2">
                Новый город
            </button>
            <button @click="clearSearch" type="button" class="btn btn-secondary">
                Сбросить фильтр
            </button>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mt-4 mb-0 text-center align-middle">
                            <tbody>
                            <tr>
                                <td class="py-1" style="width: 5%;"></td>
                                <td class="py-1" style="width: 30%;">
                                    <div class="input-group">
                                        <input
                                            v-model="searchBy.name"
                                            type="text"
                                            class="form-control"
                                            placeholder="Поиск по названию города"
                                        />
                                        <span class="input-group-text" @click="searchBy.name = ''"
                                              style="cursor: pointer;"><i
                                            class="bi bi-x-lg"></i></span>
                                    </div>
                                </td>
                                <td class="py-1">
                                    <div class="input-group">
                                        <input
                                            v-model="searchBy.regionName"
                                            type="text"
                                            class="form-control"
                                            placeholder="Поиск по названию региона"
                                        />
                                        <span class="input-group-text" @click="searchBy.regionName = ''"
                                              style="cursor: pointer;"><i
                                            class="bi bi-x-lg"></i></span>
                                    </div>
                                </td>
                                <td class="py-1" style="width: 10%;"></td>
                                <td class="py-1" style="width: 10%;"></td>
                            </tr>
                            </tbody>
                        </table>
                        <table v-if="cities.length > 0" style="margin-top: -1px;"
                               class="table table-bordered mb-3 text-center align-middle">
                            <thead>
                            <tr>
                                <ThSort
                                    :id="'id'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='5'
                                    sort-type="numeric"
                                    @sortByColumn="applyFilterSort(
                                        'id',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                    )"
                                >ID
                                </ThSort>
                                <ThSort
                                    :id="'name'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='30'
                                    class="text-start"
                                    sort-type="alpha"
                                    @sortByColumn="applyFilterSort(
                                        'name',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                        false,
                                    )"
                                >Название города
                                </ThSort>
                                <ThSort
                                    :id="'regionName'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    class="text-start"
                                    sort-type="alpha"
                                    @sortByColumn="applyFilterSort(
                                        'regionName',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                        false,
                                    )"
                                >Регион
                                </ThSort>
                                <th scope="col" style="width: 10%;">Просмотр</th>
                                <th scope="col" style="width: 10%;">Ред.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="city in cities" :key="city.id">
                                <th scope="row">{{ city.id }}</th>
                                <td class="text-start" style="cursor: pointer;" @click="showViewCityModal(city.id)">
                                    {{ city.name }}
                                </td>
                                <td class="text-start">
                                    {{ city.regionName }}
                                </td>
                                <td>
                                    <button
                                        @click="showViewCityModal(city.id)"
                                        class="btn btn-sm btn-primary"
                                    >
                                        <i class="bi bi-eye-fill"></i>
                                        View
                                    </button>
                                </td>
                                <td>
                                    <button
                                        @click="showEditCityModal(city.id)"
                                        class="btn btn-sm btn-warning"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p v-else class="mt-3 text-center lead">
                            {{ cityStore.isContentLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
                        </p>
                    </div>
                    <p>Всего записей: <span class="fw-bold">{{ cities.length }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- New City Modal Start -->
    <div class="modal fade" id="newCity" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form @submit.prevent="saveCity">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Добавление города</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <Alert/>
                        <Spinner v-if="regionStore.isContentLoading"/>
                        <div v-else class="row g-3">
                            <div class="col-12">
                                <Label for="name" required>Название города</Label>
                                <Input
                                    v-model="form.name"
                                    type="text"
                                    id="name"
                                    placeholder="Например: Новосибирск"
                                />
                            </div>
                            <div class="col-12">
                                <Label for="region_id" required>Регион</Label>
                                <select v-model="form.regionId" id="region_id" class="form-select">
                                    <option value="" selected disabled>-- Выберите регион --</option>
                                    <option
                                        v-for="region in regions"
                                        :value="region.id"
                                        :key="region.id"
                                    >{{ region.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <Button
                            type="submit"
                            :loading="cityStore.isButtonDisabled"
                            :disabled="cityStore.isButtonDisabled"
                            class="w-25"
                        >Сохранить
                        </Button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- New City Modal End -->

    <!-- Edit One City Modal Start -->
    <div class="modal fade" id="editCity" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form @submit.prevent="updateCity(city)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактирование города</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <Alert/>
                        <Spinner v-if="regionStore.isContentLoading"/>
                        <div v-else class="row g-3">
                            <div class="col-12">
                                <Label for="edit-name" required>Название города</Label>
                                <Input
                                    v-model="city.name"
                                    type="text"
                                    id="edit-name"
                                    placeholder="Например: Новосибирск"
                                />
                            </div>
                            <div class="col-12">
                                <Label for="edit-region_id" required>Регион</Label>
                                <select
                                    v-model="city.regionId"
                                    id="edit-region_id"
                                    class="form-select"
                                >
                                    <option value="" selected disabled>-- Выберите регион --</option>
                                    <option
                                        v-for="region in regions"
                                        :value="region.id"
                                        :key="region.id"
                                    >{{ region.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <Button
                            type="submit"
                            :loading="cityStore.isButtonDisabled"
                            :disabled="cityStore.isButtonDisabled"
                            class="w-25"
                        >Сохранить
                        </Button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Edit One City Modal End -->

    <!-- View One City Modal Start -->
    <div id="viewCity" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Просмотр города</h5>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <pre>
                        {{ city }}
                    </pre>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <!-- View One City Modal End -->
</template>

<script setup>
import Input from '@/components/core/Input.vue';
import Label from '@/components/core/Label.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import ThSort from '@/components/core/ThSort.vue';
import Spinner from '@/components/core/Spinner.vue';
import { onMounted, reactive, ref, watch } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useCityStore } from '@/stores/cities.js';
import { useRegionStore } from '@/stores/regions.js';

const cityStore = useCityStore();
const regionStore = useRegionStore();
const alertStore = useAlertStore();

const initialFormData = () => ({
    name: '',
    regionId: '',
});

let form = reactive(initialFormData());

const cities = ref([]);
const regions = ref([]);
const city = ref({});

const searchBy = reactive({
    name: '',
    regionName: '',
});

let orderColumn = 'id';
let orderDirection = 'asc';

let newCityModal = null;
let editCityModal = null;
let viewCityModal = null;

onMounted(async () => {
    await getCities();
});

const getCities = async () => {
    await cityStore.all();
    applyFilterSort();
};

const getRegions = async () => {
    const response = await regionStore.all();
    regions.value = response.data;
};

const getCity = (id) => {
    city.value = cityStore.getCities
        .find(item => item.id === id);
};

const showNewCityModal = async () => {
    alertStore.clear();
    form = initialFormData();
    newCityModal = new bootstrap.Modal(document.getElementById('newCity'));
    newCityModal.show();
    await getRegions();
};

const showEditCityModal = async (id) => {
    alertStore.clear();
    editCityModal = new bootstrap.Modal(document.getElementById('editCity'));
    editCityModal.show();
    await getRegions();
    getCity(id);
};

// TODO: make view
const showViewCityModal = (id) => {
    viewCityModal = new bootstrap.Modal(document.getElementById('viewCity'));
    viewCityModal.show();
    getCity(id);
};

const saveCity = async () => {
    const response = await cityStore.save(form);
    if ( response && response.status === 'success' ) {
        form = initialFormData();
        alertStore.clear();
        newCityModal.hide();
        resetSearchKeys();
        orderColumn = 'id';
        orderDirection = 'desc';
        await getCities();
    }
};

const updateCity = async (city) => {
    const response = await cityStore.update(city);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        editCityModal.hide();
        await getCities();
    }
};

const clearSearch = () => {
    resetSearchKeys();
    applyFilterSort(
        (orderColumn = 'id'),
        (orderDirection = 'asc'),
    );
};

const resetSearchKeys = () => {
    for ( const key in searchBy ) {
        searchBy[key] = '';
    }
};

watch(searchBy, () => applyFilterSort());

const applyFilterSort = (
    column = orderColumn,
    direction = orderDirection,
    sort_by_numeric = true,
) => {
    orderColumn = column;
    orderDirection = direction;

    let tempArr = cityStore.getCities.slice();

    tempArr = tempArr.sort((a, b) => {
        if ( sort_by_numeric ) {
            return orderDirection === 'asc'
                ? a[column] - b[column]
                : b[column] - a[column];
        } else {
            const fa = a[column].toLowerCase();
            const fb = b[column].toLowerCase();

            return orderDirection === 'asc'
                ? fa.localeCompare(fb)
                : fb.localeCompare(fa);
        }
    });

    for ( const key in searchBy ) {
        if ( key === 'isActive' && searchBy[key] === true ) {
            tempArr = tempArr.filter(item => item[key] === true);
        } else if ( key !== 'isActive' && searchBy[key] !== '' ) {
            tempArr = tempArr.filter(item => item[key].toLowerCase().includes(searchBy[key].toLowerCase()));
        }
    }

    cities.value = tempArr;
};
</script>
