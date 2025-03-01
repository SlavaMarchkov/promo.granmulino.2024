<template>
    <RouterLink
        :to="{ name: 'User.Index' }"
        class="fw-bold"
        role="button"
    ><i class="bi bi-arrow-bar-left me-2"></i>Обратно на Пользователи
    </RouterLink>
    <hr>
    <div v-if="isItemFound" class="row">
        <div class="col-xl-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ item.fullName }}</h5>
                </div>
                <div class="card-body pt-3">
                    <table class="table table-bordered mb-0 align-middle text-wrap"
                           style="width: 100%;">
                        <tbody>
                        <tr>
                            <th style="width: 40%;">ID</th>
                            <td>{{ item.id }}</td>
                        </tr>
                        <tr>
                            <th>Фамилия</th>
                            <td>{{ item.lastName }}</td>
                        </tr>
                        <tr>
                            <th>Имя</th>
                            <td>{{ item.firstName }}</td>
                        </tr>
                        <tr>
                            <th>Отчество</th>
                            <td>{{ item.middleName }}</td>
                        </tr>
                        <tr>
                            <th>Системное имя</th>
                            <td>{{ item.fullName }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ item.email }}</td>
                        </tr>
                        <tr>
                            <th>Работает?</th>
                            <td><TheBadge :is-active="item.isActive" /></td>
                        </tr>
                        <tr>
                            <th>Админ?</th>
                            <td><TheBadge :is-active="item.isAdmin" /></td>
                        </tr>
                        <tr>
                            <th>Последний вход</th>
                            <td>{{ item.loggedInAt }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="card">
                <div class="card-header">Контрагенты с привязкой к менеджеру</div>
                <div class="card-body pt-3">
                    <table
                        v-if="customers.length > 0"
                        class="table table-bordered mb-0 align-middle text-nowrap"
                    >
                        <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 5%;">#</th>
                            <th style="width: 30%;">Контрагент</th>
                            <th style="width: 10%;">Активен?</th>
                            <th style="width: 55%;">Торговые сети</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="(customer, index) in customers"
                            :key="customer.id"
                        >
                            <td class="text-center">{{ index + 1 }}</td>
                            <td>
                                <RouterLink :to="{ name: 'Customer.View', params: { id: customer.id } }">
                                    {{ customer.name }}
                                </RouterLink>
                            </td>
                            <td><TheBadge :is-active="customer.isActive"/></td>
                            <td class="p-0">
                                <table class="table table-borderless w-100 mb-0 retailer-nested">
                                    <tbody>
                                    <tr
                                        v-for="(retailer, idx) in customer.retailers"
                                        :key="retailer.id"
                                        class="border border-top-0 border-start-0 border-end-0"
                                    >
                                        <td class="text-center" style="width: 10%;">{{ index + 1 }}.{{ idx + 1 }}</td>
                                        <td class="border border-top-0 border-bottom-0 border-start-1 border-end-1" style="width: 50%;">
                                            <RouterLink :to="{ name: 'Retailer.View', params: { id: retailer.id } }">
                                                {{ retailer.name }}
                                            </RouterLink>
                                        </td>
                                        <td style="width: 40%;"><TheBadge :is-active="retailer.isActive"/></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <p v-else class="lead mb-0">Менеджер по продажам не имеет контрагентов.</p>
                </div>
            </div>
        </div>
    </div>
    <Alert v-else class="mt-3"/>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHttpService } from '@/use/useHttpService.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import Alert from '@/components/Alert.vue';
import { ADMIN_URLS } from '@/helpers/constants.js';
import TheBadge from '@/components/core/TheBadge.vue';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';

const route = useRoute();
const router = useRouter();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();

const { get } = useHttpService();
const id = +route.params.id;

const item = ref({});

onMounted(async () => {
    await fetchDetails(id);
});

const fetchDetails = async (id) => {
    const response = await get(`${ ADMIN_URLS.USER }/${ id }`);
    if ( response.status === 'success' ) item.value = response.data;
};

const isItemFound = computed(() => {
    return Object.keys(item.value).length !== 0;
});

const customers = computed(() => {
    const tempArr = item.value.customers.map((customer => {
        customer.retailers = [];
        item.value.retailers.forEach(retailer => {
            if ( retailer.customerId === customer.id ) {
                customer.retailers.push(retailer);
            }
        });
        customer.retailers = arrayHandlers.sortArrayByStringColumn(customer.retailers, 'name');
        return customer;
    }));
    return arrayHandlers.sortArrayByStringColumn(tempArr, 'name');
});
</script>
