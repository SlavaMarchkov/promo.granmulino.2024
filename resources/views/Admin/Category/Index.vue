<template>
    <div class="row mb-4">
        <div class="col-12">
            <button
                class="btn btn-primary"
                type="button"
                @click="createCategoryInit"
            >
                Новая группа товаров
            </button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <Filter @reset-filter="clearSearch">
                <div class="col-md-4 mb-2">
                    <InputGroup
                        v-model="searchBy.name"
                        placeholder="Поиск по названию группы товаров"
                    >Группа товаров
                    </InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <Checkbox
                        id="is_active"
                        v-model="searchBy.isActive"
                    >В продаже?
                    </Checkbox>
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
                                    v-for="{ column, label, sortable, is_num, width } in CATEGORY_TH_FIELDS"
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
                                <td>
                                    {{ item.productsCount }}
                                </td>
                                <td>
                                    <TheBadge :is-active="item.isActive"/>
                                </td>
                                <TdButton
                                    :id="item.id"
                                    intent="view"
                                    @runButtonHandler="viewCategoryInit"
                                >View
                                </TdButton>
                                <TdButton
                                    :id="item.id"
                                    intent="edit"
                                    @runButtonHandler="editCategoryInit"
                                >Edit
                                </TdButton>
                                <TdButton
                                    :id="item.id"
                                    intent="delete"
                                    @runButtonHandler="deleteCategory"
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
            <span v-if="state.isEditing">Редактирование группы товаров <b>{{ state.category.name }}</b></span>
            <span v-else>Добавление группы товаров</span>
        </template>
        <template #body>
            <Alert/>
            <div class="row g-3">
                <div class="col-12">
                    <TheLabel for="name" required>Название группы товаров</TheLabel>
                    <TheInput
                        id="name"
                        v-model="state.category.name"
                        placeholder="Например: Granmulino Премиум"
                        type="text"
                    />
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input
                            id="is-active"
                            v-model="state.category.isActive"
                            :checked="state.category.isActive"
                            class="form-check-input"
                            type="checkbox"
                        >
                        <label class="form-check-label" for="is-active">
                            Группа товаров в продаже?
                        </label>
                    </div>
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
                @click="saveCategory"
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
            Просмотр группы товаров <b>{{ state.category.name }}</b>
        </template>
        <template #body>
            <div v-if="state.category.productsCount > 0">
                <div class="bd-callout bd-callout-info">
                    <p>Кол-во SKU в группе: <strong>{{ state.category.productsCount }}</strong></p>
                </div>
                <table class="table table-bordered text-center align-middle text-nowrap"
                       style="width: 100%;">
                    <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th class="text-start">Формат</th>
                        <th>Вес, г</th>
                        <th>Цена, руб.</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in state.category.products" :key="product.id">
                        <td>{{ product.id }}</td>
                        <td class="text-start">{{ product.name }}</td>
                        <td>{{ product.weight }}</td>
                        <td>{{ product.price }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="bd-callout bd-callout-warning">
                <h5>В группе нет продукции</h5>
                <hr>
                <p>Наполните группу товаров ассортиментом во вкладке <b>Справочники | Ассортимент</b>.</p>
            </div>
        </template>
        <template #footer>
            <Button class="btn btn-light"></Button>
        </template>
    </Modal>
</template>

<script setup>
import TheInput from '@/components/form/TheInput.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import Checkbox from '@/components/form/Checkbox.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import { computed, onMounted, reactive, watch } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import InputGroup from '@/components/form/InputGroup.vue';
import Filter from '@/components/core/Filter.vue';
import TheBadge from '@/components/core/TheBadge.vue';
import Modal from '@/components/Modal.vue';
import ThSort from '@/components/table/ThSort.vue';
import TdButton from '@/components/table/TdButton.vue';
import { CATEGORY_TH_FIELDS, URLS } from '@/helpers/constants.js';

const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();
const { get, post, update, destroy } = useHttpService();

const initialFormData = () => ({
    name: '',
    isActive: true,
});

const state = reactive({
    categories: [],
    category: initialFormData(),
    isEditing: false,
});

const searchBy = reactive({
    name: '',
    isActive: false,
});

let modalPopUp = null;
let viewModalPopUp = null;

function resetState() {
    state.isEditing = false;
    state.category = initialFormData();
}

onMounted(async () => {
    await getCategories();
    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', resetState);
});

const getCategories = async () => {
    const { data } = await get(URLS.CATEGORY);
    state.categories = data.categories;
};

const getOneCategory = (id) => state.categories.find(category => category.id === id);

const createCategoryInit = () => {
    alertStore.clear();
    state.isEditing = false;
    state.category = initialFormData();
    modalPopUp.show();
};

const editCategoryInit = (id) => {
    alertStore.clear();
    state.isEditing = true;
    state.category = getOneCategory(id);
    modalPopUp.show();
};

const viewCategoryInit = (id) => {
    viewModalPopUp = new bootstrap.Modal(document.getElementById('viewModalPopUp'));
    state.category = getOneCategory(id);
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

const saveCategory = async () => {
    if ( state.isEditing ) {
        const response = await update(`${ URLS.CATEGORY }/${ state.category.id }`, state.category);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            modalPopUp.hide();
            await getCategories();
        }
    } else {
        const response = await post(URLS.CATEGORY, state.category);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            state.category = initialFormData();
            modalPopUp.hide();
            arrayHandlers.resetSearchKeys(searchBy);
            arrayHandlers.resetSortKeys('id', false);
            await getCategories();
        }
    }
};

const deleteCategory = async (id) => {
    if ( confirm('Точно удалить группу товаров? Уверены?') ) {
        const response = await destroy(`${ URLS.CATEGORY }/${ id }`);
        if ( response && response.status === 'success' ) {
            await getCategories();
        }
    }
};

const sortedItems = computed(() => {
    return arrayHandlers.sortArray(state.categories);
});

const filteredItems = computed(() => {
    return arrayHandlers.filterArray(sortedItems.value, searchBy);
});

watch(searchBy, () => {
    filteredItems.value = arrayHandlers.filterArray(state.categories, searchBy);
});
</script>
