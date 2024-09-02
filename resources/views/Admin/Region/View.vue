<template>
    <div class="row">
        <div v-if="isRegionFound" class="col-12">
            <pre>
                {{ region }}
            </pre>
        </div>
        <Alert v-else />
        <hr>
        <div class="col-12">
            <RouterLink
                :to="{ name: 'Region.Index' }"
                class="btn btn-secondary my-2"
                role="button"
            >Обратно на Регионы
            </RouterLink>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { useHttpService } from '@/use/useHttpService.js';
import Alert from "@/components/Alert.vue";

const route = useRoute();

const regionURL = '/admin/regions';

const { get } = useHttpService();
const id = +route.params.id;

const region = ref({});

onMounted(async () => {
    const response = await get(`${ regionURL }/${ id }`);
    if ( response.status === 'success' ) region.value = response.data;
});

const isRegionFound = computed(() => {
    return Object.keys(region.value).length !== 0;
});
</script>
