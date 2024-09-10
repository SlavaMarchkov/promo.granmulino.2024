<template>
    <div class="row mb-4">
        <div class="col-12">
            <button
                class="btn btn-primary"
                type="button"
                @click="createRetailerInit"
            >
                Новая торговая сеть
            </button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <Filter
                @reset-filter="clearSearch"
            >
                <div class="col-md-4 mb-2">
                    <InputGroup
                        v-model="searchBy.name"
                        placeholder="Поиск по названию ТС"
                    >Название</InputGroup>
                </div>
                <div
                    class="col-md-2 mb-2"
                    v-for="item of retailerTypes"
                    :key="item.id"
                >
                    <RadioButton
                        :id="item.id"
                        :value="item.value"
                        name="retailer-type"
                        v-model="searchBy.type">{{ item.title }}
                    </RadioButton>
                </div>
                <div class="col-md-4 mb-2">
                    <InputGroup
                        v-model="searchBy.city"
                        placeholder="Поиск по городу"
                    >Город</InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <InputGroup
                        v-model="searchBy.customer"
                        placeholder="Поиск по контрагенту"
                    >Контрагент</InputGroup>
                </div>
                <div class="col-md-2 mb-2">
                    <Checkbox
                        id="is_active"
                        v-model="searchBy.isActive"
                    >Только активные</Checkbox>
                </div>
                <div class="col-md-2 mb-2">
                    <Checkbox
                        id="is_direct"
                        v-model="searchBy.isDirect"
                    >Только прямые</Checkbox>
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
                                <th scope="row">{{ item.id }}</th>
                                <td class="text-start">
                                    <RouterLink :to="{ name: 'Retailer.View', params: { id: item.id } }">
                                        {{ item.name }}
                                    </RouterLink>
                                </td>
                                <td class="text-start">
                                        <span
                                            :class="['badge', 'bg-opacity-75', item.typeBgColor]"
                                            :title="item.typeDescription"
                                            style="font-size: 0.8em;"
                                        >{{ item.label }}</span>
                                </td>
                                <td class="text-start">
                                    {{ item.customer }}
                                </td>
                                <td class="text-start">
                                    {{ item.city }}
                                </td>
                                <td>
                                    <Badge :is-active="item.isDirect"/>
                                </td>
                                <td>
                                    <Badge :is-active="item.isActive"/>
                                </td>
                                <TdButton
                                    :id="item.id"
                                    intent="view"
                                    @runButtonHandler="viewRetailerInit"
                                >View
                                </TdButton>
                                <TdButton
                                    :id="item.id"
                                    intent="edit"
                                    @runButtonHandler="editRetailerInit"
                                >Edit
                                </TdButton>
                                <TdButton
                                    :id="item.id"
                                    intent="delete"
                                    @runButtonHandler="deleteRetailer"
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
            <span v-if="state.isEditing">Редактирование торговой сети <br><b>{{ state.retailer.name }}</b></span>
            <span v-else>Добавление торговой сети</span>
        </template>
        <template #body>
            <Alert/>
            <div class="row g-3">
                <div class="col-12">
                    <Label for="name" required>Название торговой сети</Label>
                    <Input id="name" v-model="state.retailer.name" placeholder="Например: Пятёрочка" type="text"/>
                </div>
                <div class="col-12">
                    <Label for="customer_id" required>Контрагент</Label>
                    <select id="customer_id" v-model="state.retailer.customerId" class="form-select">
                        <option disabled selected value="null">-- Выберите дистрибутора, который поставляет в эту ТС
                            --
                        </option>
                        <option v-for="customer in state.customers" :key="customer.id" :value="customer.id">
                            {{ customer.name }}
                        </option>
                    </select>
                </div>
                <div class="col-12">
                    <Label for="type" required>Тип торговой сети</Label>
                    <select id="type" v-model="state.retailer.type" class="form-select">
                        <option disabled selected value="">-- Выберите тип торговой сети --</option>
                        <option value="local">Локальная</option>
                        <option value="regional">Региональная</option>
                        <option value="federal">Федеральная</option>
                    </select>
                </div>
                <div class="col-12">
                    <Label for="city_id" required>Город</Label>
                    <select id="city_id" v-model="state.retailer.cityId" class="form-select">
                        <option disabled selected value="null">-- Выберите город, где находится штаб-квартира ТС --
                        </option>
                        <option v-for="city in state.cities" :key="city.id" :value="city.id">{{ city.name }}
                        </option>
                    </select>
                </div>
                <div class="col-12">
                    <Label for="description">Описание для торговой сети</Label>
                    <textarea id="description" v-model="state.retailer.description" class="form-control"
                              placeholder="Укажите произвольное описание"></textarea>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input id="is-direct" v-model="state.retailer.isDirect" :checked="state.retailer.isDirect"
                               class="form-check-input" type="checkbox">
                        <label class="form-check-label" for="is-direct">
                            Прямой контракт (да/нет)
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input id="is-active" v-model="state.retailer.isActive" :checked="state.retailer.isActive"
                               class="form-check-input" type="checkbox">
                        <label class="form-check-label" for="is-active">
                            ТС активная (да/нет)
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
                @click="saveRetailer"
            >
                <span v-if="state.isEditing">Сохранить</span>
                <span v-else>Создать</span>
            </Button>
        </template>
    </Modal>

    <Modal
        id="viewModalPopUp"
        :close-func="closeViewModal"
        :custom-classes="['modal-lg', 'modal-dialog-scrollable']"
    >
        <template #title>
            Просмотр торговой сети <b>{{ state.retailer.name }}</b>
        </template>
        <template #body>
            <table class="table table-bordered mt-3 align-middle text-wrap"
                   style="width: 100%;">
                <tbody>
                <tr>
                    <th style="width: 30%;">ID</th>
                    <td>{{ state.retailer.id }}</td>
                </tr>
                <tr>
                    <th>Название</th>
                    <td>{{ state.retailer.name }}</td>
                </tr>
                <tr>
                    <th>Контрагент</th>
                    <td>{{ state.retailer.customer }}</td>
                </tr>
                <tr>
                    <th>Город</th>
                    <td>{{ state.retailer.city }}</td>
                </tr>
                <tr>
                    <th>Прямой контракт?</th>
                    <td><Badge :is-active="state.retailer.isDirect" /></td>
                </tr>
                <tr>
                    <th>Активна?</th>
                    <td><Badge :is-active="state.retailer.isActive" /></td>
                </tr>
                <tr>
                    <th>Описание</th>
                    <td>{{ state.retailer.description }}</td>
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
import { computed, onMounted, reactive, watch } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useRetailerStore } from '@/stores/retailers.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import Checkbox from '@/components/form/Checkbox.vue';
import Input from '@/components/form/Input.vue';
import Label from '@/components/form/Label.vue';
import InputGroup from '@/components/form/InputGroup.vue';
import RadioButton from '@/components/form/RadioButton.vue';
import ThSort from '@/components/table/ThSort.vue';
import Button from '@/components/core/Button.vue';
import Badge from '@/components/core/Badge.vue';
import Filter from '@/components/core/Filter.vue';
import Modal from '@/components/Modal.vue';
import Alert from '@/components/Alert.vue';
import TdButton from "@/components/table/TdButton.vue";

const retailerStore = useRetailerStore();
const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();
const { get, post, update, destroy } = useHttpService();

const retailerURL = '/retailers';
const cityURL = '/admin/cities';
const customerURL = '/customers';

const retailerTypes = [
    {
        id: 'local',
        value: 'local',
        title: 'Локальная',
    },
    {
        id: 'regional',
        value: 'regional',
        title: 'Региональная',
    },
    {
        id: 'federal',
        value: 'federal',
        title: 'Федеральная',
    },
    {
        id: 'all',
        value: '',
        title: 'Все типы ТС',
    },
];

const initialFormData = () => ({
    name: '',
    type: '',
    description: '',
    isActive: true,
    isDirect: false,
    customerId: null,
    cityId: null,
});

const state = reactive({
    retailers: [],
    customers: [],
    cities: [],
    retailer: initialFormData(),
    isEditing: false,
});

const thFields = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Название ТС', sortable: true, is_num: false },
    { column: 'label', label: 'Тип ТС', sortable: true, is_num: false },
    { column: 'customer', label: 'Контрагент', sortable: true, is_num: false },
    { column: 'city', label: 'Город', sortable: true, is_num: false },
    { column: 'isDirect', label: 'Прямой контракт?', sortable: true, is_num: true },
    { column: 'isActive', label: 'Активная?', sortable: true, is_num: true },
    { column: 'view', label: 'Просмотр', width: 10 },
    { column: 'edit', label: 'Ред.', width: 10 },
    { column: 'delete', label: 'Удалить', width: 10 },
];

const searchBy = reactive({
    name: '',
    city: '',
    customer: '',
    type: '',
    isActive: false,
    isDirect: false,
});

let modalPopUp = null;
let viewModalPopUp = null;

function resetState() {
    state.isEditing = false;
    state.retailer = initialFormData();
}

onMounted(async () => {
    await getRetailers();
    await getCustomers();
    await getCities();
    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', resetState);
});

const getRetailers = async () => {
    const { data } = await get(retailerURL);
    retailerStore.setRetailers(data.retailers);
    state.retailers = retailerStore.getRetailers;
};

const getCustomers = async () => {
    const { data } = await get(customerURL);
    state.customers = data.customers;
};

const getCities = async () => {
    const { data } = await get(cityURL);
    state.cities = data.cities;
};

const createRetailerInit = () => {
    alertStore.clear();
    state.isEditing = false;
    state.retailer = initialFormData();
    modalPopUp.show();
};

const editRetailerInit = (id) => {
    alertStore.clear();
    state.isEditing = true;
    state.retailer = retailerStore.oneRetailer(id);
    modalPopUp.show();
};

const viewRetailerInit = (id) => {
    viewModalPopUp = new bootstrap.Modal(document.getElementById('viewModalPopUp'));
    state.retailer = retailerStore.oneRetailer(id);
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
    state.retailers = arrayHandlers.filterArray(retailerStore.getRetailers, searchBy);
});

const clearSearch = () => {
    arrayHandlers.resetSearchKeys(searchBy);
    arrayHandlers.resetSortKeys();
};

const saveRetailer = async () => {
    if ( state.isEditing ) {
        const response = await update(`${ retailerURL }/${ state.retailer.id }`, state.retailer);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            modalPopUp.hide();
            await getRetailers();
        }
    } else {
        const response = await post(retailerURL, state.retailer);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            state.retailer = initialFormData();
            modalPopUp.hide();
            arrayHandlers.resetSearchKeys(searchBy);
            arrayHandlers.resetSortKeys('id', false);
            await getRetailers();
        }
    }
};

const deleteRetailer = async (id) => {
    if ( confirm('Точно удалить торговую сеть? Уверены?') ) {
        const response = await destroy(`${ retailerURL }/${ id }`);
        if ( response && response.status === 'success' ) {
            await getRetailers();
        }
    }
};

const sortedItems = computed(() => {
    return arrayHandlers.sortArray(state.retailers);
});

const filteredItems = computed(() => {
    return arrayHandlers.filterArray(sortedItems.value, searchBy);
});
</script>
