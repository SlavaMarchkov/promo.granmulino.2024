<template>
    <div class="row mb-4">
        <div class="col-12">
            <button class="btn btn-primary me-2" type="button" @click="showNewCategoryModal">
                Новая группа товаров
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
                                <td class="py-1" style="width: 30%;">
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
                                <td class="py-1"></td>
                                <td class="py-1" style="width: 18%;">
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
                        <table v-if="categories.length > 0" class="table table-bordered mb-3 text-center align-middle"
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
                                    :width='30'
                                    class="text-start"
                                    sort-type="alpha"
                                    @sortByColumn="applyFilterSort(
                                        'name',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                        false,
                                    )"
                                >Название группы товаров
                                </ThSort>
                                <ThSort
                                    :id="'productsCount'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    sort-type="numeric"
                                    @sortByColumn="applyFilterSort(
                                        'productsCount',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                    )"
                                >Количество SKU в группе
                                </ThSort>
                                <ThSort
                                    :id="'isActive'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='18'
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
                            <tr v-for="category in categories" :key="category.id">
                                <th scope="row">{{ category.id }}</th>
                                <td class="text-start" style="cursor: pointer;"
                                    @click="showViewCategoryModal(category.id)">
                                    {{ category.name }}
                                </td>
                                <td>
                                    {{ category.productsCount }}
                                </td>
                                <td>
                                    <Badge :is-active="category.isActive"/>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-primary"
                                        @click="showViewCategoryModal(category.id)"
                                    ><i class="bi bi-eye-fill"></i>
                                        View
                                    </button>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-warning"
                                        @click="showEditCategoryModal(category.id)"
                                    ><i class="bi bi-pencil-square"></i>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p v-else class="mt-3 text-center lead">
                            {{ categoryStore.isContentLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
                        </p>
                    </div>
                    <p>Всего записей: <span class="fw-bold">{{ categories.length }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- New Category Modal Start -->
    <div id="newCategory" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">
            <form @submit.prevent="saveCategory">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Добавление группы товаров</h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <Alert/>
                        <div class="row g-3">
                            <div class="col-12">
                                <Label for="name" required>Название группы товаров</Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    placeholder="Например: Granmulino Премиум"
                                    type="text"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <Button
                            :disabled="categoryStore.isButtonDisabled"
                            :loading="categoryStore.isButtonDisabled"
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
    <!-- New Category Modal End -->

    <!-- Edit One Category Modal Start -->
    <div id="editCategory" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">
            <form @submit.prevent="updateCategory(category)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактирование группы товаров</h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <Alert/>
                        <div class="row g-3">
                            <div class="col-12">
                                <Label for="edit-name" required>Название группы товаров</Label>
                                <Input
                                    id="edit-name"
                                    v-model="category.name"
                                    placeholder="Например: Granmulino Премиум"
                                    type="text"
                                />
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input
                                        id="edit-isActive"
                                        v-model="category.isActive"
                                        :checked="category.isActive"
                                        class="form-check-input"
                                        type="checkbox"
                                    >
                                    <label class="form-check-label" for="edit-isActive">
                                        Группа товаров в продаже?
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <Button
                            :disabled="categoryStore.isButtonDisabled"
                            :loading="categoryStore.isButtonDisabled"
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
    <!-- Edit One Category Modal End -->

    <!-- View One Category Modal Start -->
    <div id="viewCategory" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Просмотр группы товаров</h5>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <pre>
                        {{ category }}
                    </pre>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <!-- View One Category Modal End -->
</template>

<script setup>
import Input from '@/components/core/Input.vue';
import Label from '@/components/core/Label.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import Badge from '@/components/core/Badge.vue';
import ThSort from '@/components/core/ThSort.vue';
import { onMounted, reactive, ref, watch } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useCategoryStore } from '@/stores/categories.js';

const categoryStore = useCategoryStore();
const alertStore = useAlertStore();

const initialFormData = () => ({
    name: '',
});

let form = reactive(initialFormData());

const categories = ref([]);
const category = ref({});

const searchBy = reactive({
    name: '',
    isActive: false,
});

let orderColumn = 'id';
let orderDirection = 'asc';

let newCategoryModal = null;
let editCategoryModal = null;
let viewCategoryModal = null;

onMounted(async () => {
    await getCategories();
});

const getCategories = async () => {
    await categoryStore.all();
    applyFilterSort();
};

const getCategory = (id) => {
    category.value = categoryStore.getCategories
        .find(item => item.id === id);
};

const showNewCategoryModal = async () => {
    alertStore.clear();
    newCategoryModal = new bootstrap.Modal(document.getElementById('newCategory'));
    newCategoryModal.show();
};

const showEditCategoryModal = (id) => {
    alertStore.clear();
    editCategoryModal = new bootstrap.Modal(document.getElementById('editCategory'));
    editCategoryModal.show();
    getCategory(id);
};

// TODO: make view
const showViewCategoryModal = (id) => {
    viewCategoryModal = new bootstrap.Modal(document.getElementById('viewCategory'));
    viewCategoryModal.show();
    getCategory(id);
};

const saveCategory = async () => {
    const response = await categoryStore.save(form);
    if ( response && response.status === 'success' ) {
        form = initialFormData();
        alertStore.clear();
        newCategoryModal.hide();
        resetSearchKeys();
        orderColumn = 'id';
        orderDirection = 'desc';
        await getCategories();
    }
};

const updateCategory = async (category) => {
    const response = await categoryStore.update(category);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        editCategoryModal.hide();
        await getCategories();
    }
};

const clearSearch = () => {
    resetSearchKeys();
    applyFilterSort(
        (orderColumn = 'id'),
        (orderDirection = 'asc'),
    );
};

const resetSearchKeys = () => {
    for ( const key in searchBy ) {
        searchBy[key] = '';
    }
};

watch(searchBy, () => applyFilterSort());

const applyFilterSort = (
    column = orderColumn,
    direction = orderDirection,
    sort_by_numeric = true,
) => {
    orderColumn = column;
    orderDirection = direction;

    let tempArr = categoryStore.getCategories.slice();

    tempArr = tempArr.sort((a, b) => {
        if ( sort_by_numeric ) {
            return orderDirection === 'asc'
                ? a[column] - b[column]
                : b[column] - a[column];
        } else {
            const fa = a[column].toLowerCase();
            const fb = b[column].toLowerCase();

            return orderDirection === 'asc'
                ? fa.localeCompare(fb)
                : fb.localeCompare(fa);
        }
    });

    for ( const key in searchBy ) {
        if ( key === 'isActive' && searchBy[key] === true ) {
            tempArr = tempArr.filter(item => item[key] === true);
        } else if ( key !== 'isActive' && searchBy[key] !== '' ) {
            tempArr = tempArr.filter(item => item[key].toLowerCase().includes(searchBy[key].toLowerCase()));
        }
    }

    categories.value = tempArr;
};
</script>
