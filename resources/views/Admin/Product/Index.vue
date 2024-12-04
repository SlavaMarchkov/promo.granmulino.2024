<template>
    <div class="row mb-4">
        <div class="col-12">
            <button
                class="btn btn-primary"
                type="button"
                @click="createProductInit"
                :disabled="!isSuperAdmin"
            >
                Новый продукт
            </button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <TheFilter
                @reset-filter="clearSearch"
            >
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
                    <TheCheckbox
                        id="is_active"
                        v-model="searchBy.isActive"
                    >
                        Продукт в продаже?
                    </TheCheckbox>
                </div>
                <div class="col-md-4 mb-2">
                    <InputGroup
                        v-model="searchBy.weight"
                        placeholder="Фильтр по макс. весу"
                    >Макс. вес
                    </InputGroup>
                </div>
                <div v-if="isPriceAdmin" class="col-md-4 mb-2">
                    <InputGroup
                        v-model="searchBy.price"
                        placeholder="Поиск по цене"
                    >Цена
                    </InputGroup>
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
                                    <RouterLink :to="{
                                        name: 'Product.View',
                                        params: {
                                            'id': item.id
                                        }
                                    }">{{ item.name }}
                                    </RouterLink>
                                </td>
                                <td>
                                    {{ formatNumber(item.weight) }}
                                </td>
                                <td class="text-start">
                                    {{ item.category }}
                                </td>
                                <td>
                                    <TheBadge :is-active="item.isActive"/>
                                </td>
                                <TdButton
                                    :id="item.id"
                                    intent="view"
                                    @runButtonHandler="viewProductInit"
                                >View
                                </TdButton>
                                <template
                                    v-if="isPriceAdmin"
                                >
                                    <td>
                                        {{ item.price }}
                                    </td>
                                    <TdButton
                                        :id="item.id"
                                        intent="edit"
                                        @runButtonHandler="editProductInit"
                                    >Edit
                                    </TdButton>
                                </template>
                                <template
                                    v-if="isSuperAdmin"
                                >
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
            <span v-if="state.isEditing">Редактирование продукта <br><b>{{ state.product.name }}</b></span>
            <span v-else>Добавление продукта</span>
        </template>
        <template #body>
            <Alert/>
            <div class="row g-3">
                <div class="col-12">
                    <TheLabel for="name" required>Название продукта</TheLabel>
                    <TheInput
                        id="name"
                        v-model="state.product.name"
                        placeholder="Например: Бантики, 400 г"
                        type="text"
                    />
                </div>
                <div class="col-6">
                    <TheLabel for="weight" required>Вес пачки, г</TheLabel>
                    <TheInput
                        id="weight"
                        v-model="state.product.weight"
                        max="50000"
                        min="0"
                        placeholder="Например: 400"
                        step="50"
                        type="number"
                    />
                </div>
                <div v-if="isPriceAdmin" class="col-6">
                    <TheLabel for="price" required>Отпускная цена, руб.</TheLabel>
                    <TheInput
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
                    <TheLabel for="category_id" required>Группа товара</TheLabel>
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
                <div class="col-12">
                    <TheLabel for="image">Изображение продукта</TheLabel>
                    <TheInput
                        id="image"
                        type="file"
                        @change="handleFileChange"
                    />
                    <img :src="getImage()" alt="" class="img-thumbnail mt-3" width="150" />
                </div>
            </div>
        </template>
        <template #footer>
            <TheButton
                :class="state.isEditing ? 'btn-warning' : 'btn-primary'"
                :disabled="spinnerStore.isButtonDisabled"
                :loading="spinnerStore.isButtonDisabled"
                class="w-25"
                type="button"
                @click="saveProduct"
            >
                <span v-if="state.isEditing">Сохранить</span>
                <span v-else>Создать</span>
            </TheButton>
        </template>
    </Modal>

    <Modal
        id="viewModalPopUp"
        :close-func="closeViewModal"
        :custom-classes="['modal-dialog-scrollable']"
    >
        <template #title>
            Просмотр продукта <b>{{ state.product.name }}</b>
        </template>
        <template #body>
            <table class="table table-bordered mt-3 align-top text-wrap"
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
                    <td>{{ formatNumber(state.product.weight) }}</td>
                </tr>
                <tr v-if="isPriceAdmin">
                    <th>Себестоимость, руб.</th>
                    <td>{{ state.product.price }}</td>
                </tr>
                <tr>
                    <th>Группа товаров</th>
                    <td>{{ state.product.category }}</td>
                </tr>
                <tr>
                    <th>В продаже?</th>
                    <td><TheBadge :is-active="state.product.isActive" /></td>
                </tr>
                <tr>
                    <th>Картинка</th>
                    <td>
                        <img
                            :src="productImage"
                            :alt="state.product.name"
                            class="img-thumbnail"
                        />
                    </td>
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
import { computed, onMounted, reactive } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useAuthStore } from '@/stores/auth.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import { useHttpService } from '@/use/useHttpService.js';
import TheInput from '@/components/form/TheInput.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import TheCheckbox from '@/components/form/TheCheckbox.vue';
import SelectGroup from '@/components/form/SelectGroup.vue';
import TheButton from '@/components/core/TheButton.vue';
import Alert from '@/components/Alert.vue';
import InputGroup from '@/components/form/InputGroup.vue';
import TheFilter from '@/components/core/TheFilter.vue';
import TheBadge from '@/components/core/TheBadge.vue';
import Modal from '@/components/Modal.vue';
import ThSort from '@/components/table/ThSort.vue';
import TdButton from '@/components/table/TdButton.vue';
import {
    ADMIN_URLS,
    DELETE_TH_FIELD,
    EDIT_TH_FIELD,
    NO_PRODUCT_IMG,
    PRICE_TH_FIELD,
    PRODUCT_IMG_PATH,
    PRODUCT_TH_FIELDS,
    ROLES,
} from '@/helpers/constants.js';
import { formatNumber } from '@/helpers/formatters.js';

const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const authStore = useAuthStore();
const arrayHandlers = useArrayHandlers();
const { get, post, update, destroy } = useHttpService();

const role = authStore.getUser.role;
const isSuperAdmin = computed(() => role === ROLES.SUPER_ADMIN);
const isPriceAdmin = computed(() => role === ROLES.PRICE_ADMIN);

const thItems = computed(() => {
    return isSuperAdmin
        ? PRODUCT_TH_FIELDS.concat(EDIT_TH_FIELD, DELETE_TH_FIELD)
        : isPriceAdmin
            ? PRODUCT_TH_FIELDS.concat(PRICE_TH_FIELD, EDIT_TH_FIELD)
            : PRODUCT_TH_FIELDS;
});

const initialFormData = () => ({
    name: '',
    weight: '',
    price: '',
    categoryId: '',
    image: '',
    isActive: true,
});

const state = reactive({
    products: [],
    categories: [],
    product: initialFormData(),
    isEditing: false,
});

// TODO - сделать фильтр по весу (вес в виде массива с весами продукции)
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
    const { data } = await get(ADMIN_URLS.PRODUCT, {
        params: {
            'is_active': false,
        },
    });
    state.products = data.products;
};

const getOneProduct = (id) => state.products.find(product => product.id === id);

const getCategories = async () => {
    const { data } = await get(ADMIN_URLS.CATEGORY, {
        params: {
            'is_active': true,
        },
    });
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
    state.product = getOneProduct(id);
    modalPopUp.show();
};

const viewProductInit = (id) => {
    viewModalPopUp = new bootstrap.Modal(document.getElementById('viewModalPopUp'));
    state.product = getOneProduct(id);
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

const getImage = () => {
    let image = `${PRODUCT_IMG_PATH}${NO_PRODUCT_IMG}`;

    if (state.product.image) {
        if (state.product.image.indexOf('base64') !== -1) {
            image = state.product.image;
        } else {
            image = PRODUCT_IMG_PATH + state.product.image;
        }
    }

    return image;
};

const productImage = computed(() => {
    return state.product.image
        ? `${PRODUCT_IMG_PATH}${state.product.image}`
        : `${PRODUCT_IMG_PATH}${NO_PRODUCT_IMG}`
});

// TODO: figure out FileReader
const handleFileChange = (evt) => {
    const file = evt.target.files[0];
    const reader = new FileReader();
    reader.onloadend = (file) => {
        state.product.image = reader.result;
    };
    reader.readAsDataURL(file);
};

const saveProduct = () => {
    state.isEditing ? updateProduct() : createProduct();
};

const createProduct = async () => {
    const response = await post(ADMIN_URLS.PRODUCT, state.product);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        state.product = initialFormData();
        modalPopUp.hide();
        arrayHandlers.resetSearchKeys(searchBy);
        arrayHandlers.resetSortKeys('id', false);
        await getProducts();
    }
};

const updateProduct = async () => {
    const response = await update(`${ ADMIN_URLS.PRODUCT }/${ state.product.id }`, state.product);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        state.product = initialFormData();
        modalPopUp.hide();
        await getProducts();
    }
};

const deleteProduct = async (id) => {
    if ( confirm('Точно удалить продукт? Уверены?') ) {
        const { status } = await destroy(`${ ADMIN_URLS.PRODUCT }/${ id }`);
        if ( status === 'success' ) {
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
