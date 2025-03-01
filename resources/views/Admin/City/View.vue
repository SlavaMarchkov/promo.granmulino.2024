<template>
    <RouterLink
        :to="{ name: 'City.Index' }"
        class="fw-bold"
        role="button"
    ><i class="bi bi-arrow-bar-left me-2"></i>Обратно на Города
    </RouterLink>
    <hr>
    <div v-if="isItemFound" class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ item.name }}</h5>
                </div>
                <div class="card-body pt-3">
                    <table class="table table-bordered mb-0 align-middle text-wrap"
                           style="width: 100%;">
                        <tbody>
                        <tr>
                            <th style="width: 30%;">ID</th>
                            <td>{{ item.id }}</td>
                        </tr>
                        <tr>
                            <th>Город</th>
                            <td>{{ item.name }}</td>
                        </tr>
                        <tr>
                            <th>Регион</th>
                            <td>
                                <RouterLink :to="{
                                        name: 'Region.View',
                                        params: {
                                            'id': item.regionId
                                        },
                                    }">{{ item.regionName }}
                                </RouterLink>
                            </td>
                        </tr>
                        <tr>
                            <th>Широта</th>
                            <td>{{ item.latitude }}</td>
                        </tr>
                        <tr>
                            <th>Долгота</th>
                            <td>{{ item.longitude }}</td>
                        </tr><tr>
                            <th>Страна</th>
                            <td>{{ item.country }}</td>
                        </tr><tr>
                            <th>Локация (EN)</th>
                            <td>{{ item.state }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <TheButton
                        @click="navigateToPreviousItem"
                        class="btn-outline-secondary"
                        :disabled="item.prev === null"
                    >Пред.</TheButton>
                    <TheButton
                        @click="navigateToNextItem"
                        class="btn-outline-secondary mx-2"
                        :disabled="item.next === null"
                    >След.</TheButton>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">Торговые сети в городе</div>
                <div class="card-body pt-3">
                    <table
                        v-if="item.retailers.length > 0"
                        class="table table-bordered mb-0 align-middle text-nowrap"
                    >
                        <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 10%;">#</th>
                            <th style="width: 50%;">Название</th>
                            <th style="width: 25%;">Тип</th>
                            <th style="width: 15%;">Активна?</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="(retailer, index) in arrayHandlers.sortArrayByStringColumn(item.retailers, 'name')"
                            :key="retailer.id"
                        >
                            <td class="text-center">{{ index + 1 }}</td>
                            <td>
                                <RouterLink :to="{ name: 'Retailer.View', params: { id: retailer.id } }">
                                    {{ retailer.name }}
                                </RouterLink>
                            </td>
                            <td><span
                                :class="['badge', retailer.typeBgColor]"
                                :title="retailer.typeDescription"
                            >{{ retailer.label }}</span></td>
                            <td><TheBadge :is-active="retailer.isActive"/></td>
                        </tr>
                        </tbody>
                    </table>
                    <p v-else class="lead mb-0">В городе нет торговых сетей.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Контрагенты в городе</div>
                <div class="card-body pt-3">
                    <table
                        v-if="item.customers.length > 0"
                        class="table table-bordered mb-0 align-middle text-nowrap"
                    >
                        <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 10%;">#</th>
                            <th style="width: 50%;">Название</th>
                            <th style="width: 40%;">Активен?</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="(customer, index) in arrayHandlers.sortArrayByStringColumn(item.customers, 'name')"
                            :key="customer.id"
                        >
                            <td class="text-center">{{ index + 1 }}</td>
                            <td>
                                <RouterLink :to="{ name: 'Customer.View', params: { id: customer.id } }">
                                    {{ customer.name }}
                                </RouterLink>
                            </td>
                            <td><TheBadge :is-active="customer.isActive"/></td>
                        </tr>
                        </tbody>
                    </table>
                    <p v-else class="lead mb-0">В городе нет контрагентов.</p>
                </div>
            </div>
        </div>
    </div>
    <Alert v-else class="mt-3"/>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHttpService } from '@/use/useHttpService.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import Alert from '@/components/Alert.vue';
import { ADMIN_URLS } from '@/helpers/constants.js';
import TheBadge from '@/components/core/TheBadge.vue';
import TheButton from '@/components/core/TheButton.vue';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';

// TODO - реализовать кнопки подсчета расстояний между этим городом и выбранным другим (или другими)
// https://www.myprogrammingtutorials.com/find-distance-between-two-addresses-google-api-php.html

const route = useRoute();
const router = useRouter();
const spinnerStore = useSpinnerStore();
const arrayHandlers = useArrayHandlers();

const { get } = useHttpService();
const id = +route.params.id;

const item = ref({});

onMounted(async () => {
    await fetchDetails(id);
})

const fetchDetails = async (id) => {
    const response = await get(`${ ADMIN_URLS.CITY }/${ id }`);
    if ( response.status === 'success' ) item.value = response.data;
};

watch(
    () => route.params.id,
    () => {
        fetchDetails(route.params.id);
    },
);

const isItemFound = computed(() => {
    return Object.keys(item.value).length !== 0;
});

const navigateToPreviousItem = () => {
    router.push({ name: 'City.View', params: { id: item.value.prev } });
};

const navigateToNextItem = () => {
    router.push({ name: 'City.View', params: { id: item.value.next } });
};
</script>
