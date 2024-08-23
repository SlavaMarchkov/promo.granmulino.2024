<template>
    <div class="row mb-4">
        <div class="col-12">
            <button class="btn btn-primary" type="button" @click="createProductInit">
                Новый продукт
            </button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <Filter @reset-filter="clearSearch">
                <div class="col-md-3 mb-2">
                    <InputGroup
                        v-model="searchBy.name"
                        placeholder="Поиск по названию"
                    >Продукт
                    </InputGroup>
                </div>
                <div class="col-md-3 mb-2">
                    <SelectGroup
                        v-model="searchBy.categoryId"
                        :chooseFrom="'-- Выберите группу --'"
                        :items="state.categories"
                    >Группа
                    </SelectGroup>
                </div>
                <div class="col-md-2 mb-2">
                    <InputGroup
                        v-model="searchBy.weight"
                        placeholder="Поиск по весу"
                    >Вес
                    </InputGroup>
                </div>
                <div class="col-md-2 mb-2">
                    <InputGroup
                        v-model="searchBy.price"
                        placeholder="Поиск по цене"
                    >Цена
                    </InputGroup>
                </div>
                <div class="col-md-2 mb-2">
                    <Checkbox
                        id="is_active"
                        v-model="searchBy.isActive"
                    >
                        В продаже?
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
                                    @initModal="viewProductInit"
                                >View
                                </TdButton>
                                <TdButton
                                    :id="item.id"
                                    intent="edit"
                                    @initModal="editProductInit"
                                >Edit
                                </TdButton>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <p v-else class="mt-3 text-center lead">
                        {{ productStore.isContentLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
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
            <span v-if="state.isEditing">Редактирование продукта <b>{{ state.product.name }}</b></span>
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
                :disabled="productStore.isButtonDisabled"
                :loading="productStore.isButtonDisabled"
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
            <pre>
                {{ state.product }}
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
import Checkbox from '@/components/form/Checkbox.vue';
import SelectGroup from '@/components/form/SelectGroup.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import { computed, onMounted, reactive, watch } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useCategoryStore } from '@/stores/categories.js';
import { useProductStore } from '@/stores/products.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import InputGroup from '@/components/form/InputGroup.vue';
import Filter from '@/components/core/Filter.vue';
import Badge from '@/components/core/Badge.vue';
import Modal from '@/components/Modal.vue';
import ThSort from '@/components/table/ThSort.vue';
import TdButton from '@/components/table/TdButton.vue';

const productStore = useProductStore();
const categoryStore = useCategoryStore();
const alertStore = useAlertStore();
const arrayHandlers = useArrayHandlers();

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

onMounted(async () => {
    await getProducts();
    await getCategories();

    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', () => {
        state.isEditing = false;
        state.product = initialFormData();
    });
});

const getProducts = async () => {
    const { data } = await productStore.all();
    state.products = data.data;
};

const getCategories = async () => {
    const { data } = await categoryStore.all();
    state.categories = data.data;
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

// TODO: make view of the product
const viewProductInit = (id) => {
    viewModalPopUp = new bootstrap.Modal(document.getElementById('viewModalPopUp'));
    state.product = productStore.oneProduct(id);
    viewModalPopUp.show();
    viewModalPopUp._element.addEventListener('hide.bs.modal', () => {
        state.isEditing = false;
        state.product = initialFormData();
    });
};

const closeModal = () => {
    modalPopUp.hide();
};

const closeViewModal = () => {
    viewModalPopUp.hide();
};

watch(searchBy, () => {
    state.products = arrayHandlers.filterArray(productStore.getProducts, searchBy);
});

const clearSearch = () => {
    arrayHandlers.resetSearchKeys(searchBy);
    arrayHandlers.resetSortKeys();
};

const saveProduct = async () => {
    if ( state.isEditing ) {
        const response = await productStore.update(state.product);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            modalPopUp.hide();
            await getProducts();
        }
    } else {
        const response = await productStore.save(state.product);
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

const sortedItems = computed(() => {
    return arrayHandlers.sortArray(state.products);
});

const filteredItems = computed(() => {
    return arrayHandlers.filterArray(sortedItems.value, searchBy);
});
</script>
