<template>
    <div class="row mb-4">
        <div class="col-12">
            <button class="btn btn-primary me-2" type="button" @click="showNewProductModal">
                Новый продукт
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
                                <td class="py-1" style="width: 20%;">
                                    <div class="input-group">
                                        <input
                                            v-model="searchBy.name"
                                            class="form-control"
                                            placeholder="Поиск по названию"
                                            type="text"
                                        />
                                        <span class="input-group-text" style="cursor: pointer;"
                                              @click="searchBy.name = ''"><i
                                            class="bi bi-x-lg"></i></span>
                                    </div>
                                </td>
                                <td class="py-1" style="width: 15%;">
                                    <div class="input-group">
                                        <input
                                            v-model="searchBy.price"
                                            class="form-control"
                                            placeholder="Поиск по цене"
                                            type="text"
                                        />
                                        <span class="input-group-text" style="cursor: pointer;"
                                              @click="searchBy.price = ''"><i
                                            class="bi bi-x-lg"></i></span>
                                    </div>
                                </td>
                                <td class="py-1" style="width: 20%;">
                                    <div class="input-group">
                                        <select v-model="searchBy.categoryId" class="form-select">
                                            <option disabled selected value="">Фильтр по группе</option>
                                            <option
                                                v-for="category in categories"
                                                :key="category.id"
                                                :value="category.id"
                                            >{{ category.name }}
                                            </option>
                                        </select>
                                        <span class="input-group-text" style="cursor: pointer;"
                                              @click="searchBy.categoryId = ''"><i
                                            class="bi bi-x-lg"></i></span>
                                    </div>
                                </td>
                                <td class="py-1" style="width: 20%;">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <input
                                                id="is_active"
                                                v-model="searchBy.isActive"
                                                class="form-check-input mt-0"
                                                type="checkbox"
                                            >
                                        </div>
                                        <label class="form-control text-start" for="is_active">Только в продаже</label>
                                    </div>
                                </td>
                                <td class="py-1" style="width: 10%;"></td>
                                <td class="py-1" style="width: 10%;"></td>
                            </tr>
                            </tbody>
                        </table>
                        <table v-if="products.length > 0" class="table table-bordered mb-4 text-center align-middle"
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
                                    :width='20'
                                    class="text-start"
                                    sort-type="alpha"
                                    @sortByColumn="applyFilterSort(
                                        'name',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                        false,
                                    )"
                                >Название продукта
                                </ThSort>
                                <ThSort
                                    :id="'price'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='15'
                                    sort-type="numeric"
                                    @sortByColumn="applyFilterSort(
                                        'price',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                    )"
                                >Отпускная цена
                                </ThSort>
                                <ThSort
                                    :id="'category'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='20'
                                    class="text-start"
                                    sort-type="alpha"
                                    @sortByColumn="applyFilterSort(
                                        'category',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                        false,
                                    )"
                                >Группа товаров
                                </ThSort>
                                <ThSort
                                    :id="'isActive'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='20'
                                    @sortByColumn="applyFilterSort(
                                        'isActive',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                    )"
                                >В продаже?
                                </ThSort>
                                <th scope="col" style="width: 10%;">Просмотр</th>
                                <th scope="col" style="width: 10%;">Ред.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="product in products" :key="product.id">
                                <th scope="row">{{ product.id }}</th>
                                <td class="text-start" style="cursor: pointer;"
                                    @click="showViewProductModal(product.id)">
                                    {{ product.name }}
                                </td>
                                <td>
                                    {{ product.price }}
                                </td>
                                <td class="text-start">
                                    {{ product.category }}
                                </td>
                                <td>
                                    <Badge :is-active="product.isActive"/>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-primary"
                                        @click="showViewProductModal(product.id)"
                                    ><i class="bi bi-eye-fill"></i>
                                        View
                                    </button>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-warning"
                                        @click="showEditProductModal(product.id)"
                                    ><i class="bi bi-pencil-square"></i>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p v-else class="mt-3 text-center lead">
                            {{ productStore.isContentLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
                        </p>
                    </div>
                    <p>Всего записей: <span class="fw-bold">{{ products.length }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- New Product Modal Start -->
    <div id="newProduct" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">
            <form @submit.prevent="saveProduct">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Добавление продукта</h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <Alert/>
                        <div class="row g-3">
                            <div class="col-12">
                                <Label for="name" required>Название продукта</Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    placeholder="Например: Бантики, 400 г"
                                    type="text"
                                />
                            </div>
                            <div class="col-12">
                                <Label for="price" required>Отпускная цена, руб.</Label>
                                <Input
                                    id="price"
                                    v-model="form.price"
                                    max="299.99"
                                    min="0.00"
                                    placeholder="Например: 36.99"
                                    step="0.01"
                                    type="number"
                                />
                            </div>
                            <div class="col-12">
                                <Label for="category_id" required>Группа товара</Label>
                                <select id="category_id" v-model="form.categoryId" class="form-select">
                                    <option disabled selected value="">-- Выберите группу товара --</option>
                                    <option
                                        v-for="category in categories"
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <Button
                            :disabled="productStore.isButtonDisabled"
                            :loading="productStore.isButtonDisabled"
                            class="w-25"
                            type="submit"
                        >Сохранить
                        </Button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- New Product Modal End -->

    <!-- Edit One Product Modal Start -->
    <div id="editProduct" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">
            <form @submit.prevent="updateProduct(product)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактирование продукта</h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <Alert/>
                        <div class="row g-3">
                            <div class="col-12">
                                <Label for="edit-name" required>Название продукта</Label>
                                <Input
                                    id="edit-name"
                                    v-model="product.name"
                                    placeholder="Например: Бантики, 400 г"
                                    type="text"
                                />
                            </div>
                            <div class="col-12">
                                <Label for="edit-price" required>Отпускная цена, руб.</Label>
                                <Input
                                    id="edit-price"
                                    v-model="product.price"
                                    max="299.99"
                                    min="0"
                                    placeholder="Например: 36.99"
                                    step="0.01"
                                    type="number"
                                />
                            </div>
                            <div class="col-12">
                                <Label for="edit-category_id" required>Группа товара</Label>
                                <select id="edit-category_id" v-model="product.categoryId" class="form-select">
                                    <option disabled selected value="">-- Выберите группу товара --</option>
                                    <option
                                        v-for="category in categories"
                                        :value="category.id"
                                    >{{ category.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input
                                        id="edit-isActive"
                                        v-model="product.isActive"
                                        :checked="product.isActive"
                                        class="form-check-input"
                                        type="checkbox"
                                    >
                                    <label class="form-check-label" for="edit-isActive">
                                        Продукт в продаже?
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <Label for="edit-image">Новое изображение продукта</Label>
                                <Input
                                    id="edit-image"
                                    type="file"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <Button
                            :disabled="productStore.isButtonDisabled"
                            :loading="productStore.isButtonDisabled"
                            class="w-25"
                            type="submit"
                        >Сохранить
                        </Button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Edit One Product Modal End -->

    <!-- View One Product Modal Start -->
    <div id="viewProduct" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Просмотр продукта</h5>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <pre>
                        {{ product }}
                    </pre>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <!-- View One Product Modal End -->
</template>

<script setup>
import Input from '@/components/core/Input.vue';
import Label from '@/components/core/Label.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import { onMounted, reactive, ref, watch } from 'vue';
import { useProductStore } from '@/stores/products.js';
import { useCategoryStore } from '@/stores/categories.js';
import { useAlertStore } from '@/stores/alerts.js';
import ThSort from '@/components/core/ThSort.vue';
import Badge from '@/components/core/Badge.vue';
import { arrFilter, arrSort } from '@/helpers/arrHandlers.js';
import { resetSearchKeys } from '@/helpers/searchHandlers.js';

const productStore = useProductStore();
const categoryStore = useCategoryStore();
const alertStore = useAlertStore();

const initialFormData = () => ({
    name: '',
    price: '',
    categoryId: '',
});

let form = reactive(initialFormData());

const products = ref([]);
const product = ref({});
const categories = ref([]);

const searchBy = reactive({
    name: '',
    categoryId: '',
    isActive: false,
});

let orderColumn = 'id';
let orderDirection = 'asc';

let newProductModal = null;
let editProductModal = null;
let viewProductModal = null;

onMounted(async () => {
    await getProducts();
    await getCategories();
});

const getProducts = async () => {
    await productStore.all();
    applyFilterSort();
};

const getProduct = (id) => {
    product.value = productStore.getProducts
        .find(item => item.id === id);
};

const getCategories = async () => {
    const response = await categoryStore.all();
    categories.value = response.data;
};

const showNewProductModal = () => {
    alertStore.clear();
    form = initialFormData();
    newProductModal = new bootstrap.Modal(document.getElementById('newProduct'));
    newProductModal.show();
};

const showEditProductModal = (id) => {
    alertStore.clear();
    editProductModal = new bootstrap.Modal(document.getElementById('editProduct'));
    editProductModal.show();
    getProduct(id);
};

// TODO: make view
const showViewProductModal = (id) => {
    viewProductModal = new bootstrap.Modal(document.getElementById('viewProduct'));
    viewProductModal.show();
    getProduct(id);
};

// TODO: upload images
const saveProduct = async () => {
    const response = await productStore.save(form);
    if ( response && response.status === 'success' ) {
        form = initialFormData();
        alertStore.clear();
        newProductModal.hide();
        resetSearchKeys(searchBy);
        orderColumn = 'id';
        orderDirection = 'desc';
        await getProducts();
    }
};

const updateProduct = async (product) => {
    const response = await productStore.update(product);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        editProductModal.hide();
        await getProducts();
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

    let tempArr = productStore.getProducts.slice();

    tempArr = arrSort(tempArr, sort_by_numeric, direction, column);
    tempArr = arrFilter(tempArr, searchBy);

    products.value = tempArr;
};
</script>
