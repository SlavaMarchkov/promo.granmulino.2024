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
                    <SearchForm
                        v-model="searchBy.name"
                        placeholder="Поиск по названию ТС"
                    >Название
                    </SearchForm>
                </div>
                <FilterRadios
                    @filter="handleRadioFilter"
                ></FilterRadios>
                <div class="col-md-4 mb-2">
                    <SearchForm
                        @search="handleSearch"
                        placeholder="Поиск по городу"
                    >Город
                    </SearchForm>
                </div>
                <div class="col-md-4 mb-2">
                    <SearchForm
                        placeholder="Поиск по контрагенту"
                        @search="handleSearch"
                    >Контрагент
                    </SearchForm>
                </div>
                <div class="col-md-2 mb-2">
                    <FilterCheckbox
                        id="is_active"
                        @change="handleCheckboxFilter"
                    >
                        Только активные
                    </FilterCheckbox>
                </div>
                <div class="col-md-2 mb-2">
                    <FilterCheckbox
                        id="is_direct"
                        @change="handleCheckboxFilter"
                    >
                        Только прямые
                    </FilterCheckbox>
                </div>
            </Filter>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-0">
                    <div v-if="filteredItems.length > 0" class="table-responsive">
                        <table
                            class="table table-bordered my-4 text-center align-middle text-nowrap"
                            style="width: 100%;"
                        >
                            <thead>
                            <tr>
                                <th scope="col" style="width: 5%;">ID</th>
                                <th class="text-start" scope="col">Название ТС</th>
                                <th class="text-start" scope="col">Тип ТС</th>
                                <th class="text-start" scope="col">Контрагент</th>
                                <th class="text-start" scope="col">Город</th>
                                <th scope="col">Прямой контракт</th>
                                <th scope="col">Активная?</th>
                                <th scope="col" style="width: 10%;">Просмотр</th>
                                <th scope="col" style="width: 10%;">Ред.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in filteredItems" :key="item.id">
                                <th scope="row">{{ item.id }}</th>
                                <td class="text-start">
                                    {{ item.name }}
                                </td>
                                <td class="text-start">
                                    {{ item.typeRU }}
                                </td>
                                <td class="text-start">
                                    ---
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
                                <td>
                                    <button
                                        class="btn btn-sm btn-primary"
                                        @click="showViewModal(item.id)"
                                    ><i class="bi bi-eye-fill"></i>
                                        View
                                    </button>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-warning"
                                        @click="editRetailerInit(item.id)"
                                    ><i class="bi bi-pencil-square"></i>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <p v-else class="mt-3 text-center lead">
                        {{ retailerStore.isContentLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
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
import { computed, onMounted, reactive, ref, watch } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useRetailerStore } from '@/stores/retailers.js';
import Button from '@/components/core/Button.vue';
import Badge from '@/components/core/Badge.vue';
import FilterCheckbox from '@/components/core/FilterCheckbox.vue';
import Modal from '@/components/Modal.vue';
import Input from '@/components/core/Input.vue';
import Label from '@/components/core/Label.vue';
import Alert from '@/components/Alert.vue';
import Filter from '@/components/core/Filter.vue';
import SearchForm from '@/components/core/SearchForm.vue';
import FilterRadios from '@/components/core/FilterRadios.vue';

const retailerStore = useRetailerStore();
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

const searchFilter = ref('');
const radioFilter = ref('');

const searchBy = reactive({
    name: '',
    city: '',
    type: 'all',
    isActive: false,
    isDirect: false,
});

watch(searchBy, (newValue, oldValue) => {
    console.log(searchBy);
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
    const response = await retailerStore.all();
    state.retailers = response.data;
    // console.log(response);
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

const filteredItems = computed(() => {
    let items = state.retailers;

    if ( radioFilter.value && radioFilter.value !== 'all' ) {
        items = state.retailers.filter(item => item.type === radioFilter.value);
    }

    if ( searchFilter.value !== '' ) {
        items = state.retailers
            .filter(item => item.name.toLowerCase().includes(searchFilter.value.toLowerCase()));
    }

    return items;
});

const handleSearch = (search) => {
    searchFilter.value = search;
};

const handleRadioFilter = (filter) => {
    radioFilter.value = filter;
};

const handleCheckboxFilter = (filter) => {
    console.log(filter);
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
