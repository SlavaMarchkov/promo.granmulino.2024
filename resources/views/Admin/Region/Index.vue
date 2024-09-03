<template>
    <div class="row mb-4">
        <div class="col-12">
            <button
                class="btn btn-primary"
                type="button"
                @click="createRegionInit"
            >
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
                                    <RouterLink :to="{
                                        name: 'Region.View',
                                        params: {
                                            'id': item.id
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
                                <TdButton
                                    :id="item.id"
                                    intent="view"
                                    @runButtonHandler="viewRegionInit"
                                >View
                                </TdButton>
                                <TdButton
                                    :id="item.id"
                                    intent="edit"
                                    @runButtonHandler="editRegionInit"
                                >Edit
                                </TdButton>
                                <TdButton
                                    :id="item.id"
                                    intent="delete"
                                    @runButtonHandler="deleteRegion"
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
            <span v-if="state.isEditing">Редактирование региона <b>{{ state.region.name }}</b></span>
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
            <Button
                :class="state.isEditing
                    ? 'btn-warning'
                    : 'btn-primary'"
                :disabled="spinnerStore.isButtonDisabled"
                :loading="spinnerStore.isButtonDisabled"
                class="w-25"
                type="button"
                @click="saveRegion"
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
            Просмотр региона <b>{{ state.region.name }}</b>
        </template>
        <template #body>
            <div v-if="state.region.citiesCount > 0">
                <div class="bd-callout bd-callout-info">
                    <p>Всего городов в регионе: <strong>{{ state.region.citiesCount }}</strong></p>
                </div>
                <table class="table table-bordered text-center align-middle text-nowrap"
                       style="width: 100%;">
                    <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th class="text-start">Название города</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="city in state.region.cities" :key="city.id">
                        <td>{{ city.id }}</td>
                        <td class="text-start">{{ city.name }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="bd-callout bd-callout-warning">
                <h5>Регион пустой</h5>
                <hr>
                <p>Наполните регион городами во вкладке <b>Справочники | Города</b>.</p>
            </div>
        </template>
        <template #footer>
            <span></span>
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
import { useSpinnerStore } from '@/stores/spinners.js';
import { useRegionStore } from '@/stores/regions.js';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import InputGroup from '@/components/form/InputGroup.vue';
import Filter from '@/components/core/Filter.vue';
import Modal from '@/components/Modal.vue';
import ThSort from '@/components/table/ThSort.vue';
import TdButton from '@/components/table/TdButton.vue';

const regionStore = useRegionStore();
const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();
const { get, post, update, destroy } = useHttpService();

const regionURL = '/admin/regions';

const initialFormData = () => ({
    code: '',
    name: '',
});

const state = reactive({
    regions: [],
    region: initialFormData(),
    isEditing: false,
});

const thFields = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Название региона', sortable: true, is_num: false },
    { column: 'code', label: 'Код региона', sortable: true, is_num: false },
    { column: 'citiesCount', label: 'Количество городов', sortable: true, is_num: true },
    { column: 'view', label: 'Просмотр', width: 10 },
    { column: 'edit', label: 'Ред.', width: 10 },
    { column: 'delete', label: 'Удалить', width: 10 },
];

const searchBy = reactive({
    code: '',
    name: '',
});

let modalPopUp = null;
let viewModalPopUp = null;

function resetState() {
    state.isEditing = false;
    state.region = initialFormData();
}

onMounted(async () => {
    await getRegions();
    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', resetState);
});

const getRegions = async () => {
    const { data } = await get(regionURL);
    regionStore.setRegions(data.regions);
    state.regions = regionStore.getRegions;
};

const createRegionInit = () => {
    alertStore.clear();
    state.isEditing = false;
    state.region = initialFormData();
    modalPopUp.show();
};

const editRegionInit = (id) => {
    alertStore.clear();
    state.isEditing = true;
    state.region = regionStore.oneRegion(id);
    modalPopUp.show();
};

const viewRegionInit = (id) => {
    viewModalPopUp = new bootstrap.Modal(document.getElementById('viewModalPopUp'));
    state.region = regionStore.oneRegion(id);
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

watch(searchBy, () => {
    state.regions = arrayHandlers.filterArray(regionStore.getRegions, searchBy);
});

const clearSearch = () => {
    arrayHandlers.resetSearchKeys(searchBy);
    arrayHandlers.resetSortKeys();
};

const saveRegion = async () => {
    if ( state.isEditing ) {
        const response = await update(`${ regionURL }/${ state.region.id }`, state.region);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            modalPopUp.hide();
            await getRegions();
        }
    } else {
        const response = await post(regionURL, state.region);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            state.region = initialFormData();
            modalPopUp.hide();
            arrayHandlers.resetSearchKeys(searchBy);
            arrayHandlers.resetSortKeys('id', false);
            await getRegions();
        }
    }
};

const deleteRegion = async (id) => {
    if ( confirm('Точно удалить регион? Уверены?') ) {
        const response = await destroy(`${ regionURL }/${ id }`);
        if ( response && response.status === 'success' ) {
            await getRegions();
        }
    }
};

const sortedItems = computed(() => {
    return arrayHandlers.sortArray(state.regions);
});

const filteredItems = computed(() => {
    return arrayHandlers.filterArray(sortedItems.value, searchBy);
});
</script>
