<template>
    <RouterLink
        :to="{ name: 'Product.Index' }"
        class="fw-bold"
        role="button"
    ><i class="bi bi-arrow-bar-left me-2"></i>Обратно на Ассортимент
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
                            <th style="width: 27%;">ID</th>
                            <td>{{ item.id }}</td>
                        </tr>
                        <tr>
                            <th>Название</th>
                            <td>{{ item.name }}</td>
                        </tr>
                        <tr v-if="isPriceAdmin">
                            <th>Себестоимость, руб.</th>
                            <td>{{ item.price }}</td>
                        </tr>
                        <tr>
                            <th>Вес пачки</th>
                            <td class="p-0">
                                <table class="table text-center align-middle table-borderless m-0">
                                    <thead>
                                    <tr class="border-bottom">
                                        <th class="border-end" style="width: 33.3333%;">Вес, г</th>
                                        <th class="border-end" style="width: 33.3333%;">Вес нетто, кг</th>
                                        <th style="width: 33.3333%;">Вес брутто, кг</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="border-end">{{ formatNumber(item.weight) }}</td>
                                        <td class="border-end">{{ formatNumberWithFractions(item.weight / 1_000) }}</td>
                                        <td>{{ item.grossWeight }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <th>Коды</th>
                            <td class="p-0">
                                <table class="table text-center align-middle table-borderless m-0">
                                    <thead>
                                    <tr class="border-bottom">
                                        <th class="border-end" style="width: 33.3333%;">Код продукта из 1С</th>
                                        <th class="border-end" style="width: 33.3333%;">Штрих-код короба</th>
                                        <th style="width: 33.3333%;">Штрих-код пачки</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="border-end">{{ item.code }}</td>
                                        <td class="border-end">{{ item.barcodeBox }}</td>
                                        <td>{{ item.barcode }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <th>Гофрокороб</th>
                            <td class="p-0">
                                <table class="table text-center align-middle table-borderless m-0">
                                    <thead>
                                    <tr class="border-bottom">
                                        <th class="border-end" style="width: 33.3333%;">Кол-во единиц<br>в г/к, шт.</th>
                                        <th class="border-end" style="width: 33.3333%;">Вес г/к нетто,<br>кг</th>
                                        <th style="width: 33.3333%;">Кол-во г/к<br>в одном слое, шт.</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="border-end">{{ item.capacity }}</td>
                                        <td class="border-end">{{ item.boxWeight }}</td>
                                        <td>{{ item.boxesInLayer }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <th>Группа товаров</th>
                            <td>
                                <RouterLink
                                    :to="{ name: 'Category.View', params: { id: item.categoryId } }"
                                >
                                    {{ item.categoryName }}
                                </RouterLink>
                            </td>
                        </tr>
                        <tr>
                            <th>Размеры упаковки</th>
                            <td class="p-0">
                                <table class="table text-center align-middle table-borderless m-0">
                                    <thead>
                                    <tr class="border-bottom">
                                        <th class="border-end">Ширина, см</th>
                                        <th class="border-end">Глубина, см</th>
                                        <th class="border-end">Высота, см</th>
                                        <th>Объём, см<sup>3</sup></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="border-end">{{ formatNumberWithFractions(item.width) }}</td>
                                        <td class="border-end">{{ formatNumberWithFractions(item.depth) }}</td>
                                        <td class="border-end">{{ formatNumberWithFractions(item.height) }}</td>
                                        <td>{{ formatNumberWithFractions(item.packSize) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <th>Размеры гофрокороба</th>
                            <td class="p-0">
                                <table class="table text-center align-middle table-borderless m-0">
                                    <thead>
                                    <tr class="border-bottom">
                                        <th class="border-end">Ширина, см</th>
                                        <th class="border-end">Глубина, см</th>
                                        <th class="border-end">Высота, см</th>
                                        <th>Объём, см<sup>3</sup></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="border-end">{{ formatNumberWithFractions(item.widthBox) }}</td>
                                        <td class="border-end">{{ formatNumberWithFractions(item.depthBox) }}</td>
                                        <td class="border-end">{{ formatNumberWithFractions(item.heightBox) }}</td>
                                        <td>{{ formatNumberWithFractions(item.boxSize) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <th>В продаже?</th>
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
            <div class="card">
                <div class="card-header">Загрузка изображений</div>
                <div class="card-body">
                    <Alert />
                    <div ref="dropzoneRef" class="mb-3 upload">
                        <div class="dz-message">Бросай сюда файлы как будто они горячие!</div>
                    </div>
                    <TheButton
                        @click="saveImages"
                        class="w-25 btn-primary"

                    >Сохранить</TheButton>
<!--                    :disabled="imagesToUpload.length === 0 || spinnerStore.isButtonDisabled"
                    :loading="spinnerStore.isButtonDisabled"-->
                    <pre>{{ imagesToUpload }}</pre>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">Изображения продукта</div>
                <div class="card-body text-center pt-3">
                    <img
                        :src="productImage"
                        :alt="item.name"
                        class="img-thumbnail img-fluid"
                    />
                </div>
            </div>
        </div>
    </div>
    <Alert v-else class="mt-3"/>
</template>

<script setup>
import { computed, onMounted, reactive, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHttpService } from '@/use/useHttpService.js';
import { useCookies } from '@/use/useCookies.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import Alert from '@/components/Alert.vue';
import { ADMIN_URLS, IMAGES, ROLES } from '@/helpers/constants.js';
import TheButton from '@/components/core/TheButton.vue';
import { formatNumber, formatNumberWithFractions } from '@/helpers/formatters.js';
import TheBadge from '@/components/core/TheBadge.vue';
import { useAuthStore } from '@/stores/auth.js';
import { Dropzone } from 'dropzone';

const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();
const spinnerStore = useSpinnerStore();
const cookies = useCookies();

const { get, post } = useHttpService();
const id = +route.params.id;

const role = authStore.getUser.role;
const token = authStore.getToken;
const isPriceAdmin = computed(() => role === ROLES.PRICE_ADMIN);

const item = ref({});
const dropzoneRef = ref(null);
let dropzone = reactive({});
const imagesToUpload = ref([]);

onMounted(async () => {
    await fetchDetails(id);
    dropzone = new Dropzone(dropzoneRef.value, {
        url: 'image-upload',
        autoProcessQueue: true,
        withCredentials: true,
        maxFilesize: 4,
        maxFiles: 5,
        addRemoveLinks: true,
        acceptedFiles: '.jpg, .jpeg, .png',
        dictFileTooBig: 'Максимальный размер файла 4Мб',
        dictMaxFilesExceeded: 'Превышено кол-во загружаемых файлов (не более 5 файлов)',
        dictInvalidFileType: 'Допускается загружать только картинки в форматах JPG и PNG',
        dictRemoveFile: 'Удалить',
        headers: {
            'x-xsrf-token': cookies.getCookie('XSRF-TOKEN'),
            'Authorization': `Bearer ${ token }`,
        },
    });
    dropzone.on('addedfile', (file) => {
        imagesToUpload.value.push(file.upload.uuid);
    });
    dropzone.on('removedfile', (file) => {
        const idx = imagesToUpload.value.findIndex(f => f === file.upload.uuid);
        imagesToUpload.value.splice(idx, 1);
    });
});

const fetchDetails = async (id) => {
    const response = await get(`${ ADMIN_URLS.PRODUCT }/${ id }`);
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

const productImage = computed(() => item.value.image
    ? `${ IMAGES.PRODUCT_IMG_PATH }${ item.value.image }` : [IMAGES.DEFAULT_IMG]);

const navigateToPreviousItem = () => {
    router.push({ name: 'Product.View', params: { id: item.value.prev } });
};

const navigateToNextItem = () => {
    router.push({ name: 'Product.View', params: { id: item.value.next } });
};

const saveImages = async () => {
    const formData = new FormData();
    const files = dropzone.getAcceptedFiles();
    files.forEach(file => {
        formData.append('images[]', file);
        dropzone.removeFile(file);
    });
    formData.append('product_id', id);
    imagesToUpload.value = [];
    const response = await post(`${ IMAGES.PRODUCT_IMAGE_URL }/${ id }`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
    });
    if ( response && response.status === 'success' ) {
        console.log(response.data.images);
        //user.images = response.data.images;
    }
};
</script>

<style>
@import url('/resources/css/upload.css');
</style>
