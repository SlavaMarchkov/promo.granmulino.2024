<template>
    <Alert/>
    <div v-if="isRegionFound" class="row">
        <div class="col-12">
            <pre>
                {{ region }}
            </pre>
            <hr>
            <RouterLink
                :to="{ name: 'Region.Index' }"
                class="btn btn-secondary my-2"
                role="button"
            >Обратно на Регионы
            </RouterLink>
        </div>
    </div>
    <PageNotFound v-else></PageNotFound>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { useRegionStore } from '@/stores/regions.js';
import PageNotFound from './PageNotFound.vue';
import Alert from '@/components/Alert.vue';

const route = useRoute();

const regionStore = useRegionStore();
const id = +route.params.id;

const region = ref({});

onMounted(async () => {
    const response = await regionStore.one(id);
    if ( response !== 404 ) region.value = response.data;
});

const isRegionFound = computed(() => {
    return typeof region.value !== 'undefined';
});
</script>
