<template>
    <div class="row mb-4">
        <div class="col-12">
            <button class="btn btn-primary me-2" type="button" @click="showNewRegionModal">
                Новый регион
            </button>
            <button class="btn btn-secondary" type="button" @click="clearSearch">
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
                                <td class="py-1" style="width: 35%;">
                                    <div class="input-group">
                                        <input
                                            v-model="searchBy.name"
                                            class="form-control"
                                            placeholder="Поиск по названию региона"
                                            type="text"
                                        />
                                        <span class="input-group-text" style="cursor: pointer;"
                                              @click="searchBy.name = ''"><i
                                            class="bi bi-x-lg"></i></span>
                                    </div>
                                </td>
                                <td class="py-1" style="width: 20%;">
                                    <div class="input-group">
                                        <input
                                            v-model="searchBy.code"
                                            class="form-control"
                                            placeholder="Поиск по коду региона"
                                            type="text"
                                        />
                                        <span class="input-group-text" style="cursor: pointer;"
                                              @click="searchBy.code = ''"><i
                                            class="bi bi-x-lg"></i></span>
                                    </div>
                                </td>
                                <td class="py-1" style="width: 20%;"></td>
                                <td class="py-1" style="width: 10%;"></td>
                                <td class="py-1" style="width: 10%;"></td>
                            </tr>
                            </tbody>
                        </table>
                        <table v-if="regions.length > 0" class="table table-bordered mb-3 text-center align-middle"
                               style="margin-top: -1px;">
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
                                    :width='35'
                                    class="text-start"
                                    sort-type="alpha"
                                    @sortByColumn="applyFilterSort(
                                        'name',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                        false,
                                    )"
                                >Название региона
                                </ThSort>
                                <ThSort
                                    :id="'code'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='20'
                                    class="text-start"
                                    sort-type="alpha"
                                    @sortByColumn="applyFilterSort(
                                        'code',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                        false,
                                    )"
                                >Код
                                </ThSort>
                                <ThSort
                                    :id="'citiesCount'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='20'
                                    sort-type="numeric"
                                    @sortByColumn="applyFilterSort(
                                        'citiesCount',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                    )"
                                >Количество городов
                                </ThSort>
                                <th scope="col" style="width: 10%;">Просмотр</th>
                                <th scope="col" style="width: 10%;">Ред.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="region in regions" :key="region.id">
                                <th scope="row">{{ region.id }}</th>
                                <td class="text-start" style="cursor: pointer;" @click="showViewRegionModal(region.id)">
                                    {{ region.name }}
                                </td>
                                <td class="text-start">
                                    {{ region.code }}
                                </td>
                                <td>
                                    {{ region.citiesCount }}
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-primary"
                                        @click="showViewRegionModal(region.id)"
                                    ><i class="bi bi-eye-fill"></i>
                                        View
                                    </button>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-warning"
                                        @click="showEditRegionModal(region.id)"
                                    ><i class="bi bi-pencil-square"></i>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p v-else class="mt-3 text-center lead">
                            {{ regionStore.isContentLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
                        </p>
                    </div>
                    <p>Всего записей: <span class="fw-bold">{{ regions.length }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- New Region Modal Start -->
    <div id="newRegion" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Добавление региона</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <Alert/>
                        <div class="row g-3">
                            <form @submit.prevent="saveRegion">
                            <div class="col-12">
                                <Label for="code" required>Код региона</Label>
                                <Input
                                    v-model="form.code"
                                    type="text"
                                    id="code"
                                    placeholder="Например: УФО"
                                />
                            </div>
                            <div class="col-12">
                                <Label for="name" required>Наименование региона</Label>
                                <Input
                                    v-model="form.name"
                                    type="text"
                                    id="name"
                                    placeholder="Например: Уральский федеральный округ"
                                />
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <Button
                            type="submit"
                            :loading="regionStore.isButtonDisabled"
                            :disabled="regionStore.isButtonDisabled"
                            class="w-25"
                        >Сохранить
                        </Button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>

        </div>
    </div>
    <!-- New Region Modal End -->

    <!-- Edit Region Modal Start -->
    <div id="editRegion" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">
            <form @submit.prevent="updateRegion(region)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактирование региона</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <Alert/>
                        <Spinner v-if="regionStore.isCardLoading"/>
                        <div v-else class="row g-3">
                            <div class="col-12">
                                <Label for="edit-code" required>Код региона</Label>
                                <Input
                                    v-model="region.code"
                                    type="text"
                                    id="edit-code"
                                    placeholder="Например: УФО"
                                />
                            </div>
                            <div class="col-12">
                                <Label for="edit-name" required>Название региона</Label>
                                <Input
                                    v-model="region.name"
                                    type="text"
                                    id="edit-name"
                                    placeholder="Например: Уральский федеральный округ"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <Button
                            type="submit"
                            :loading="regionStore.isButtonDisabled"
                            :disabled="regionStore.isButtonDisabled"
                            class="w-25"
                        >Сохранить
                        </Button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Edit Region Modal End -->

    <!-- View One Region Modal Start -->
    <div id="viewRegion" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Просмотр региона</h5>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <pre>
                        {{ region }}
                    </pre>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <!-- View One Region Modal End -->
</template>

<script setup>
import Input from '@/components/core/Input.vue';
import Label from '@/components/core/Label.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import { onMounted, reactive, ref, watch } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useRegionStore } from '@/stores/regions.js';
import ThSort from '@/components/core/ThSort.vue';
import Spinner from '@/components/core/Spinner.vue';
// import { arrFilter, arrSort } from '@/helpers/arrHandlers.js';
// import { resetSearchKeys } from '@/helpers/searchHandlers.js';

const regionStore = useRegionStore();
const alertStore = useAlertStore();

const initialFormData = () => ({
    code: '',
    name: '',
});

let form = reactive(initialFormData());

const regions = ref([]);
const region = ref({});

const searchBy = reactive({
    code: '',
    name: '',
});

let orderColumn = 'id';
let orderDirection = 'asc';

let newRegionModal = null;
let editRegionModal = null;
let viewRegionModal = null;

onMounted(async () => {
    await getRegions();
});

const getRegions = async () => {
    await regionStore.all();
    applyFilterSort();
};

const getRegion = async (id) => {
    region.value = regionStore.getRegions
        .find(item => item.id === id);
};

const showNewRegionModal = () => {
    alertStore.clear();
    newRegionModal = new bootstrap.Modal(document.getElementById('newRegion'));
    newRegionModal.show();
};

const showEditRegionModal = (id) => {
    alertStore.clear();
    editRegionModal = new bootstrap.Modal(document.getElementById('editRegion'));
    editRegionModal.show();
    getRegion(id);
};

// TODO: make view
const showViewRegionModal = (id) => {
    viewRegionModal = new bootstrap.Modal(document.getElementById('viewRegion'));
    viewRegionModal.show();
    getRegion(id);
};

const saveRegion = async () => {
    const response = await regionStore.save(form);
    if ( response && response.status === 'success' ) {
        form = initialFormData();
        alertStore.clear();
        newRegionModal.hide();
        resetSearchKeys(searchBy);
        orderColumn = 'id';
        orderDirection = 'desc';
        await getRegions();
    }
};

const updateRegion = async (region) => {
    const response = await regionStore.update(region);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        editRegionModal.hide();
        await getRegions();
    }
};

const clearSearch = () => {
    resetSearchKeys(searchBy);
    applyFilterSort(
        (orderColumn = 'id'),
        (orderDirection = 'asc'),
    );
};

watch(searchBy, () => applyFilterSort());

const applyFilterSort = (
    column = orderColumn,
    direction = orderDirection,
    sort_by_numeric = true,
) => {
    orderColumn = column;
    orderDirection = direction;

    let tempArr = regionStore.getRegions.slice();

    tempArr = arrSort(tempArr, sort_by_numeric, direction, column);
    tempArr = arrFilter(tempArr, searchBy);

    regions.value = tempArr;
};
</script>
