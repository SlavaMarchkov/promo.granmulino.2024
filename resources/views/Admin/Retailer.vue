<template>
    <div class="row mb-4">
        <div class="col-12">
            <button class="btn btn-primary" type="button" @click="createRetailerInit">
                Новая торговая сеть
            </button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <Filter @reset-filter="clearSearch">
                <div class="col-md-4 mb-2">
                    <InputGroup v-model="searchBy.name" placeholder="Поиск по названию ТС">Название
                    </InputGroup>
                </div>
                <div class="col-md-2 mb-2" v-for="item of retailerTypes" :key="item.id">
                    <RadioButton :id="item.id" :value="item.value" name="retailer-type" v-model="searchBy.type">{{
                            item.title
                        }}
                    </RadioButton>
                </div>
                <div class="col-md-4 mb-2">
                    <InputGroup v-model="searchBy.city" placeholder="Поиск по городу">Город
                    </InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <InputGroup v-model="searchBy.customer" placeholder="Поиск по контрагенту">Контрагент
                    </InputGroup>
                </div>
                <div class="col-md-2 mb-2">
                    <Checkbox id="is_active" v-model="searchBy.isActive">
                        Только активные
                    </Checkbox>
                </div>
                <div class="col-md-2 mb-2">
                    <Checkbox id="is_direct" v-model="searchBy.isDirect">
                        Только прямые
                    </Checkbox>
                </div>
            </Filter>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-0">
                    <div v-if="state.retailers.length > 0" class="table-responsive">
                        <table class="table table-bordered my-4 text-center align-middle text-nowrap"
                               style="width: 100%;">
                            <thead>
                            <tr>
                                <ThSort
                                    :id="'id'"
                                    :order-column="arrayHandlers.orderColumn.value"
                                    :order-direction="arrayHandlers.orderDirection.value"
                                    sort-type="numeric"
                                    @sortByColumn="arrayHandlers.applyFilterSort(
                                        state.retailers,
                                        searchBy,
                                        'id',
                                        arrayHandlers.orderDirection.value === 'asc' ? 'desc' : 'asc',
                                        true,
                                    )"
                                >ID
                                </ThSort>
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
                            <tr v-for="item in state.retailers" :key="item.id">
                                <th scope="row">{{ item.id }}</th>
                                <td class="text-start">
                                    {{ item.name }}
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
                                <td>
                                    <button class="btn btn-sm btn-primary" @click="showViewModal(item.id)"><i
                                        class="bi bi-eye-fill"></i>
                                        View
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" @click="editRetailerInit(item.id)"><i
                                        class="bi bi-pencil-square"></i>
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
                    <p>Всего записей: <span class="fw-bold">{{ state.retailers.length }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <Modal id="modalPopUp" :close-func="closeModal" :custom-classes="['']">
        <template #title>
            <span v-if="state.isEditing">Редактирование торговой сети <br>«<b>{{ state.retailer.name }}</b>»</span>
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
            <Button :class="state.isEditing ? 'btn-warning' : 'btn-primary'" :disabled="retailerStore.isButtonDisabled"
                    :loading="retailerStore.isButtonDisabled" class="w-25" type="button" @click="saveRetailer">
                <span v-if="state.isEditing">Сохранить</span>
                <span v-else>Создать</span>
            </Button>
        </template>
    </Modal>
</template>

<script setup>
import { onMounted, reactive, watch } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useRetailerStore } from '@/stores/retailers.js';
import { useCustomerStore } from '@/stores/customers.js';
import { useCityStore } from '@/stores/cities.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import Button from '@/components/core/Button.vue';
import Badge from '@/components/core/Badge.vue';
import Checkbox from '@/components/core/Checkbox.vue';
import Modal from '@/components/Modal.vue';
import Input from '@/components/core/Input.vue';
import Label from '@/components/core/Label.vue';
import Alert from '@/components/Alert.vue';
import Filter from '@/components/core/Filter.vue';
import InputGroup from '@/components/core/InputGroup.vue';
import RadioButton from '@/components/core/RadioButton.vue';
import ThSort from '@/components/core/ThSort.vue';

const retailerStore = useRetailerStore();
const customerStore = useCustomerStore();
const cityStore = useCityStore();
const alertStore = useAlertStore();
const arrayHandlers = useArrayHandlers();

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

const searchBy = reactive({
    name: '',
    city: '',
    customer: '',
    type: '',
    isActive: false,
    isDirect: false,
});



let modalPopUp = null;

onMounted(async () => {
    await getRetailers();
    await getCustomers();
    await getCities();

    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', () => {
        state.isEditing = false;
        state.retailer = initialFormData();
    });
});

const getRetailers = async () => {
    const { data } = await retailerStore.all();
    // state.retailers = arrayHandlers.filterArray(data.data, searchBy);
    state.retailers = arrayHandlers.applyFilterSort(data.data, searchBy);
    //arrayHandlers.filterArray(data.data, searchBy);
};

const getCustomers = async () => {
    const response = await customerStore.all();
    state.customers = response.data;
};

const getCities = async () => {
    const response = await cityStore.all();
    state.cities = response.data;
};

const createRetailerInit = () => {
    alertStore.clear();
    state.isEditing = false;
    modalPopUp.show();
};

const editRetailerInit = (id) => {
    alertStore.clear();
    state.isEditing = true;
    modalPopUp.show();
    state.retailer = retailerStore.getRetailers.find(item => item.id === id);
};

const closeModal = () => {
    modalPopUp.hide();
};

watch(searchBy, () => {
    state.retailers = arrayHandlers.filterArray(
        retailerStore.getRetailers,
        searchBy,
    );
});

const clearSearch = () => {
    arrayHandlers.resetSearchKeys(searchBy);
    /* applyFilterSort(
        (orderColumn.value = 'id'),
        (orderDirection.value = 'asc'),
    ); */
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
            arrayHandlers.resetSearchKeys(searchBy);
            orderColumn.value = 'id';
            orderDirection.value = 'desc';
            await getRetailers();
        }
    }
};


</script>
