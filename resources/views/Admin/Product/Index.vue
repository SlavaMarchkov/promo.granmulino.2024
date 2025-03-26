<template>
    <div class="row mb-4">
        <div class="col-6">
            <h3 class="mb-1">{{ $route.meta.title }}</h3>
        </div>
        <div v-show="isSuperAdmin" class="col-6 text-end">
            <TheButton
                class="btn-primary"
                @click="createProductInit"
            >Новый продукт
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
                        placeholder="Поиск по названию"
                    >Продукт
                    </InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <SelectGroup
                        v-model="searchBy.categoryId"
                        :chooseFrom="'-- Выберите группу товаров --'"
                        :items="state.categories"
                    >Группа товаров
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
                    <DropDown
                        :items="weights"
                        @filter="handleCheckboxFilter"
                    >Вес в граммах</DropDown>
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
                                    <RouterLink
                                        :to="{ name: 'Category.View', params: { id: item.categoryId } }"
                                    >
                                        {{ item.categoryName }}
                                    </RouterLink>
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
        :custom-classes="['modal-lg']"
    >
        <template #title>
            <span v-if="state.isEditing">Редактирование продукта <br><b>{{ state.product.name }}</b></span>
            <span v-else>Добавление продукта</span>
        </template>
        <template #body>
            <Alert/>
            <h5 class="text-center mb-2 fw-bold text-accent">Единица товара</h5>
            <div class="row mb-3 g-3">
                <div class="col-6">
                    <TheLabel for="name" required>Название продукта</TheLabel>
                    <TheInput
                        id="name"
                        v-model="state.product.name"
                        placeholder="Например: Бантики, 400 г"
                        type="text"
                    />
                </div>
                <div class="col-6">
                    <TheLabel for="category_id" required>Группа товаров</TheLabel>
                    <select
                        id="category_id"
                        v-model="state.product.categoryId"
                        class="form-select"
                    >
                        <option disabled selected value="">-- Выберите группу товаров --</option>
                        <option
                            v-for="category in state.categories"
                            :key="category.id"
                            :value="category.id"
                        >{{ category.name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="row mb-3 g-3">
                <div class="col-4">
                    <TheLabel for="code">Код продукта из 1С</TheLabel>
                    <TheInput
                        id="code"
                        v-model="state.product.code"
                        type="text"
                    />
                </div>
                <div class="col-4">
                    <TheLabel for="barcode_box">Штрих-код короба</TheLabel>
                    <TheInput
                        id="barcode_box"
                        v-model="state.product.barcodeBox"
                        type="text"
                        maxlength="14"
                    />
                </div>
                <div class="col-4">
                    <TheLabel for="barcode">Штрих-код пачки</TheLabel>
                    <TheInput
                        id="barcode"
                        v-model="state.product.barcode"
                        type="text"
                        maxlength="13"
                    />
                </div>
            </div>
            <div class="row mb-3 g-3">
                <div class="col-4">
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
                <div class="col-4">
                    <TheLabel for="gross_weight">Вес брутто, кг (±4г)</TheLabel>
                    <TheInput
                        id="gross_weight"
                        v-model="state.product.grossWeight"
                        max="50.999"
                        min="0.200"
                        placeholder="Например: 0.406"
                        step="0.001"
                        type="number"
                    />
                </div>
                <div v-if="isPriceAdmin" class="col-4">
                    <TheLabel for="price" required>Себестоимость, руб.</TheLabel>
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
                <div v-else class="col-4">
                    <TheLabel for="price" required>Себестоимость, руб.</TheLabel>
                    <TheInput
                        id="price"
                        disabled="disabled"
                        placeholder="Заполняется прайс-админом"
                    />
                </div>
            </div>
            <div class="row mb-3 g-3">
                <div class="col-3">
                    <TheLabel for="width">Ширина, см</TheLabel>
                    <TheInput
                        id="width"
                        v-model="state.product.width"
                        max="50"
                        min="1"
                        placeholder="Например: 14.5"
                        type="number"
                    />
                </div>
                <div class="col-3">
                    <TheLabel for="depth">Глубина, см</TheLabel>
                    <TheInput
                        id="depth"
                        v-model="state.product.depth"
                        max="50"
                        min="1"
                        placeholder="Например: 4.4"
                        type="number"
                    />
                </div>
                <div class="col-3">
                    <TheLabel for="height">Высота, см</TheLabel>
                    <TheInput
                        id="height"
                        v-model="state.product.height"
                        max="50"
                        min="1"
                        placeholder="Например: 18.5"
                        type="number"
                    />
                </div>
                <div class="col-3">
                    <TheLabel for="pack_size">Объем, см<sup>3</sup></TheLabel>
                    <TheInput
                        id="pack_size"
                        :model-value="formatNumberWithFractions(packSize)"
                        disabled="disabled"
                    />
                </div>
            </div>
            <h5 class="text-center mt-4 mb-2 fw-bold text-accent">Упаковка</h5>
            <div class="row mb-3 g-3">
                <div class="col-3">
                    <TheLabel for="width_box">Ширина, см</TheLabel>
                    <TheInput
                        id="width_box"
                        v-model="state.product.widthBox"
                        max="99"
                        min="1"
                        step="0.5"
                        placeholder="Например: 58"
                        type="number"
                    />
                </div>
                <div class="col-3">
                    <TheLabel for="depth_box">Глубина, см</TheLabel>
                    <TheInput
                        id="depth_box"
                        v-model="state.product.depthBox"
                        max="99"
                        min="1"
                        step="0.5"
                        placeholder="Например: 28.5"
                        type="number"
                    />
                </div>
                <div class="col-3">
                    <TheLabel for="height_box">Высота, см</TheLabel>
                    <TheInput
                        id="height_box"
                        v-model="state.product.heightBox"
                        max="99"
                        min="1"
                        step="0.5"
                        placeholder="Например: 22"
                        type="number"
                    />
                </div>
                <div class="col-3">
                    <TheLabel for="capacity">Кол-во единиц, шт</TheLabel>
                    <TheInput
                        id="capacity"
                        v-model="state.product.capacity"
                        max="99"
                        min="1"
                        step="1"
                        placeholder="Например: 20"
                        type="number"
                    />
                </div>
            </div>
            <div class="row mb-3 g-3">
                <div class="col-6">
                    <TheLabel for="box_weight">Вес гофрокороба нетто, кг</TheLabel>
                    <TheInput
                        id="box_weight"
                        :model-value="boxWeight"
                        disabled="disabled"
                    />
                </div>
                <div class="col-6">
                    <TheLabel for="box_in_layer">Кол-во коробов в одном слое, шт.</TheLabel>
                    <TheInput
                        id="box_in_layer"
                        v-model="state.product.boxesInLayer"
                        max="50"
                        min="1"
                        step="1"
                        placeholder="Например: 8"
                        type="number"
                    />
                </div>
            </div>
            <hr>
            <div class="row mb-3 g-3">
                <div class="col-6">
                    <TheLabel for="image">Изображение продукта</TheLabel>
                    <TheInput
                        id="image"
                        type="file"
                        @change="handleFileChange"
                        accept="image/*"
                    />
                </div>
                <div class="col-6">
                    <TheLabel>Продукт в продаже?</TheLabel>
                    <div class="form-check">
                        <input
                            id="is-active"
                            v-model="state.product.isActive"
                            :checked="state.product.isActive"
                            class="form-check-input"
                            type="checkbox"
                        >
                        <label class="form-check-label" for="is-active">
                            {{ state.product.isActive ? 'Да' : 'Нет' }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <img
                        ref="uploadedProductImageRef"
                        :src="productImage"
                        alt="Изображение продукта"
                        class="img-thumbnail"
                        width="150"
                    />
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
        :custom-classes="['modal-dialog-scrollable', 'modal-lg']"
    >
        <template #title>
            Просмотр продукта <b>{{ state.product.name }}</b>
        </template>
        <template #body>
            <table class="table table-bordered mt-3 align-middle text-wrap"
                   style="width: 100%;">
                <tbody>
                <tr>
                    <th style="width: 25%;">ID</th>
                    <td>{{ state.product.id }}</td>
                </tr>
                <tr>
                    <th>Название</th>
                    <td>{{ state.product.name }}</td>
                </tr>
                <tr v-if="isPriceAdmin">
                    <th>Себестоимость, руб.</th>
                    <td>{{ state.product.price }}</td>
                </tr>
                <tr>
                    <th>Группа товаров</th>
                    <td>{{ state.product.categoryName }}</td>
                </tr>
                <tr>
                    <th>Размеры упаковки</th>
                    <td class="p-0">
                        <table class="table text-center align-middle table-borderless m-0">
                            <thead>
                            <tr class="border-bottom">
                                <th class="border-end">Ширина, см</th>
                                <th class="border-end">Глубина, см</th>
                                <th class="border-end">Высота, см</th>
                                <th>Объём, см<sup>3</sup></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="border-end">{{ formatNumberWithFractions(state.product.width) }}</td>
                                <td class="border-end">{{ formatNumberWithFractions(state.product.depth) }}</td>
                                <td class="border-end">{{ formatNumberWithFractions(state.product.height) }}</td>
                                <td>{{ formatNumberWithFractions(state.product.packSize) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Размеры гофрокороба</th>
                    <td class="p-0">
                        <table class="table text-center align-middle table-borderless m-0">
                            <thead>
                            <tr class="border-bottom">
                                <th class="border-end">Ширина, см</th>
                                <th class="border-end">Глубина, см</th>
                                <th class="border-end">Высота, см</th>
                                <th>Объём, см<sup>3</sup></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="border-end">{{ formatNumberWithFractions(state.product.widthBox) }}</td>
                                <td class="border-end">{{ formatNumberWithFractions(state.product.depthBox) }}</td>
                                <td class="border-end">{{ formatNumberWithFractions(state.product.heightBox) }}</td>
                                <td>{{ formatNumberWithFractions(state.product.boxSize) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>В продаже?</th>
                    <td><TheBadge :is-active="state.product.isActive" /></td>
                </tr>
                <tr>
                    <th>Вес пачки</th>
                    <td class="p-0">
                        <table class="table text-center align-middle table-borderless m-0">
                            <thead>
                            <tr class="border-bottom">
                                <th class="border-end" style="width: 33.3333%;">Вес, г</th>
                                <th class="border-end" style="width: 33.3333%;">Вес нетто, кг</th>
                                <th style="width: 33.3333%;">Вес брутто, кг</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="border-end">{{ formatNumber(state.product.weight) }}</td>
                                <td class="border-end">{{ formatNumberWithFractions(state.product.weight / 1_000) }}</td>
                                <td>{{ state.product.grossWeight }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Коды</th>
                    <td class="p-0">
                        <table class="table text-center align-middle table-borderless m-0">
                            <thead>
                            <tr class="border-bottom">
                                <th class="border-end" style="width: 33.3333%;">Код продукта из 1С</th>
                                <th class="border-end" style="width: 33.3333%;">Штрих-код короба</th>
                                <th style="width: 33.3333%;">Штрих-код пачки</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="border-end">{{ state.product.code }}</td>
                                <td class="border-end">{{ state.product.barcodeBox }}</td>
                                <td>{{ state.product.barcode }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Гофрокороб</th>
                    <td class="p-0">
                        <table class="table text-center align-middle table-borderless m-0">
                            <thead>
                            <tr class="border-bottom">
                                <th class="border-end" style="width: 33.3333%;">Кол-во единиц<br>в г/к, шт.</th>
                                <th class="border-end" style="width: 33.3333%;">Вес г/к нетто,<br>кг</th>
                                <th style="width: 33.3333%;">Кол-во г/к<br>в одном слое, шт.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="border-end">{{ state.product.capacity }}</td>
                                <td class="border-end">{{ state.product.boxWeight }}</td>
                                <td>{{ state.product.boxesInLayer }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Картинка</th>
                    <td>
                        <img
                            :src="productImage"
                            :alt="state.product.name"
                            class="img-thumbnail"
                            width="100"
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
import { computed, onMounted, reactive, ref } from 'vue';
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
    ALLOWED_FILE_TYPES,
    DELETE_TH_FIELD,
    EDIT_TH_FIELD,
    IMAGES,
    PRICE_TH_FIELD,
    PRODUCT_TH_FIELDS,
    ROLES,
} from '@/helpers/constants.js';
import { formatNumber, formatNumberWithFractions } from '@/helpers/formatters.js';
import DropDown from '@/components/form/DropDown.vue';

const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const authStore = useAuthStore();
const arrayHandlers = useArrayHandlers();
const { get, post, update, destroy } = useHttpService();

const role = authStore.getUser.role;

const isSuperAdmin = computed(() => role === ROLES.SUPER_ADMIN);
const isPriceAdmin = computed(() => role === ROLES.PRICE_ADMIN);

const thItems = computed(() => {
    return isSuperAdmin.value
        ? PRODUCT_TH_FIELDS.concat(EDIT_TH_FIELD, DELETE_TH_FIELD)
        : isPriceAdmin.value
            ? PRODUCT_TH_FIELDS.concat(PRICE_TH_FIELD, EDIT_TH_FIELD)
            : PRODUCT_TH_FIELDS;
});

const initialFormData = () => ({
    name: '',
    code: '',
    weight: '',
    price: '',
    categoryId: '',
    categoryName: '',
    isActive: true,
    grossWeight: '',
    barcode: '',
    barcodeBox: '',
    width: '',
    depth: '',
    height: '',
    widthBox: '',
    depthBox: '',
    heightBox: '',
    capacity: '',
    boxesInLayer: '',
});

const state = reactive({
    products: [],
    categories: [],
    product: initialFormData(),
    isEditing: false,
});

const uploadedProductImageRef = ref(null);

const searchBy = reactive({
    name: '',
    price: '',
    weight: [],
    categoryId: '',
    isActive: false,
});

let modalPopUp = null;
let viewModalPopUp = null;

function resetState() {
    state.isEditing = false;
    state.product = initialFormData();
    if ( document.activeElement ) {
        document.activeElement.blur();
    }
}

onMounted(async () => {
    await getProducts();
    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', resetState);
});

const getProducts = async () => {
    const { data } = await get(ADMIN_URLS.PRODUCT);
    state.products = data.products;
    state.categories = arrayHandlers.getUniqueObjectsFromArray(state.products.map(product => {
        return {
            id: product.categoryId,
            name: product.categoryName,
        };
    }));
};

const getOneProduct = (id) => state.products.find(product => product.id === id);

const createProductInit = () => {
    alertStore.clear();
    state.isEditing = false;
    state.product = initialFormData();
    modalPopUp.show();
    document.getElementById('image').value = null;
};

const editProductInit = (id) => {
    alertStore.clear();
    state.isEditing = true;
    state.product = getOneProduct(id);
    modalPopUp.show();
    document.getElementById('image').value = null;
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

const productImage = computed(() => state.product.mainImage
    ? `${ IMAGES.PRODUCT_IMG_TH_PATH }${ state.product.mainImage.thumbnail }`
    : [ IMAGES.DEFAULT_IMG ],
);

const handleFileChange = (evt) => {
    const files = evt.target.files;
    const countFiles = files.length;

    if ( !countFiles ) {
        alert('Не выбран файл!');
        return;
    }

    const file = files[0];
    const fileName = file.name.toLowerCase();

    const matches = ALLOWED_FILE_TYPES.some(type => fileName.endsWith(type));

    if ( matches ) {
        const reader = new FileReader();
        reader.onerror = () => alert(`Произошла ошибка при чтении файла: ${ fileName }`);
        reader.onloadend = () => uploadedProductImageRef.value.src = reader.result;
        reader.readAsDataURL(file);
    } else {
        alert('Загружать можно только изображения');
    }
};

const handleCheckboxFilter = (filter) => {
    if ( filter === null ) {
        searchBy.weight = [];
        return;
    }
    if ( searchBy.weight.includes(filter) ) {
        return searchBy.weight.splice(searchBy.weight.indexOf(filter), 1);
    }
    return searchBy.weight.push(filter);
};

const saveProduct = () => {
    state.isEditing ? updateProduct() : createProduct();
};

const createProduct = async () => {
    const product = {
        ...state.product,
        image: uploadedProductImageRef.value.src,
    };
    const response = await post(ADMIN_URLS.PRODUCT, product);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        state.product = initialFormData();
        modalPopUp.hide();
        state.products.push(response.data);
        arrayHandlers.resetSearchKeys(searchBy);
        arrayHandlers.resetSortKeys('id', false);
    }
};

const updateProduct = async () => {
    const product = { ...state.product };
    const updatedImage = uploadedProductImageRef.value.src;
    const productImage = product.mainImage ? product.mainImage.thumbnail.toString() : null;

    if ( updatedImage.indexOf('base64') !== -1 ) {
        product.image = updatedImage.includes(productImage)
            ? productImage
            : updatedImage;
    }

    product.mainImage = null;

    const response = await update(`${ ADMIN_URLS.PRODUCT }/${ product.id }`, product);

    if ( response && response.status === 'success' ) {
        alertStore.clear();
        state.product = initialFormData();
        const updatedProduct = response.data;
        const idx = state.products.findIndex(pr => pr.id === updatedProduct.id);
        state.products[idx] = updatedProduct;
        modalPopUp.hide();
    }
};

const deleteProduct = async (id) => {
    if ( confirm('Точно удалить продукт? Уверены?') ) {
        const { status } = await destroy(`${ ADMIN_URLS.PRODUCT }/${ id }`);
        if ( status === 'success' ) {
            const idx = state.products.findIndex(pr => pr.id === id);
            state.products.splice(idx, 1);
        }
    }
};

const sortedItems = computed(() => {
    return arrayHandlers.sortArray(state.products);
});

const filteredItems = computed(() => {
    return arrayHandlers.filterArray(sortedItems.value, searchBy);
});

const weights = computed(() => {
    return [...new Set(state.products.map(pr => pr.weight))]
        .sort((w1, w2) => w1 > w2 ? 1 : -1);
});

const boxWeight = computed(() => {
    return (state.product.weight * state.product.capacity) / 1000;
});

const packSize = computed(() => {
    return state.product.width * state.product.depth * state.product.height;
});
</script>
