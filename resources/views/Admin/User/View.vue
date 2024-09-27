<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <template v-if="spinnerStore.isLoading">
                        <h4 class="my-4">Загрузка...</h4>
                        <table class="table table-bordered mb-4 align-middle text-wrap"
                               style="width: 100%;">
                            <tbody>
                            <tr>
                                <th style="width: 20%;">ID</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Фамилия</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Имя</th>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </template>
                    <template v-else>
                        <div v-if="isItemFound">
                            <h4 class="my-4">{{ item.name }}</h4>
                            <table class="table table-bordered mb-4 align-middle text-wrap"
                                   style="width: 100%;">
                                <tbody>
                                <tr>
                                    <th style="width: 20%;">ID</th>
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
                                </tbody>
                            </table>
                        </div>
                        <Alert v-else class="mt-3"/>
                    </template>
                    <hr>
                    <RouterLink
                        :to="{ name: 'User.Index' }"
                        class="btn btn-secondary my-2"
                        role="button"
                    >Обратно на Пользователи
                    </RouterLink>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHttpService } from '@/use/useHttpService.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import Alert from '@/components/Alert.vue';
import { ADMIN_URLS } from '@/helpers/constants.js';

const route = useRoute();
const router = useRouter();
const spinnerStore = useSpinnerStore();

const { get } = useHttpService();
const id = +route.params.id;

const item = ref({});

onMounted(async () => {
    await fetchDetails(id);
})

const fetchDetails = async (id) => {
    const response = await get(`${ ADMIN_URLS.USER }/${ id }`);
    if ( response.status === 'success' ) item.value = response.data;
};

const isItemFound = computed(() => {
    return Object.keys(item.value).length !== 0;
});
</script>
