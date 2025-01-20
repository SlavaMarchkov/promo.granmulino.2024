<template>
    <div class="row mb-4">
        <div class="col-6">
            <h3 class="mb-0">{{ $route.meta.title }}</h3>
        </div>
        <div v-show="isSuperAdmin" class="col-6 text-end">
            <TheButton
                class="btn-primary"
                @click="createCategoryInit"
            >Новая группа товаров
            </TheButton>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <TheFilter
                @reset-filter="clearSearch"
            >
                <div class="col-md-4 mb-2">
                    <InputGroup
                        v-model="searchBy.name"
                        placeholder="Поиск по названию группы товаров"
                    >Группа товаров
                    </InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <TheCheckbox
                        id="is_active"
                        v-model="searchBy.isActive"
                    >В продаже?
                    </TheCheckbox>
                </div>
            </TheFilter>
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
                                    v-for="{ column, label, sortable, is_num, width } in thItems"
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
                                    <RouterLink
                                        :to="{ name: 'Category.View', params: { id: item.id } }"
                                    >
                                        {{ item.name }}
                                    </RouterLink>
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
                                <template
                                    v-if="isSuperAdmin"
                                >
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
                                </template>
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
            <TheButton
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
            </TheButton>
        </template>
    </Modal>

    <Modal
        id="viewModalPopUp"
        :close-func="closeViewModal"
        :custom-classes="['modal-dialog-scrollable', 'modal-lg']"
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
                        <th v-if="role === ROLES['PRICE_ADMIN']">Цена, руб.</th>
                        <th>В продаже?</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in state.category.products" :key="product.id">
                        <td>{{ product.id }}</td>
                        <td class="text-start">{{ product.name }}</td>
                        <td>{{ formatNumber(product.weight) }}</td>
                        <td v-if="role === ROLES['PRICE_ADMIN']">{{ product.price }}</td>
                        <td>
                            <TheBadge :is-active="product.isActive" />
                        </td>
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
            <TheButton class="btn-light"></TheButton>
        </template>
    </Modal>
</template>

<script setup>
import { computed, onMounted, reactive } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useAuthStore } from '@/stores/auth.js';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import TheInput from '@/components/form/TheInput.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import TheCheckbox from '@/components/form/TheCheckbox.vue';
import TheButton from '@/components/core/TheButton.vue';
import Alert from '@/components/Alert.vue';
import InputGroup from '@/components/form/InputGroup.vue';
import TheFilter from '@/components/core/TheFilter.vue';
import TheBadge from '@/components/core/TheBadge.vue';
import Modal from '@/components/Modal.vue';
import ThSort from '@/components/table/ThSort.vue';
import TdButton from '@/components/table/TdButton.vue';
import { ADMIN_URLS, CATEGORY_TH_FIELDS, DELETE_TH_FIELD, EDIT_TH_FIELD, ROLES } from '@/helpers/constants.js';
import { formatNumber } from '@/helpers/formatters.js';

const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const authStore = useAuthStore();
const arrayHandlers = useArrayHandlers();
const { get, post, update, destroy } = useHttpService();

const role = authStore.getUser.role;
const isSuperAdmin = computed(() => role === ROLES.SUPER_ADMIN);

const thItems = computed(() => {
    return isSuperAdmin.value
        ? CATEGORY_TH_FIELDS.concat(EDIT_TH_FIELD, DELETE_TH_FIELD)
        : CATEGORY_TH_FIELDS;
});

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
    if ( document.activeElement ) {
        document.activeElement.blur();
    }
}

onMounted(async () => {
    await getCategories();
    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', resetState);
});

const getCategories = async () => {
    const { data } = await get(ADMIN_URLS.CATEGORY, {
        params: {
            'category_is_active': false,
            'product_is_active': true,
            'products': true,
        },
    });
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
        const response = await update(`${ ADMIN_URLS.CATEGORY }/${ state.category.id }`, state.category);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            modalPopUp.hide();
            await getCategories();
        }
    } else {
        const response = await post(ADMIN_URLS.CATEGORY, state.category);
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
        const { status } = await destroy(`${ ADMIN_URLS.CATEGORY }/${ id }`);
        if ( status === 'success' ) {
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
</script>
