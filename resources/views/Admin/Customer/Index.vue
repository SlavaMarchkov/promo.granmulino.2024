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
            <Filter
                @reset-filter="clearSearch"
            >
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
                    <TheCheckbox
                        id="is_active"
                        v-model="searchBy.isActive"
                    >
                        Показать только активных
                    </TheCheckbox>
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
                                    <RouterLink :to="{ name: 'Customer.View', params: { id: item.id } }">
                                        {{ item.name }}
                                    </RouterLink>
                                </td>
                                <td class="text-start">
                                    {{ item.user }}
                                </td>
                                <td class="text-start">
                                    {{ item.region }}
                                </td>
                                <td class="text-start">
                                    {{ item.city }}
                                </td>
                                <td>
                                    <TheBadge :is-active="item.isActive"/>
                                </td>
                                <TdButton
                                    :id="item.id"
                                    intent="view"
                                    @runButtonHandler="viewCustomerInit"
                                >View
                                </TdButton>
                                <TdButton
                                    :id="item.id"
                                    intent="edit"
                                    @runButtonHandler="editCustomerInit"
                                >Edit
                                </TdButton>
                                <template
                                    v-if="isSuperAdmin"
                                >
                                    <TdButton
                                        :id="item.id"
                                        intent="delete"
                                        @runButtonHandler="deleteCustomer"
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
            <span v-if="state.isEditing">Редактирование контрагента <br><b>{{ state.customer.name }}</b></span>
            <span v-else>Добавление контрагента</span>
        </template>
        <template #body>
            <Alert/>
            <div class="row g-3">
                <div class="col-12">
                    <TheLabel for="name" required>Название контрагента</TheLabel>
                    <TheInput
                        v-model="state.customer.name"
                        type="text"
                        id="name"
                        placeholder="Например: Уральская Бакалея, ООО"
                    />
                </div>
                <div class="col-12">
                    <TheLabel for="region_id" required>Регион</TheLabel>
                    <select
                        v-model="state.customer.regionId"
                        @change="getCitiesForRegion(); state.customer.cityId = null"
                        id="region_id"
                        class="form-select"
                    >
                        <option disabled selected value="null">-- Выберите регион --</option>
                        <option
                            v-for="region in state.regions"
                            :value="region.id"
                            :key="region.id"
                        >{{ region.name }}
                        </option>
                    </select>
                </div>
                <div class="col-12" v-if="state.customer.regionId">
                    <TheLabel for="city_id" required>Город</TheLabel>
                    <select
                        v-model="state.customer.cityId"
                        id="city_id"
                        class="form-select"
                    >
                        <option disabled selected value="null">-- Выберите город --</option>
                        <option
                            v-for="city in state.cities"
                            :value="city.id"
                            :key="city.id"
                        >{{ city.name }}
                        </option>
                    </select>
                </div>
                <div class="col-6">
                    <TheLabel for="user_id">Менеджер для контрагента</TheLabel>
                    <select
                        id="user_id"
                        v-model="state.customer.userId"
                        class="form-select"
                    >
                        <option disabled selected value="null">-- Выберите ФИО --</option>
                        <option
                            v-for="user in state.users"
                            :key="user.id"
                            :value="user.id"
                        >{{ user.fullName }}
                        </option>
                    </select>
                </div>
                <div class="col-6">
                    <TheLabel>Сброс привязки менеджера</TheLabel>
                    <Button
                        @click="state.customer.userId = null"
                        type="button"
                        :class="[
                            'btn-light',
                            {
                                'btn-disabled': state.customer.userId === null,
                            }
                        ]"
                        :disabled="state.customer.userId === null"
                    >
                        Сбросить
                    </Button>
                </div>
                <div class="col-12">
                    <TheLabel for="description">Описание для контрагента</TheLabel>
                    <textarea
                        id="description"
                        v-model="state.customer.description"
                        class="form-control"
                        placeholder="Укажите произвольное описание"
                    ></textarea>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input
                            id="is-active"
                            v-model="state.customer.isActive"
                            :checked="state.customer.isActive"
                            class="form-check-input"
                            type="checkbox"
                        >
                        <label class="form-check-label" for="is-active">
                            Активный?
                        </label>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <Button
                @click="saveCustomer"
                type="button"
                :loading="spinnerStore.isButtonDisabled"
                :disabled="spinnerStore.isButtonDisabled"
                class="w-25"
                :class="state.isEditing ? 'btn-warning' : 'btn-primary'"
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
            Просмотр контрагента <b>{{ state.customer.name }}</b>
        </template>
        <template #body>
            <table class="table table-bordered mt-3 align-middle text-wrap"
                   style="width: 100%;">
                <tbody>
                <tr>
                    <th style="width: 20%;">ID</th>
                    <td>{{ state.customer.id }}</td>
                </tr>
                <tr>
                    <th>Название</th>
                    <td>{{ state.customer.name }}</td>
                </tr>
                <tr>
                    <th>Регион</th>
                    <td>{{ state.customer.region }}</td>
                </tr>
                <tr>
                    <th>Город</th>
                    <td>{{ state.customer.city }}</td>
                </tr>
                <tr>
                    <th>Менеджер</th>
                    <td>{{ state.customer.user }}</td>
                </tr>
                <tr>
                    <th>Активен?</th>
                    <td><TheBadge :is-active="state.customer.isActive" /></td>
                </tr>
                <tr>
                    <th>Описание</th>
                    <td>{{ state.customer.description }}</td>
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
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import ThSort from '@/components/table/ThSort.vue';
import Button from '@/components/core/Button.vue';
import TheBadge from '@/components/core/TheBadge.vue';
import InputGroup from '@/components/form/InputGroup.vue';
import SelectGroup from '@/components/form/SelectGroup.vue';
import TheCheckbox from '@/components/form/TheCheckbox.vue';
import Modal from '@/components/Modal.vue';
import TheInput from '@/components/form/TheInput.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import Alert from '@/components/Alert.vue';
import Filter from '@/components/core/Filter.vue';
import TdButton from '@/components/table/TdButton.vue';
import { ADMIN_URLS, CUSTOMER_TH_FIELDS, DELETE_TH_FIELD, EDIT_TH_FIELD, ROLES } from '@/helpers/constants.js';

const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const authStore = useAuthStore();
const arrayHandlers = useArrayHandlers();
const { get, post, update, destroy } = useHttpService();

const role = authStore.getUser.role;
const isSuperAdmin = computed(() => role === ROLES.SUPER_ADMIN);

const thItems = computed(() => {
    return isSuperAdmin
        ? CUSTOMER_TH_FIELDS.concat(EDIT_TH_FIELD, DELETE_TH_FIELD)
        : CUSTOMER_TH_FIELDS.concat(EDIT_TH_FIELD);
});

const initialFormData = () => ({
    name: '',
    description: '',
    isActive: true,
    regionId: null,
    cityId: null,
    userId: null,
});

const state = reactive({
    customers: [],
    users: [],
    regions: [],
    cities: [],
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

let modalPopUp = null;
let viewModalPopUp = null;

function resetState() {
    state.isEditing = false;
    state.customer = initialFormData();
}

onMounted(async () => {
    await getCustomers();
    await getUsers();
    await getRegions();
    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', resetState);
});

const getCustomers = async () => {
    const { data } = await get(ADMIN_URLS.CUSTOMER);
    state.customers = data.customers;
};

const getOneCustomer = (id) => state.customers.find(customer => customer.id === id);

const getRegions = async () => {
    const { data } = await get(ADMIN_URLS.REGION);
    state.regions = data.regions;
};

const getUsers = async () => {
    const { data } = await get(ADMIN_URLS.USER, {
        params: {
            is_active: true,
        },
    });
    state.users = data.users;
};

const getCitiesForRegion = () => {
    state.regions.map(region => {
        if ( +region.id === +state.customer.regionId ) {
            state.cities = region.cities;
        }
    });
};

const createCustomerInit = () => {
    alertStore.clear();
    state.isEditing = false;
    state.cities = [];
    state.customer = initialFormData();
    modalPopUp.show();
};

const editCustomerInit = (id) => {
    alertStore.clear();
    state.isEditing = true;
    state.customer = getOneCustomer(id);
    getCitiesForRegion(state.customer.regionId);
    modalPopUp.show();
};

const viewCustomerInit = (id) => {
    viewModalPopUp = new bootstrap.Modal(document.getElementById('viewModalPopUp'));
    state.customer = getOneCustomer(id);
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

const saveCustomer = async () => {
    if ( state.isEditing ) {
        const response = await update(`${ ADMIN_URLS.CUSTOMER }/${ state.customer.id }`, state.customer);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            modalPopUp.hide();
            await getCustomers();
        }
    } else {
        const response = await post(ADMIN_URLS.CUSTOMER, state.customer);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            state.customer = initialFormData();
            modalPopUp.hide();
            arrayHandlers.resetSearchKeys(searchBy);
            arrayHandlers.resetSortKeys('id', false);
            await getCustomers();
        }
    }
};

const deleteCustomer = async (id) => {
    if ( confirm('Точно удалить контрагента? Уверены?') ) {
        const response = await destroy(`${ ADMIN_URLS.CUSTOMER }/${ id }`);
        if ( response && response.status === 'success' ) {
            await getCustomers();
        }
    }
};

const sortedItems = computed(() => {
    return arrayHandlers.sortArray(state.customers);
});

const filteredItems = computed(() => {
    return arrayHandlers.filterArray(sortedItems.value, searchBy);
});
</script>
