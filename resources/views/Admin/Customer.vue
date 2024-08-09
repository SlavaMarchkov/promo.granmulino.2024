<template>
    <div class="row mb-4">
        <div class="col-12">
            <button class="btn btn-primary" type="button" @click="showNewRegionModal">
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
                            :items="users"
                            selectedOption="fullName"
                        >Менеджер
                        </SelectGroup>
                    </div>
                    <div class="col-md-4 mb-2">
                        <SelectGroup
                            v-model="searchBy.regionId"
                            :chooseFrom="'-- Выберите регион --'"
                            :items="regions"
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
                <button class="btn btn-secondary" type="button" @click="clearSearch">
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
                        <table v-if="customers.length > 0"
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
                            <tr v-for="customer in customers" :key="customer.id">
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
                                        @click="showViewCustomerModal(customer.id)"
                                    ><i class="bi bi-eye-fill"></i>
                                        View
                                    </button>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-warning"
                                        @click="showEditCustomerModal(customer.id)"
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
                    <p>Всего записей: <span class="fw-bold">{{ customers.length }}</span></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref, watch } from 'vue';
import { useCustomerStore } from '@/stores/customers.js';
import { useUserStore } from '@/stores/users.js';
import { useRegionStore } from '@/stores/regions.js';
import { arrFilter, arrSort } from '@/helpers/arrHandlers.js';
import { resetSearchKeys } from '@/helpers/searchHandlers.js';
import ThSort from '@/components/core/ThSort.vue';
import Button from '@/components/core/Button.vue';
import Badge from '@/components/core/Badge.vue';
import InputGroup from '@/components/core/InputGroup.vue';
import SelectGroup from '@/components/core/SelectGroup.vue';
import CheckboxGroup from '@/components/core/CheckboxGroup.vue';

const customerStore = useCustomerStore();
const userStore = useUserStore();
const regionStore = useRegionStore();

const customers = ref([]);
const users = ref([]);
const regions = ref([]);

const searchBy = reactive({
    name: '',
    userId: '',
    regionId: '',
    city: '',
    isActive: false,
});

let orderColumn = 'id';
let orderDirection = 'asc';

onMounted(async () => {
    await getCustomers();
    await getUsers();
    await getRegions();
});

const getCustomers = async () => {
    await customerStore.all();
    applyFilterSort();
};

const getUsers = async () => {
    const response = await userStore.all(true);
    users.value = response.data;
};

const getRegions = async () => {
    const response = await regionStore.all();
    regions.value = response.data;
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

    customers.value = tempArr;
};
</script>
