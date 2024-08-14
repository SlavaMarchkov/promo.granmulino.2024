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
                        Показать только активные ТС
                    </CheckboxGroup>
                </div>
            </Filter>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-0">
                    <div class="table-responsive">
                        <table v-if="state.retailers.length > 0"
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
                            <tr v-for="retailer in state.retailers" :key="retailer.id">
                                <th scope="row">{{ retailer.id }}</th>
                                <td class="text-start" style="cursor: pointer;"
                                    @click="showViewCustomerModal(retailer.id)">
                                    {{ retailer.name }}
                                </td>
                                <td class="text-start">
                                    {{ retailer.user }}
                                </td>
                                <td class="text-start">
                                    {{ retailer.region }}
                                </td>
                                <td class="text-start">
                                    {{ retailer.city }}
                                </td>
                                <td>
                                    <Badge :is-active="retailer.isActive"/>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-primary"
                                        @click="showViewModal(retailer.id)"
                                    ><i class="bi bi-eye-fill"></i>
                                        View
                                    </button>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-warning"
                                        @click="editRetailerInit(retailer.id)"
                                    ><i class="bi bi-pencil-square"></i>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p v-else class="mt-3 text-center lead">
                            {{ retailerStore.isContentLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
                        </p>
                    </div>
                    <p>Всего записей: <span class="fw-bold">{{ state.retailers.length }}</span></p>
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
                    <Input
                        id="name"
                        v-model="state.retailer.name"
                        placeholder="Например: Пятёрочка"
                        type="text"
                    />
                </div>
                <div class="col-12">
                    <Label for="region_id" required>Регион</Label>
                    <select
                        id="region_id"
                        v-model="state.retailer.regionId"
                        class="form-select"
                    >
                        <option disabled selected value="null">-- Выберите регион --</option>
                        <option
                            v-for="region in state.regions"
                            :key="region.id"
                            :value="region.id"
                        >{{ region.name }}
                        </option>
                    </select>
                </div>
                <div v-if="state.retailer.regionId" class="col-12">
                    <Label for="city_id" required>Город</Label>
                    <select id="city_id" v-model="state.retailer.cityId" class="form-select">
                        <option disabled selected value="null">-- Выберите город --</option>
                        <option
                            v-for="city in state.cities"
                            :key="city.id"
                            :value="city.id"
                        >{{ city.name }}
                        </option>
                    </select>
                </div>
                <div class="col-12">
                    <Label for="user_id" required>Менеджер для контрагента</Label>
                    <select
                        id="user_id"
                        v-model="state.retailer.userId"
                        class="form-select"
                    >
                        <option disabled selected value="null">-- Выберите ФИО --</option>
                        <option
                            v-for="user in state.users"
                            :key="user.id"
                            :value="user.id"
                        >{{ user }}
                        </option>
                    </select>
                </div>
                <div class="col-12">
                    <Label for="description">Описание для торговой сети</Label>
                    <textarea
                        id="description"
                        v-model="state.retailer.description"
                        class="form-control"
                        placeholder="Укажите произвольное описание"
                    ></textarea>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input
                            id="is-active"
                            v-model="state.retailer.isActive"
                            :checked="state.retailer.isActive"
                            class="form-check-input"
                            type="checkbox"
                        >
                        <label class="form-check-label" for="is-active">
                            ТС активная?
                        </label>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <Button
                :class="state.isEditing ? 'btn-warning' : 'btn-primary'"
                :disabled="retailerStore.isButtonDisabled"
                :loading="retailerStore.isButtonDisabled"
                class="w-25"
                type="button"
                @click="saveRetailer"
            >
                <span v-if="state.isEditing">Сохранить</span>
                <span v-else>Создать</span>
            </Button>
        </template>
    </Modal>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useRetailerStore } from '@/stores/retailers.js';
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
import Filter from '@/components/core/Filter.vue';

const retailerStore = useRetailerStore;
const alertStore = useAlertStore();

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

const searchBy = reactive({
    name: '',
    userId: '',
    regionId: '',
    city: '',
    isActive: false,
});

const orderColumn = ref('id');
let orderDirection = ref('asc');

let modalPopUp = null;

onMounted(async () => {
    await getRetailers();

    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', () => {
        state.isEditing = false;
        state.retailer = initialFormData();
    });
});

const getRetailers = async () => {
    await retailerStore.all();
    // applyFilterSort();
};

/*const getRegions = async () => {
    const response = await regionStore.all();
    state.regions = response.data;
};*/

const createRetailerInit = () => {
    alertStore.clear();
    state.isEditing = false;
    state.retailers = [];
    modalPopUp.show();
};

const editRetailerInit = (id) => {
    alertStore.clear();
    state.isEditing = true;
    modalPopUp.show();
    state.retailer = retailerStore.getRetailers.find(item => item.id === id);
    // getCitiesForRegion(state.customer.regionId);
};

const closeModal = () => {
    modalPopUp.hide();
};

const saveRetailer = async () => {
    if ( state.isEditing ) {
        const response = await retailerStore.update(state.retailer);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            modalPopUp.hide();
            await getRetailers();
        }
    } else {
        const response = await retailerStore.save(state.retailer);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            state.retailer = initialFormData();
            modalPopUp.hide();
            resetSearchKeys(searchBy);
            orderColumn.value = 'id';
            orderDirection.value = 'desc';
            await getRetailers();
        }
    }
};
</script>
