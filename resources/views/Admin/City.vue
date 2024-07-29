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
                                            v-model="searchName"
                                            type="text"
                                            class="form-control"
                                            placeholder="Поиск по названию города"
                                        />
                                        <span @click="searchName = ''" class="input-group-text"
                                              style="cursor: pointer;"><i
                                            class="bi bi-x-lg"></i></span>
                                    </div>
                                </td>
                                <td class="py-1">
                                    <div class="input-group">
                                        <input
                                            v-model="searchRegion"
                                            type="text"
                                            class="form-control"
                                            placeholder="Поиск по названию региона"
                                        />
                                        <span @click="searchRegion = ''" class="input-group-text"
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
                               class="table table-bordered mb-4 text-center align-middle">
                            <thead>
                            <tr>
                                <ThSort
                                    :id="'id'"
                                    sort-type="numeric"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='5'
                                    @sortByColumn="updateSorting('id')"
                                >ID
                                </ThSort>
                                <ThSort
                                    :id="'name'"
                                    sort-type="alpha"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    class="text-start"
                                    :width='30'
                                    @sortByColumn="updateSorting('name')"
                                >Название города
                                </ThSort>
                                <ThSort
                                    :id="'region'"
                                    sort-type="alpha"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    class="text-start"
                                    @sortByColumn="updateSorting('region')"
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
                                    {{ city.region }}
                                </td>
                                <td>
                                    <button
                                        @click="showViewCityModal(city.id)"
                                        class="btn btn-sm btn-success"
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
</template>

<script setup>
import Input from '@/components/core/Input.vue';
import Label from '@/components/core/Label.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import { onMounted, ref, watch } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useCityStore } from '@/stores/cities.js';
import { useRegionStore } from '@/stores/regions.js';
import Swal from 'sweetalert2';
import ThSort from '@/components/core/ThSort.vue';
import Spinner from '@/components/core/Spinner.vue';

const cityStore = useCityStore();
const regionStore = useRegionStore();
const alertStore = useAlertStore();

const initialFormData = () => ({
    name: '',
    regionId: '',
});

const form = ref(initialFormData());
const cities = ref([]);
const regions = ref([]);
const city = ref({});

const searchName = ref('');
const searchRegion = ref('');

const orderColumn = ref('id');
const orderDirection = ref('desc');

let newCityModal = ref(null);
let editCityModal = ref(null);

onMounted(async () => {
    await getCities();
});

const getCities = async (order_column = 'id', order_direction = 'desc') => {
    const response = await cityStore.all(order_column, order_direction);
    cities.value = response.data;
};

const getRegions = async () => {
    const response = await regionStore.all('name', 'asc');
    regions.value = response.data;
};

const getCity = async (id) => {
    const response = await cityStore.one(id);
    city.value = response.data;
};

const showNewCityModal = async () => {
    alertStore.clear();
    newCityModal = new bootstrap.Modal(document.getElementById('newCity'));
    newCityModal.show();
    await getRegions();
};

const showEditCityModal = async (id) => {
    alertStore.clear();
    editCityModal = new bootstrap.Modal(document.getElementById('editCity'));
    editCityModal.show();
    await getRegions();
    await getCity(id);
};

const saveCity = async () => {
    const response = await cityStore.save(form.value);
    if ( response && response.status === 201 ) {
        form.value = initialFormData();
        alertStore.clear();
        newCityModal.hide();
        await Swal.fire({
            icon: response.data.status,
            title: 'Well done!',
            text: response.data.message,
        });
        searchName.value = '';
        searchRegion.value = '';
        orderColumn.value = 'id';
        orderDirection.value = 'desc';
        await getCities();
    }
};

const updateCity = async (city) => {
    const response = await cityStore.update(city);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        editCityModal.hide();
        await getCities(orderColumn.value, orderDirection.value);
        updateSorting(orderColumn.value);
    }
};

const deleteCity = (id) => {
    const cityName = cityStore.getCities
        .filter(s => s.id === id)
        .map(s => s.name);

    Swal.fire({
        title: 'Вы уверены?',
        text: `Удаляемый город: ${cityName}`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Да, удалить',
        cancelButtonText: 'Отменить',
        confirmButtonColor: '#ef4444',
        timer: 10_000,
        timerProgressBar: true,
        reverseButtons: true,
    }).then(async (result) => {
        if ( result.isConfirmed ) {
            await cityStore.delete(id);
            searchName.value = '';
            searchRegion.value = '';
            orderColumn.value = 'id';
            orderDirection.value = 'desc';
            await getCities();
        }
    });
};

const clearSearch = async () => {
    searchName.value = '';
    searchRegion.value = '';
    orderColumn.value = 'id';
    orderDirection.value = 'desc';
    await getCities();
};

watch(searchName, (current) => {
    cities.value = cityStore.getCities
        .filter(item => item.name.toLowerCase().includes(current.toLowerCase()))
        .filter(item => item.region.toLowerCase().includes(searchRegion.value.toLowerCase()));
});

watch(searchRegion, (current) => {
    cities.value = cityStore.getCities
        .filter(item => item.region.toLowerCase().includes(current.toLowerCase()))
        .filter(item => item.name.toLowerCase().includes(searchName.value.toLowerCase()));
});

const updateSorting = (column) => {
    orderColumn.value = column;
    orderDirection.value = orderDirection.value === 'asc' ? 'desc' : 'asc';

    const tempArr = cityStore.getCities
        .filter(item => item.name.toLowerCase().includes(searchName.value.toLowerCase()))
        .filter(item => item.region.toLowerCase().includes(searchRegion.value.toLowerCase()));

    cities.value = tempArr.sort((a, b) => {
        if ( column === 'id' ) {
            return orderDirection.value === 'asc'
                ? a.id - b.id
                : b.id - a.id;
        } else {
            return orderDirection.value === 'asc'
                ? a[column].localeCompare(b[column])
                : b[column].localeCompare(a[column]);
        }
    });
};
</script>
