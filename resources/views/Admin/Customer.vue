<template>
    <div class="row mb-4">
        <div class="col-12">
            <button
                @click="createCustomerInit"
                class="btn btn-primary"
                type="button"
            >
                Новый контрагент
            </button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <fieldset>
                <legend>Фильтр</legend>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <InputGroup
                            v-model="searchBy.name"
                            placeholder="Поиск по названию"
                        >
                            Клиент
                        </InputGroup>
                    </div>
                    <div class="col-md-4 mb-2">
                        <SelectGroup
                            v-model="searchBy.userId"
                            :chooseFrom="'-- Выберите менеджера --'"
                            :items="state.users"
                            selectedOption="fullName"
                        >Менеджер
                        </SelectGroup>
                    </div>
                    <div class="col-md-4 mb-2">
                        <SelectGroup
                            v-model="searchBy.regionId"
                            :chooseFrom="'-- Выберите регион --'"
                            :items="state.regions"
                        >Регион
                        </SelectGroup>
                    </div>
                    <div class="col-md-4 mb-2">
                        <InputGroup
                            v-model="searchBy.city"
                            placeholder="Поиск по городу"
                        >
                            Город
                        </InputGroup>
                    </div>
                    <div class="col-md-4 mb-2">
                        <CheckboxGroup
                            id="is_active"
                            v-model="searchBy.isActive"
                        >
                            Показать только активных
                        </CheckboxGroup>
                    </div>
                </div>
                <button
                    class="btn btn-secondary my-2"
                    type="button"
                    @click="clearSearch"
                >
                    Сбросить фильтр
                </button>
            </fieldset>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-0">
                    <div class="table-responsive">
                        <table v-if="state.customers.length > 0"
                               class="table table-bordered my-4 text-center align-middle text-nowrap"
                               style="width: 100%;">
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
                                    class="text-start"
                                    sort-type="alpha"
                                    @sortByColumn="applyFilterSort(
                                        'name',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                        false,
                                    )"
                                >Название
                                </ThSort>
                                <ThSort
                                    :id="'userId'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    class="text-start"
                                    sort-type="numeric"
                                    @sortByColumn="applyFilterSort(
                                        'userId',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                    )"
                                >Менеджер
                                </ThSort>
                                <ThSort
                                    :id="'region'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    class="text-start"
                                    sort-type="alpha"
                                    @sortByColumn="applyFilterSort(
                                        'region',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                        false,
                                    )"
                                >Регион
                                </ThSort>
                                <ThSort
                                    :id="'city'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='15'
                                    class="text-start"
                                    sort-type="alpha"
                                    @sortByColumn="applyFilterSort(
                                        'city',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                        false,
                                    )"
                                >Город
                                </ThSort>
                                <ThSort
                                    :id="'isActive'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='12'
                                    @sortByColumn="applyFilterSort(
                                        'isActive',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                    )"
                                >Активный?
                                </ThSort>
                                <th scope="col" style="width: 10%;">Просмотр</th>
                                <th scope="col" style="width: 10%;">Ред.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="customer in state.customers" :key="customer.id">
                                <th scope="row">{{ customer.id }}</th>
                                <td class="text-start" style="cursor: pointer;"
                                    @click="showViewCustomerModal(customer.id)">
                                    {{ customer.name }}
                                </td>
                                <td class="text-start">
                                    {{ customer.user }}
                                </td>
                                <td class="text-start">
                                    {{ customer.region }}
                                </td>
                                <td class="text-start">
                                    {{ customer.city }}
                                </td>
                                <td>
                                    <Badge :is-active="customer.isActive"/>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-primary"
                                        @click="showViewModal(customer.id)"
                                    ><i class="bi bi-eye-fill"></i>
                                        View
                                    </button>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-warning"
                                        @click="editCustomerInit(customer.id)"
                                    ><i class="bi bi-pencil-square"></i>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p v-else class="mt-3 text-center lead">
                            {{ customerStore.isContentLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
                        </p>
                    </div>
                    <p>Всего записей: <span class="fw-bold">{{ state.customers.length }}</span></p>
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
            <span v-if="state.isEditing">Редактирование контрагента <b>{{ state.customer.name }}</b></span>
            <span v-else>Добавление контрагента</span>
        </template>
        <template #body>
            <Alert/>
            <div class="row g-3">
                <div class="col-12">
                    <Label for="name" required>Название контрагента</Label>
                    <Input
                        v-model="state.customer.name"
                        type="text"
                        id="name"
                        placeholder="Например: Уральская Бакалея, ООО"
                    />
                </div>
                <div class="col-12">
                    <Label for="region_id" required>Регион</Label>
                    <select
                        v-model="state.customer.regionId"
                        id="region_id"
                        class="form-select"
                        @change="handleRegionChange($event.target.value)"
                    >
                        <option value="" selected disabled>-- Выберите регион --</option>
                        <option
                            v-for="region in state.regions"
                            :value="region.id"
                            :key="region.id"
                        >{{ region.name }}
                        </option>
                    </select>
                </div>
                <div class="col-12" v-if="state.customer.regionId">
                    <Label for="city_id" required>Город</Label>
                    <select v-model="state.customer.cityId" id="city_id" class="form-select">
                        <option value="" selected disabled>-- Выберите город --</option>
                        <option
                            v-for="city in cities"
                            :value="city.id"
                            :key="city.id"
                        >{{ city.name }}
                        </option>
                    </select>
                </div>
            </div>
        </template>
        <template #footer>
            <Button
                @click="saveCustomer"
                type="button"
                :loading="customerStore.isButtonDisabled"
                :disabled="customerStore.isButtonDisabled"
                class="w-25"
                :class="state.isEditing ? 'btn-warning' : 'btn-primary'"
            >
                <span v-if="state.isEditing">Сохранить</span>
                <span v-else>Создать</span>
            </Button>
        </template>
    </Modal>
</template>

<script setup>
import { computed, onMounted, reactive, ref, watch } from 'vue';
import { useCustomerStore } from '@/stores/customers.js';
import { useUserStore } from '@/stores/users.js';
import { useRegionStore } from '@/stores/regions.js';
import { useAlertStore } from '@/stores/alerts.js';
import { arrFilter, arrSort } from '@/helpers/arrHandlers.js';
import { resetSearchKeys } from '@/helpers/searchHandlers.js';
import ThSort from '@/components/core/ThSort.vue';
import Button from '@/components/core/Button.vue';
import Badge from '@/components/core/Badge.vue';
import InputGroup from '@/components/core/InputGroup.vue';
import SelectGroup from '@/components/core/SelectGroup.vue';
import CheckboxGroup from '@/components/core/CheckboxGroup.vue';
import Modal from '@/components/Modal.vue';
import Input from '@/components/core/Input.vue';
import Label from '@/components/core/Label.vue';
import Alert from '@/components/Alert.vue';

const customerStore = useCustomerStore();
const userStore = useUserStore();
const regionStore = useRegionStore();
const alertStore = useAlertStore();

const initialFormData = () => ({
    name: '',
    description: '',
    regionId: '',
    cityId: '',
    userId: '',
    isActive: true,
});

const state = reactive({
    customers: [],
    users: [],
    regions: [],
    customer: initialFormData(),
    isEditing: false,
});

const searchBy = reactive({
    name: '',
    userId: '',
    regionId: '',
    city: '',
    isActive: false,
});

let orderColumn = 'id';
let orderDirection = 'asc';

let modalPopUp = null;

onMounted(async () => {
    await getCustomers();
    await getUsers();
    await getRegions();

    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', () => {
        state.isEditing = false;
        state.customer = initialFormData();
    });
});

const getCustomers = async () => {
    await customerStore.all();
    applyFilterSort();
};

const getUsers = async () => {
    const response = await userStore.all(true);
    state.users = response.data;
};

const getRegions = async () => {
    const response = await regionStore.all();
    state.regions = response.data;
};

const getCities = computed((regionId) => {
    return state.regions.map(region => {
        if (region.id === regionId) {
            return region.cities;
        }
    });
});

const createCustomerInit = () => {
    alertStore.clear();
    state.isEditing = false;
    modalPopUp.show();
};

const editCustomerInit = (id) => {
    alertStore.clear();
    state.isEditing = true;
    modalPopUp.show();
    state.customer = customerStore.getCustomers.find(item => item.id === id);
};

const closeModal = () => {
    modalPopUp.hide();
};

const saveCustomer = async () => {
    if ( state.isEditing ) {

        return;
    }

    const response = await customerStore.save(state.customer);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        state.customer = initialFormData();
        modalPopUp.hide();
        resetSearchKeys(searchBy);
        orderColumn = 'id';
        orderDirection = 'desc';
        await getCustomers();
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

    let tempArr = customerStore.getCustomers.slice();

    tempArr = arrFilter(tempArr, searchBy);
    tempArr = arrSort(tempArr, sort_by_numeric, direction, column);

    state.customers = tempArr;
};
</script>
