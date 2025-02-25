<template>
    <div class="row mb-4">
        <div class="col-6">
            <h3 class="mb-1">{{ $route.meta.title }}</h3>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ user.fullName }}</h3>
                </div>
                <div class="card-body pt-4">
                    <table class="table table-bordered align-middle text-wrap mb-2"
                           style="width: 100%;">
                        <tbody>
                        <tr>
                            <th style="width: 40%;">ID</th>
                            <td>{{ user.id }}</td>
                        </tr>
                        <tr>
                            <th>ФИО</th>
                            <td>{{ `${ user.lastName } ${ user.firstName } ${ user.middleName }` }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ user.email }}</td>
                        </tr>
                        <tr>
                            <th>Роль в системе</th>
                            <td>{{ user.roleName }}</td>
                        </tr>
                        <tr>
                            <th>Работает?</th>
                            <td><TheBadge :is-active="user.isActive" /></td>
                        </tr>
                        <tr>
                            <th>Последний вход в систему</th>
                            <td>{{ user.loggedInAt }}</td>
                        </tr>
                        </tbody>
                    </table>
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
                        :disabled="imagesToUpload.length === 0 || spinnerStore.isButtonDisabled"
                        :loading="spinnerStore.isButtonDisabled"
                    >Сохранить</TheButton>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">Изображения пользователя</div>
                <div class="card-body pt-3">
                    <div id="carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button
                                v-for="(image, index) in user.images"
                                :key="image.id"
                                type="button"
                                data-bs-target="#carousel"
                                :data-bs-slide-to="index"
                                :class="{ active : index === 0 }"
                                :aria-label="`Slide ${ index }`"
                            ></button>
                        </div>
                        <div class="carousel-inner">
                            <div
                                v-for="(image, index) in user.images"
                                :key="image.id"
                                class="carousel-item"
                                :class="{ active : index === 0 }"
                            >
                                <img
                                    :src="`${ IMAGES.USER_IMG_PATH }${ image.file }`"
                                    class="d-block w-100"
                                    alt="User-Image"
                                />
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { Dropzone } from 'dropzone';
import TheButton from '@/components/core/TheButton.vue';
import { useHttpService } from '@/use/useHttpService.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import Alert from '@/components/Alert.vue';
import { IMAGES, MANAGER_URLS } from '@/helpers/constants.js';
import { useAuthStore } from '@/stores/auth.js';
import TheBadge from '@/components/core/TheBadge.vue';

const { getUser: user, getToken: token } = useAuthStore();
const spinnerStore = useSpinnerStore();
const { post } = useHttpService();

/*const initialFormData = () => ({
    images: [],
});

const state = reactive({
    form: initialFormData(),
});*/

const dropzoneRef = ref(null);
let dropzone = reactive({});
const imagesToUpload = ref([]);

onMounted(() => {
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
            'x-xsrf-token': getCookie('XSRF-TOKEN'),
            'Authorization': `Bearer ${token}`,
        },
    });
    dropzone.on('addedfile', (file) => {
        imagesToUpload.value.push(file.upload.uuid);
        console.log(file.upload.uuid);
    });
    dropzone.on('removedfile', (file) => {
        console.log(file.upload.uuid);
        const idx = imagesToUpload.value.findIndex(f => f === file.upload.uuid);
        imagesToUpload.value.splice(idx, 1);
    });
});

const saveImages = async () => {
    const formData = new FormData();
    const files = dropzone.getAcceptedFiles();
    files.forEach(file => {
        formData.append('images[]', file);
        dropzone.removeFile(file);
    });
    formData.append('user_id', user.id);
    imagesToUpload.value = [];
    const response = await post(MANAGER_URLS.USER, formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
    });
    if ( response && response.status === 'success' ) {
        user.images = response.data.images;
    }
};

function getCookie(name) {
    const matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([.$?*|{}()\[\]\\/+^])/g, '\\$1') + "=([^;]*)"));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
</script>

<style>
@import url('/resources/css/upload.css');
</style>
