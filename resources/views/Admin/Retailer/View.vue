<template>
    <RouterLink
        :to="{ name: 'Retailer.Index' }"
        class="fw-bold"
        role="button"
    ><i class="bi bi-arrow-bar-left me-2"></i>Обратно на Торговые сети
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
                            <th>Название</th>
                            <td>{{ item.name }}</td>
                        </tr>
                        <tr>
                            <th>Контрагент</th>
                            <td>
                                <RouterLink :to="{ name: 'Customer.View', params: { id: item.customerId } }">
                                    {{ item.customer }}
                                </RouterLink>
                            </td>
                        </tr>
                        <tr>
                            <th>Город</th>
                            <td>{{ item.city }}</td>
                        </tr>
                        <tr>
                            <th>Прямой контракт?</th>
                            <td><TheBadge :is-active="item.isDirect" /></td>
                        </tr>
                        <tr>
                            <th>Активна?</th>
                            <td><TheBadge :is-active="item.isActive" /></td>
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
                <div class="card-header">Описание торговой сети</div>
                <div class="card-body pt-3">
                    {{ item.description }}
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
import Alert from '@/components/Alert.vue';
import TheBadge from '@/components/core/TheBadge.vue';
import { ADMIN_URLS } from '@/helpers/constants.js';
import TheButton from '@/components/core/TheButton.vue';

const route = useRoute();
const router = useRouter();

const { get } = useHttpService();
const id = +route.params.id;

const item = ref({});

onMounted(async () => {
    await fetchDetails(id);
})

const fetchDetails = async (id) => {
    const response = await get(`${ ADMIN_URLS.RETAILER }/${ id }`);
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
    router.push({ name: 'Retailer.View', params: { id: item.value.prev } });
};

const navigateToNextItem = () => {
    router.push({ name: 'Retailer.View', params: { id: item.value.next } });
};
</script>
