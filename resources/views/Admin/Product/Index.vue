<template>
    <div class="row mb-4">
        <div class="col-12">
            <button
                class="btn btn-primary"
                type="button"
                @click="createProductInit"
            >
                Новый продукт
            </button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <Filter @reset-filter="clearSearch">
                <div class="col-md-4 mb-2">
                    <InputGroup
                        v-model="searchBy.name"
                        placeholder="Поиск по названию"
                    >Продукт
                    </InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <SelectGroup
                        v-model="searchBy.categoryId"
                        :chooseFrom="'-- Выберите группу товара --'"
                        :items="state.categories"
                    >Группа товара
                    </SelectGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <Checkbox
                        id="is_active"
                        v-model="searchBy.isActive"
                    >
                        Продукт в продаже?
                    </Checkbox>
                </div>
                <div class="col-md-4 mb-2">
                    <InputGroup
                        v-model="searchBy.weight"
                        placeholder="Фильтр по макс. весу"
                    >Макс. вес
                    </InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <InputGroup
                        v-model="searchBy.price"
                        placeholder="Поиск по цене"
                    >Цена
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
                                        name: 'Product.View',
                                        params: {
                                            'id': item.id
                                        },
                                    }">{{ item.name }}
                                    </RouterLink>
                                </td>
                                <td>
                                    {{ item.weight }}
                                </td>
                                <td>
                                    {{ item.price }}
                                </td>
                                <td class="text-start">
                                    {{ item.category }}
                                </td>
                                <td>
                                    <Badge :is-active="item.isActive"/>
                                </td>
                                <TdButton
                                    :id="item.id"
                                    intent="view"
                                    @runButtonHandler="viewProductInit"
                                >View
                                </TdButton>
                                <TdButton
                                    :id="item.id"
                                    intent="edit"
                                    @runButtonHandler="editProductInit"
                                >Edit
                                </TdButton>
                                <TdButton
                                    :id="item.id"
                                    intent="delete"
                                    @runButtonHandler="deleteProduct"
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
            <span v-if="state.isEditing">Редактирование продукта <br><b>{{ state.product.name }}</b></span>
            <span v-else>Добавление продукта</span>
        </template>
        <template #body>
            <Alert/>
            <div class="row g-3">
                <div class="col-12">
                    <Label for="name" required>Название продукта</Label>
                    <Input
                        id="name"
                        v-model="state.product.name"
                        placeholder="Например: Бантики, 400 г"
                        type="text"
                    />
                </div>
                <div class="col-6">
                    <Label for="weight" required>Вес пачки, г</Label>
                    <Input
                        id="weight"
                        v-model="state.product.weight"
                        max="50000"
                        min="0"
                        placeholder="Например: 400"
                        step="50"
                        type="number"
                    />
                </div>
                <div class="col-6">
                    <Label for="price" required>Отпускная цена, руб.</Label>
                    <Input
                        id="price"
                        v-model="state.product.price"
                        max="299.99"
                        min="0.00"
                        placeholder="Например: 36.99"
                        step="0.01"
                        type="number"
                    />
                </div>
                <div class="col-12">
                    <Label for="category_id" required>Группа товара</Label>
                    <select
                        id="category_id"
                        v-model="state.product.categoryId"
                        class="form-select"
                    >
                        <option disabled selected value="">-- Выберите группу товара --</option>
                        <option
                            v-for="category in state.categories"
                            :key="category.id"
                            :value="category.id"
                        >{{ category.name }}
                        </option>
                    </select>
                </div>
                <div class="col-12">
                    <Label for="image">Изображение продукта</Label>
                    <Input
                        id="image"
                        type="file"
                    />
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input
                            id="is-active"
                            v-model="state.product.isActive"
                            :checked="state.product.isActive"
                            class="form-check-input"
                            type="checkbox"
                        >
                        <label class="form-check-label" for="is-active">
                            Продукт в продаже?
                        </label>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <Button
                :class="state.isEditing ? 'btn-warning' : 'btn-primary'"
                :disabled="spinnerStore.isButtonDisabled"
                :loading="spinnerStore.isButtonDisabled"
                class="w-25"
                type="button"
                @click="saveProduct"
            >
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
            Просмотр продукта <b>{{ state.product.name }}</b>
        </template>
        <template #body>
            <table class="table table-bordered mt-3 align-middle text-wrap"
                   style="width: 100%;">
                <tbody>
                <tr>
                    <th style="width: 40%;">ID</th>
                    <td>{{ state.product.id }}</td>
                </tr>
                <tr>
                    <th>Название</th>
                    <td>{{ state.product.name }}</td>
                </tr>
                <tr>
                    <th>Вес, г</th>
                    <td>{{ state.product.weight }}</td>
                </tr>
                <tr>
                    <th>Себестоимость, руб.</th>
                    <td>{{ state.product.price }}</td>
                </tr>
                <tr>
                    <th>Группа товаров</th>
                    <td>{{ state.product.category }}</td>
                </tr>
                <tr>
                    <th>В продаже?</th>
                    <td><Badge :is-active="state.product.isActive" /></td>
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
import Label from '@/components/form/Label.vue';
import Checkbox from '@/components/form/Checkbox.vue';
import SelectGroup from '@/components/form/SelectGroup.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import { computed, onMounted, reactive, watch } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useProductStore } from '@/stores/products.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import { useHttpService } from '@/use/useHttpService.js';
import InputGroup from '@/components/form/InputGroup.vue';
import Filter from '@/components/core/Filter.vue';
import Badge from '@/components/core/Badge.vue';
import Modal from '@/components/Modal.vue';
import ThSort from '@/components/table/ThSort.vue';
import TdButton from '@/components/table/TdButton.vue';

const { get, post, update, destroy } = useHttpService();

const productStore = useProductStore();
const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();

const productURL = '/admin/products';
const categoryURL = '/admin/categories';

const initialFormData = () => ({
    name: '',
    weight: '',
    price: '',
    categoryId: '',
    isActive: true,
});

const state = reactive({
    products: [],
    categories: [],
    product: initialFormData(),
    isEditing: false,
});

const thFields = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Название', sortable: true, is_num: false },
    { column: 'weight', label: 'Вес, г', sortable: true, is_num: true },
    { column: 'price', label: 'Себестоимость, руб.', sortable: true, is_num: true },
    { column: 'category', label: 'Группа товаров', sortable: true, is_num: false },
    { column: 'isActive', label: 'В продаже?', sortable: true, is_num: true, width: 15 },
    { column: 'view', label: 'Просмотр', width: 10 },
    { column: 'edit', label: 'Ред.', width: 10 },
    { column: 'delete', label: 'Удалить', width: 10 },
];

const searchBy = reactive({
    name: '',
    weight: '',
    price: '',
    categoryId: '',
    isActive: false,
});

let modalPopUp = null;
let viewModalPopUp = null;

function resetState() {
    state.isEditing = false;
    state.product = initialFormData();
}

onMounted(async () => {
    await getProducts();
    await getCategories();
    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', resetState);
});

const getProducts = async () => {
    const { data } = await get(productURL);
    productStore.setProducts(data.products);
    state.products = productStore.getProducts;
};

const getCategories = async () => {
    const { data } = await get(categoryURL);
    state.categories = data.categories;
};

const createProductInit = () => {
    alertStore.clear();
    state.isEditing = false;
    state.product = initialFormData();
    modalPopUp.show();
};

const editProductInit = (id) => {
    alertStore.clear();
    state.isEditing = true;
    state.product = productStore.oneProduct(id);
    modalPopUp.show();
};

const viewProductInit = (id) => {
    viewModalPopUp = new bootstrap.Modal(document.getElementById('viewModalPopUp'));
    state.product = productStore.oneProduct(id);
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

// TODO - сделать фильтр по весу (вес в виде массива с весами продукции)
watch(searchBy, () => {
    state.products = arrayHandlers.filterArray(productStore.getProducts, searchBy);
});

const clearSearch = () => {
    arrayHandlers.resetSearchKeys(searchBy);
    arrayHandlers.resetSortKeys();
};

const saveProduct = async () => {
    if ( state.isEditing ) {
        const response = await update(`${ productURL }/${ state.product.id }`, state.product);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            modalPopUp.hide();
            await getProducts();
        }
    } else {
        const response = await post(productURL, state.product);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            state.product = initialFormData();
            modalPopUp.hide();
            arrayHandlers.resetSearchKeys(searchBy);
            arrayHandlers.resetSortKeys('id', false);
            await getProducts();
        }
    }
};

const deleteProduct = async (id) => {
    if ( confirm('Точно удалить продукт? Уверены?') ) {
        const response = await destroy(`${ productURL }/${ id }`);
        if ( response && response.status === 'success' ) {
            await getProducts();
        }
    }
};

const sortedItems = computed(() => {
    return arrayHandlers.sortArray(state.products);
});

const filteredItems = computed(() => {
    return arrayHandlers.filterArray(sortedItems.value, searchBy);
});
</script>
