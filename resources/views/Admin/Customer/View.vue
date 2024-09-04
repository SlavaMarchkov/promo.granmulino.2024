<template>
    <div class="row">
        <div v-if="isCustomerFound" class="col-12">
            <table class="table table-bordered mt-3 align-middle text-wrap"
                   style="width: 100%;">
                <tbody>
                <tr>
                    <th style="width: 20%;">ID</th>
                    <td>{{ customer.id }}</td>
                </tr>
                <tr>
                    <th>Название</th>
                    <td>{{ customer.name }}</td>
                </tr>
                <tr>
                    <th>Регион</th>
                    <td>{{ customer.region }}</td>
                </tr>
                <tr>
                    <th>Город</th>
                    <td>{{ customer.city }}</td>
                </tr>
                <tr>
                    <th>Менеджер</th>
                    <td>{{ customer.user }}</td>
                </tr>
                <tr>
                    <th>Активен?</th>
                    <td><Badge :is-active="customer.isActive" /></td>
                </tr>
                <tr>
                    <th>Описание</th>
                    <td>{{ customer.description }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <Alert v-else />
        <hr>
        <div class="col-12">
            <RouterLink
                :to="{ name: 'Customer.Index' }"
                class="btn btn-secondary my-2"
                role="button"
            >Обратно на Контрагенты
            </RouterLink>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { useHttpService } from '@/use/useHttpService.js';
import Alert from "@/components/Alert.vue";
import Badge from "@/components/core/Badge.vue";

const route = useRoute();

const customerURL = '/customers';

const { get } = useHttpService();
const id = +route.params.id;

const customer = ref({});

onMounted(async () => {
    const response = await get(`${ customerURL }/${ id }`);
    if ( response.status === 'success' ) customer.value = response.data;
});

const isCustomerFound = computed(() => {
    return Object.keys(customer.value).length !== 0;
});
</script>
