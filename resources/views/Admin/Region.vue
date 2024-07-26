<template>
    <div class="row mb-4">
        <div class="col-md-6">
            <button @click="showNewItemModal" type="button" class="btn btn-primary">
                Новый регион
            </button>
        </div>
        <div class="col-md-3 offset-3">
            <div class="input-group">
                <input
                    v-model="searchName"
                    class="form-control"
                    type="text"
                    placeholder="Введите название региона"
                >
                <span @click="searchName = ''" class="input-group-text" style="cursor: pointer;"><i
                    class="bi bi-x-lg"></i></span>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-0">
                    <table v-if="items.data" class="table table-bordered my-4 text-center align-middle">
                        <thead>
                        <tr>
                            <th
                                scope="col"
                                style="width: 60px;"
                                :class="orderColumn === 'id' ? 'table-active' : ''"
                            >
                                <div @click="updateSorting('id')" style="cursor: pointer;">
                                    ID
                                    <i
                                        :class="[
                                            'bi',
                                            {
                                                'bi-sort-numeric-down-alt':
                                                    orderDirection === 'desc' &&
                                                    orderColumn === 'id',
                                                'bi-sort-numeric-up':
                                                    orderDirection !== '' &&
                                                    orderDirection !== 'desc' &&
                                                    orderColumn === 'id',
                                                'bi-three-dots-vertical opacity-25':
                                                    orderColumn !== 'id',
                                            },
                                        ]"
                                    ></i>
                                </div>
                            </th>
                            <th
                                scope="col"
                                class="text-start"
                                :class="orderColumn === 'name' ? 'table-active' : ''"
                            >
                                <div @click="updateSorting('name')" style="cursor: pointer;">
                                    Название региона
                                    <i
                                        :class="[
                                            'bi',
                                            {
                                                'bi-sort-alpha-down-alt':
                                                    orderDirection === 'desc' &&
                                                    orderColumn === 'name',
                                                'bi-sort-alpha-up':
                                                    orderDirection !== '' &&
                                                    orderDirection !== 'desc' &&
                                                    orderColumn === 'name',
                                                'bi-three-dots-vertical opacity-25':
                                                    orderColumn !== 'name',
                                            },
                                        ]"
                                    ></i>
                                </div>
                            </th>
                            <th
                                scope="col"
                                style="width: 120px;"
                                :class="orderColumn === 'code' ? 'table-active' : ''"
                            >
                                <div @click="updateSorting('code')" style="cursor: pointer;">
                                    Код
                                    <i
                                        :class="[
                                            'bi',
                                            {
                                                'bi-sort-up':
                                                    orderDirection === 'desc' &&
                                                    orderColumn === 'code',
                                                'bi-sort-down-alt':
                                                    orderDirection !== '' &&
                                                    orderDirection !== 'desc' &&
                                                    orderColumn === 'code',
                                                'bi-three-dots-vertical opacity-25':
                                                    orderColumn !== 'code',
                                            },
                                        ]"
                                    ></i>
                                </div>
                            </th>
                            <th scope="col" style="width: 100px;">Ред.</th>
                            <th scope="col" style="width: 120px;">Удалить</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in items.data" :key="item.id">
                            <th scope="row">{{ item.id }}</th>
                            <td class="text-start" style="cursor: pointer;" @click="showItemModal(item.id)">
                                {{ item.name }}
                            </td>
                            <td>
                                {{ item.code }}
                            </td>
                            <td>
                                <button
                                    @click="showItemModal(item.id)"
                                    class="btn btn-sm btn-warning"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                    Edit
                                </button>
                            </td>
                            <td>
                                <button
                                    @click="deleteItem(item.id)"
                                    class="btn btn-sm btn-danger"
                                >
                                    <i class="bi bi-trash3"></i>
                                    Delete
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <p v-else class="mt-3 text-center lead">В базе данных нет записей...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- New Service Modal Start -->
    <div class="modal fade" id="newItem" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form @submit.prevent="saveItem">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Добавление региона</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <Alert/>
                        <div class="row g-3">
                            <div class="col-12">
                                <Label for="code">Код региона</Label>
                                <Input
                                    v-model="form.code"
                                    type="text"
                                    id="code"
                                    placeholder="Например: УФО"
                                />
                            </div>
                            <div class="col-12">
                                <Label for="name">Наименование региона</Label>
                                <Input
                                    v-model="form.name"
                                    type="text"
                                    id="name"
                                    placeholder="Например: Уральский федеральный округ"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <Button
                            type="submit"
                            :loading="regionStore.isLoading"
                            :disabled="regionStore.isLoading"
                            class="w-25"
                        >Сохранить
                        </Button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- New Item Modal End -->

    <!-- Show One Item Modal Start -->
    <div class="modal fade" id="showItem" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form @submit.prevent="updateItem(item)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактирование региона</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <Alert/>
                        <div class="row g-3">
                            <div class="col-12">
                                <Label for="edit-code">Код региона</Label>
                                <Input
                                    v-model="item.code"
                                    type="text"
                                    id="edit-code"
                                    placeholder="Например: УФО"
                                />
                            </div>
                            <div class="col-12">
                                <Label for="edit-name">Название региона</Label>
                                <Input
                                    v-model="item.name"
                                    type="text"
                                    id="edit-name"
                                    placeholder="Например: Уральский федеральный округ"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <Button
                            type="submit"
                            :loading="regionStore.isLoading"
                            :disabled="regionStore.isLoading"
                            class="w-25"
                        >Сохранить
                        </Button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Show One Item Modal End -->
</template>

<script setup>
import Input from '@/components/core/Input.vue';
import Label from '@/components/core/Label.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import { onMounted, ref } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useRegionStore } from '@/stores/regions.js';
import Swal from 'sweetalert2';

const regionStore = useRegionStore();
const alertStore = useAlertStore();

const initialFormData = () => ({
    code: '',
    name: '',
});

const form = ref(initialFormData());
const items = ref({});
const item = ref({});
const searchName = ref('');
const orderColumn = ref('id');
const orderDirection = ref('desc');

let newItemModal = ref(null);
let itemModal = ref(null);

onMounted(async () => {
    await getItems();
});

const getItems = async () => {
    items.value = await regionStore.all();
};

const getItem = async (id) => {
    const response = await regionStore.one(id);
    item.value = response.data;
};

const showNewItemModal = () => {
    alertStore.clear();
    newItemModal = new bootstrap.Modal(document.getElementById('newItem'));
    newItemModal.show();
};

const showItemModal = (id) => {
    itemModal = new bootstrap.Modal(document.getElementById('showItem'));
    itemModal.show();
    getItem(id);
};

const saveItem = async () => {
    const response = await regionStore.save(form.value);
    if ( response && response.status === 201 ) {
        form.value = initialFormData();
        alertStore.clear();
        newItemModal.hide();
        await Swal.fire({
            icon: response.data.status,
            title: 'Всё в норме!',
            text: response.data.message,
        });
        await getItems();
    }
};

const updateItem = async (item) => {
    const response = await regionStore.update(item);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        itemModal.hide();
        await getItems();
    }
};

const deleteItem = (id) => {
    const itemName = regionStore.getItems
        .filter(s => s.id === id)
        .map(s => s.name);

    Swal.fire({
        title: 'Вы уверены?',
        text: `Удаляемый регион: ${itemName}`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Да, удалить',
        cancelButtonText: 'Отменить',
        confirmButtonColor: '#ef4444',
        timer: 10_000,
        timerProgressBar: true,
        reverseButtons: true,
    }).then(async (result) => {
        if ( result.isConfirmed ) {
            await regionStore.delete(id);
            await getItems();
        }
    });
};

const updateSorting = (column) => {

};
</script>
