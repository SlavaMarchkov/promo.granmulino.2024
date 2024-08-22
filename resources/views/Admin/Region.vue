<template>
    <div class="row mb-4">
        <div class="col-12">
            <button class="btn btn-primary" type="button" @click="createRegionInit">
                Новый регион
            </button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <Filter @reset-filter="clearSearch">
                <div class="col-md-4 mb-2">
                    <InputGroup v-model="searchBy.name" placeholder="Поиск по названию региона">Название
                    </InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <InputGroup v-model="searchBy.code" placeholder="Поиск по коду региона">Код
                    </InputGroup>
                </div>
            </Filter>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-0">
                    <div v-if="state.regions.length > 0" class="table-responsive">
                        <table class="table table-bordered my-4 text-center align-middle text-nowrap"
                               style="width: 100%;">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th class="text-start" scope="col">Название региона</th>
                                <th class="text-start" scope="col">Код региона</th>
                                <th scope="col">Количество городов</th>
                                <th scope="col" style="width: 10%;">Просмотр</th>
                                <th scope="col" style="width: 10%;">Ред.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in state.regions" :key="item.id">
                                <th scope="row">
                                    {{ item.id }}
                                </th>
                                <td class="text-start">
                                    <RouterLink :to="{
                                        name: 'Region.View',
                                        params: {
                                            'id': item.id,
                                        },
                                    }">{{ item.name }}
                                    </RouterLink>
                                </td>
                                <td class="text-start">
                                    {{ item.code }}
                                </td>
                                <td>
                                    {{ item.citiesCount }}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" @click="viewRegionInit(item.id)"><i
                                        class="bi bi-eye-fill"></i>
                                        View
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" @click="editRegionInit(item.id)"><i
                                        class="bi bi-pencil-square"></i>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <p v-else class="mt-3 text-center lead">
                        {{ regionStore.isContentLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
                    </p>
                    <p>Всего записей: <span class="fw-bold">{{ state.regions.length }}</span></p>
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
            <span v-if="state.isEditing">Редактирование региона <br>«<b>{{ state.region.name }}</b>»</span>
            <span v-else>Добавление региона</span>
        </template>
        <template #body>
            <Alert/>
            <div class="row g-3">
                <div class="col-12">
                    <Label for="name" required>Наименование региона</Label>
                    <Input
                        id="name"
                        v-model="state.region.name"
                        placeholder="Например: Уральский федеральный округ"
                        type="text"
                    />
                </div>
                <div class="col-12">
                    <Label for="code" required>Код региона</Label>
                    <Input
                        id="code"
                        v-model="state.region.code"
                        placeholder="Например: УФО"
                        type="text"
                    />
                </div>
            </div>
        </template>
        <template #footer>
            <Button :class="state.isEditing ? 'btn-warning' : 'btn-primary'" :disabled="regionStore.isButtonDisabled"
                    :loading="regionStore.isButtonDisabled" class="w-25" type="button" @click="saveRegion">
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
            Просмотр региона <br>«<b>{{ state.region.name }}</b>»
        </template>
        <template #body>
            <div v-if="state.region.citiesCount > 0">
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
            </div>
            <div v-else>
                <p class="mb-0">Регион пустой. Наполните регион городами во вкладке <b>Справочники | Города</b>.</p>
            </div>
        </template>
        <template #footer>
            <Button class="btn btn-light"></Button>
        </template>
    </Modal>
</template>

<script setup>
import Input from '@/components/core/Input.vue';
import Label from '@/components/core/Label.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import { onMounted, reactive, watch } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useRegionStore } from '@/stores/regions.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import InputGroup from '@/components/core/InputGroup.vue';
import Filter from '@/components/core/Filter.vue';
import Modal from '@/components/Modal.vue';

const regionStore = useRegionStore();
const alertStore = useAlertStore();
const arrayHandlers = useArrayHandlers();

const initialFormData = () => ({
    code: '',
    name: '',
});

const state = reactive({
    regions: [],
    region: initialFormData(),
    isEditing: false,
});

const searchBy = reactive({
    code: '',
    name: '',
});

let orderColumn = 'id';
let orderDirection = 'asc';

let modalPopUp = null;
let viewModalPopUp = null;

onMounted(async () => {
    await getRegions();

    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', () => {
        state.isEditing = false;
        state.region = initialFormData();
    });
});

const getRegions = async () => {
    const { data } = await regionStore.all();
    state.regions = arrayHandlers.filterArray(data.data, searchBy);
};

const createRegionInit = () => {
    alertStore.clear();
    state.isEditing = false;
    modalPopUp.show();
};

const editRegionInit = (id) => {
    alertStore.clear();
    state.isEditing = true;
    modalPopUp.show();
    state.region = regionStore.oneRegion(id);
};

const viewRegionInit = (id) => {
    viewModalPopUp = new bootstrap.Modal(document.getElementById('viewModalPopUp'));
    viewModalPopUp.show();
    state.region = regionStore.oneRegion(id);
};

const closeModal = () => {
    modalPopUp.hide();
};

const closeViewModal = () => {
    viewModalPopUp.hide();
};

watch(searchBy, () => {
    state.regions = arrayHandlers.filterArray(
        regionStore.getRegions,
        searchBy,
    );
});

const clearSearch = () => {
    arrayHandlers.resetSearchKeys(searchBy);
    /* applyFilterSort(
        (orderColumn.value = 'id'),
        (orderDirection.value = 'asc'),
    ); */
};

const saveRegion = async () => {
    if ( state.isEditing ) {
        const response = await regionStore.update(state.region);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            modalPopUp.hide();
            await getRegions();
        }
    } else {
        const response = await regionStore.save(state.region);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            state.region = initialFormData();
            modalPopUp.hide();
            arrayHandlers.resetSearchKeys(searchBy);
            //orderColumn.value = 'id';
            //orderDirection.value = 'desc';
            await getRegions();
        }
    }
};
</script>
