<template>
    <div class="row">
        <div v-if="isProductFound" class="col-12">
            <pre>
                {{ product }}
            </pre>
        </div>
        <Alert v-else />
        <hr>
        <div class="col-12">
            <RouterLink
                :to="{ name: 'Product.Index' }"
                class="btn btn-secondary my-2"
                role="button"
            >Обратно на Ассортимент
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

const productURL = '/admin/products';

const { get } = useHttpService();
const id = +route.params.id;

const product = ref({});

onMounted(async () => {
    const response = await get(`${ productURL }/${ id }`);
    if ( response.status === 'success' ) product.value = response.data;
});

const isProductFound = computed(() => {
    return Object.keys(product.value).length !== 0;
});
</script>
