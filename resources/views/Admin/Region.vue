<template>
    <div class="row mb-4">
        <div class="col-md-6">
            <button class="btn btn-primary" type="button" @click="showNewRegionModal">
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
                <span @click="clearSearch()" class="input-group-text" style="cursor: pointer;"><i
                    class="bi bi-x-lg"></i></span>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-0">
                    <table v-if="regions.length > 0" class="table table-bordered my-4 text-center align-middle">
                        <thead>
                        <tr>
                            <ThSort
                                :id="'id'"
                                sort-type="numeric"
                                :order-column="orderColumn"
                                :order-direction="orderDirection"
                                :width='5'
                                @sortByColumn="updateSorting('id')"
                            >ID
                            </ThSort>
                            <ThSort
                                :id="'name'"
                                sort-type="alpha"
                                :order-column="orderColumn"
                                :order-direction="orderDirection"
                                class="text-start"
                                @sortByColumn="updateSorting('name')"
                            >Название региона
                            </ThSort>
                            <ThSort
                                :id="'code'"
                                sort-type="alpha"
                                :order-column="orderColumn"
                                :order-direction="orderDirection"
                                :width='10'
                                @sortByColumn="updateSorting('code')"
                            >Код
                            </ThSort>
                            <th scope="col" style="width: 10%;">Просмотр</th>
                            <th scope="col" style="width: 10%;">Ред.</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="region in regions" :key="region.id">
                            <th scope="row">{{ region.id }}</th>
                            <td class="text-start" style="cursor: pointer;" @click="showViewRegionModal(region.id)">
                                {{ region.name }}
                            </td>
                            <td>
                                {{ region.code }}
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm btn-primary"
                                    @click="showViewRegionModal(region.id)"
                                ><i class="bi bi-eye-fill"></i>
                                    View
                                </button>
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm btn-warning"
                                    @click="showEditRegionModal(region.id)"
                                ><i class="bi bi-pencil-square"></i>
                                    Edit
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <p v-else class="mt-3 text-center lead">
                        {{ regionStore.isContentLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- New Region Modal Start -->
    <div id="newRegion" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">
            <form @submit.prevent="saveRegion">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Добавление региона</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <Alert/>
                        <div class="row g-3">
                            <div class="col-12">
                                <Label for="code" required>Код региона</Label>
                                <Input
                                    v-model="form.code"
                                    type="text"
                                    id="code"
                                    placeholder="Например: УФО"
                                />
                            </div>
                            <div class="col-12">
                                <Label for="name" required>Наименование региона</Label>
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
                            :loading="regionStore.isButtonDisabled"
                            :disabled="regionStore.isButtonDisabled"
                            class="w-25"
                        >Сохранить
                        </Button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- New Region Modal End -->

    <!-- Edit Region Modal Start -->
    <div id="editRegion" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">
            <form @submit.prevent="updateRegion(region)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактирование региона</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <Alert/>
                        <Spinner v-if="regionStore.isCardLoading"/>
                        <div v-else class="row g-3">
                            <div class="col-12">
                                <Label for="edit-code" required>Код региона</Label>
                                <Input
                                    v-model="region.code"
                                    type="text"
                                    id="edit-code"
                                    placeholder="Например: УФО"
                                />
                            </div>
                            <div class="col-12">
                                <Label for="edit-name" required>Название региона</Label>
                                <Input
                                    v-model="region.name"
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
                            :loading="regionStore.isButtonDisabled"
                            :disabled="regionStore.isButtonDisabled"
                            class="w-25"
                        >Сохранить
                        </Button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Edit Region Modal End -->
</template>

<script setup>
import Input from '@/components/core/Input.vue';
import Label from '@/components/core/Label.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import { onMounted, ref, watch } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useRegionStore } from '@/stores/regions.js';
import Swal from 'sweetalert2';
import ThSort from '@/components/core/ThSort.vue';
import Spinner from '@/components/core/Spinner.vue';

const regionStore = useRegionStore();
const alertStore = useAlertStore();

const initialFormData = () => ({
    code: '',
    name: '',
});

const form = ref(initialFormData());
const regions = ref([]);
const region = ref({});

const searchName = ref('');
const orderColumn = ref('id');
const orderDirection = ref('desc');

let newRegionModal = ref(null);
let viewRegionModal = ref(null);
let editRegionModal = ref(null);

onMounted(async () => {
    await getRegions();
});

const getRegions = async (order_column = 'id', order_direction = 'desc') => {
    const response = await regionStore.all(order_column, order_direction);
    regions.value = response.data;
};

const getRegion = async (id) => {
    const response = await regionStore.one(id);
    region.value = response.data;
};

const showNewRegionModal = () => {
    alertStore.clear();
    newRegionModal = new bootstrap.Modal(document.getElementById('newRegion'));
    newRegionModal.show();
};

const showEditRegionModal = async (id) => {
    alertStore.clear();
    editRegionModal = new bootstrap.Modal(document.getElementById('editRegion'));
    editRegionModal.show();
    await getRegion(id);
};

const saveRegion = async () => {
    const response = await regionStore.save(form.value);
    if ( response && response.status === 201 ) {
        form.value = initialFormData();
        alertStore.clear();
        newRegionModal.hide();
        await Swal.fire({
            icon: response.data.status,
            title: 'Well done!',
            text: response.data.message,
        });
        searchName.value = '';
        orderColumn.value = 'id';
        orderDirection.value = 'desc';
        await getRegions();
    }
};

const updateRegion = async (region) => {
    const response = await regionStore.update(region);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        editRegionModal.hide();
        await getRegions(orderColumn.value, orderDirection.value);
        updateSorting(orderColumn.value);
    }
};

const deleteRegion = (id) => {
    const regionName = regionStore.getRegions
        .filter(s => s.id === id)
        .map(s => s.name);

    Swal.fire({
        title: 'Вы уверены?',
        text: `Удаляемый регион: ${regionName}`,
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
            searchName.value = '';
            orderColumn.value = 'id';
            orderDirection.value = 'desc';
            await getRegions();
        }
    });
};

const clearSearch = async () => {
    searchName.value = '';
    orderColumn.value = 'id';
    orderDirection.value = 'desc';
    await getRegions();
};

watch(searchName, (current) => {
    regions.value = regionStore.getRegions
        .filter(item => item.name.toLowerCase().includes(current.toLowerCase()));
});

const updateSorting = (column) => {
    orderColumn.value = column;
    orderDirection.value = orderDirection.value === 'asc' ? 'desc' : 'asc';

    const tempArr = regionStore.getRegions
        .filter(item => item.name.toLowerCase().includes(searchName.value.toLowerCase()));

    regions.value = tempArr.sort((a, b) => {
        if ( column === 'id' ) {
            return orderDirection.value === 'asc'
                ? a.id - b.id
                : b.id - a.id;
        } else {
            return orderDirection.value === 'asc'
                ? a[column].localeCompare(b[column])
                : b[column].localeCompare(a[column]);
        }
    });
};
</script>
