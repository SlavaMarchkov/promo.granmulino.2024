<template>
    <div class="row mb-4">
        <div class="col-12">
            <button class="btn btn-primary me-2" type="button" @click="showNewUserModal">
                Новый пользователь
            </button>
            <button class="btn btn-secondary" type="button" @click="clearSearch">
                Сбросить фильтр
            </button>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mt-4 mb-0 text-center align-middle">
                            <tbody>
                            <tr>
                                <td class="py-1" style="width: 5%;"></td>
                                <td class="py-1" style="width: 15%;">
                                    <div class="input-group">
                                        <input
                                            v-model="searchBy.lastName"
                                            class="form-control"
                                            placeholder="Поиск по фамилии"
                                            type="text"
                                        />
                                        <span class="input-group-text" style="cursor: pointer;"
                                              @click="searchBy.lastName = ''"><i
                                            class="bi bi-x-lg"></i></span>
                                    </div>
                                </td>
                                <td class="py-1" style="width: 15%;">
                                    <div class="input-group">
                                        <input
                                            v-model="searchBy.firstName"
                                            class="form-control"
                                            placeholder="Поиск по имени"
                                            type="text"
                                        />
                                        <span class="input-group-text" style="cursor: pointer;"
                                              @click="searchBy.firstName = ''"><i
                                            class="bi bi-x-lg"></i></span>
                                    </div>
                                </td>
                                <td class="py-1" style="width: 15%;">
                                    <div class="input-group">
                                        <input
                                            v-model="searchBy.middleName"
                                            class="form-control"
                                            placeholder="Поиск по отчеству"
                                            type="text"
                                        />
                                        <span class="input-group-text" style="cursor: pointer;"
                                              @click="searchBy.middleName = ''"><i
                                            class="bi bi-x-lg"></i></span>
                                    </div>
                                </td>
                                <td class="py-1" style="width: 15%;">
                                    <div class="input-group">
                                        <input
                                            v-model="searchBy.email"
                                            class="form-control"
                                            placeholder="Поиск по email"
                                            type="text"
                                        />
                                        <span class="input-group-text" style="cursor: pointer;"
                                              @click="searchBy.email = ''"><i
                                            class="bi bi-x-lg"></i></span>
                                    </div>
                                </td>
                                <td class="py-1" style="width: 15%;">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <input
                                                id="is_active"
                                                v-model="searchBy.isActive"
                                                class="form-check-input mt-0"
                                                type="checkbox"
                                            >
                                        </div>
                                        <label class="form-control text-start" for="is_active">Работает?</label>
                                    </div>
                                </td>
                                <td class="py-1" style="width: 10%;"></td>
                                <td class="py-1" style="width: 10%;"></td>
                            </tr>
                            </tbody>
                        </table>
                        <table v-if="users.length > 0" class="table table-bordered mb-4 text-center align-middle"
                               style="margin-top: -1px;">
                            <thead>
                            <tr>
                                <ThSort
                                    :id="'id'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='5'
                                    sort-type="numeric"
                                    @sortByColumn="applyFilterSort(
                                        'id',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                    )"
                                >ID
                                </ThSort>
                                <ThSort
                                    :id="'lastName'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='15'
                                    class="text-start"
                                    sort-type="alpha"
                                    @sortByColumn="applyFilterSort(
                                        'lastName',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                        false,
                                    )"
                                >Фамилия
                                </ThSort>
                                <ThSort
                                    :id="'firstName'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='15'
                                    class="text-start"
                                    sort-type="alpha"
                                    @sortByColumn="applyFilterSort(
                                        'firstName',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                        false,
                                    )"
                                >Имя
                                </ThSort>
                                <ThSort
                                    :id="'middleName'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='15'
                                    class="text-start"
                                    sort-type="alpha"
                                    @sortByColumn="applyFilterSort(
                                        'middleName',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                        false,
                                    )"
                                >Отчество
                                </ThSort>
                                <ThSort
                                    :id="'email'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='15'
                                    class="text-start"
                                    sort-type="alpha"
                                    @sortByColumn="applyFilterSort(
                                        'email',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                        false,
                                    )"
                                >Email
                                </ThSort>
                                <ThSort
                                    :id="'isActive'"
                                    :order-column="orderColumn"
                                    :order-direction="orderDirection"
                                    :width='15'
                                    @sortByColumn="applyFilterSort(
                                        'isActive',
                                        orderDirection === 'asc' ? 'desc' : 'asc',
                                    )"
                                >Работает?
                                </ThSort>
                                <th scope="col" style="width: 10%;">Просмотр</th>
                                <th scope="col" style="width: 10%;">Ред.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <th scope="row">{{ user.id }}</th>
                                <td class="text-start" style="cursor: pointer;"
                                    @click="showViewUserModal(user.id)">
                                    {{ user.lastName }}
                                </td>
                                <td class="text-start">
                                    {{ user.firstName }}
                                </td>
                                <td class="text-start">
                                    {{ user.middleName }}
                                </td>
                                <td class="text-start">
                                    {{ user.email }}
                                </td>
                                <td>
                                    <Badge :is-active="user.isActive"/>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-primary"
                                        @click="showViewUserModal(user.id)"
                                    ><i class="bi bi-eye-fill"></i>
                                        View
                                    </button>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-warning"
                                        @click="showEditUserModal(user.id)"
                                    ><i class="bi bi-pencil-square"></i>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p v-else class="mt-3 text-center lead">
                            {{ userStore.isContentLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
                        </p>
                    </div>
                    <p>Всего записей: <span class="fw-bold">{{ users.length }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- New User Modal Start -->
    <div id="newUser" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">
            <form @submit.prevent="saveUser">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Добавление пользователя</h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <Alert/>
                        <div class="row g-3">
                            <div class="col-12">
                                <Label for="last-name" required>Фамилия</Label>
                                <Input
                                    id="last-name"
                                    v-model="form.lastName"
                                    placeholder="Палкина"
                                    type="text"
                                />
                            </div>
                            <div class="col-md-6">
                                <Label for="first-name" required>Имя</Label>
                                <Input
                                    id="first-name"
                                    v-model="form.firstName"
                                    placeholder="Евдокия"
                                    type="text"
                                />
                            </div>
                            <div class="col-md-6">
                                <Label for="middle-name">Отчество</Label>
                                <Input
                                    id="middle-name"
                                    v-model="form.middleName"
                                    placeholder="Никифоровна"
                                    type="text"
                                />
                            </div>
                            <div class="col-md-6">
                                <Label for="email" required>Email</Label>
                                <Input
                                    id="email"
                                    v-model="form.email"
                                    placeholder="email@mail.ru"
                                    type="text"
                                />
                            </div>
                            <div class="col-md-6">
                                <Label for="password" required>Пароль</Label>
                                <Input
                                    id="password"
                                    v-model="form.password"
                                    placeholder="Придумайте пароль"
                                    type="text"
                                />
                            </div>
                            <div class="col-12">
                                <p class="text-secondary mb-0 small">Сообщите email и пароль пользователю системы. Эти
                                    данные потребуются для входа в личный кабинет.</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <Button
                            :disabled="userStore.isButtonDisabled"
                            :loading="userStore.isButtonDisabled"
                            class="w-25"
                            type="submit"
                        >Сохранить
                        </Button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- New User Modal End -->

    <!-- Edit One User Modal Start -->
    <div id="editUser" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">
            <form @submit.prevent="updateUser(user)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактирование пользователя</h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <Alert/>
                        <div class="row g-3">
                            <div class="col-12">
                                <Label for="edit-name" required>Фамилия</Label>
                                <Input
                                    id="edit-name"
                                    v-model="user.lastName"
                                    placeholder="Палкина"
                                    type="text"
                                />
                            </div>
                            <div class="col-md-6">
                                <Label for="edit-first-name" required>Имя</Label>
                                <Input
                                    id="edit-first-name"
                                    v-model="user.firstName"
                                    placeholder="Евдокия"
                                    type="text"
                                />
                            </div>
                            <div class="col-md-6">
                                <Label for="edit-middle-name">Отчество</Label>
                                <Input
                                    id="edit-middle-name"
                                    v-model="user.middleName"
                                    placeholder="Никифоровна"
                                    type="text"
                                />
                            </div>
                            <div class="col-md-6">
                                <Label for="edit-email" required>Email</Label>
                                <Input
                                    id="edit-email"
                                    v-model="user.email"
                                    placeholder="email@mail.ru"
                                    type="text"
                                />
                            </div>
                            <div class="col-md-6">
                                <Label for="edit-password">Пароль</Label>
                                <Input
                                    id="edit-password"
                                    v-model="user.password"
                                    placeholder="Обновите пароль, если нужно"
                                    type="text"
                                />
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input
                                        id="edit-isActive"
                                        v-model="user.isActive"
                                        :checked="user.isActive"
                                        class="form-check-input"
                                        type="checkbox"
                                    >
                                    <label class="form-check-label" for="edit-isActive">
                                        Работает?
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-secondary mb-0 small">Сообщите пользователю обновлённый пароль, если он
                                    был изменён.</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <Button
                            :disabled="userStore.isButtonDisabled"
                            :loading="userStore.isButtonDisabled"
                            class="w-25"
                            type="submit"
                        >Сохранить
                        </Button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Edit One User Modal End -->

    <!-- View One User Modal Start -->
    <div id="viewUser" aria-hidden="true" class="modal fade" style="display: none;" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Просмотр пользователя</h5>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <pre>
                        {{ user }}
                    </pre>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <!-- View One User Modal End -->
</template>

<script setup>
import Input from '@/components/core/Input.vue';
import Label from '@/components/core/Label.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import { onMounted, reactive, ref, watch } from 'vue';
import { useUserStore } from '@/stores/users.js';
import { useAlertStore } from '@/stores/alerts.js';
import ThSort from '@/components/core/ThSort.vue';
import Badge from '@/components/core/Badge.vue';
import { arrFilter, arrSort } from '@/helpers/arrHandlers.js';
import { resetSearchKeys } from '@/helpers/searchHandlers.js';

const userStore = useUserStore();
const alertStore = useAlertStore();

const initialFormData = () => ({
    firstName: '',
    lastName: '',
    middleName: '',
    email: '',
    password: '',
});

let form = reactive(initialFormData());

const users = ref([]);
const user = ref({});

const searchBy = reactive({
    firstName: '',
    lastName: '',
    middleName: '',
    email: '',
    isActive: false,
});

let orderColumn = 'id';
let orderDirection = 'asc';

let newUserModal = null;
let editUserModal = null;
let viewUserModal = null;

onMounted(async () => {
    await getUsers();
});

const getUsers = async () => {
    await userStore.all();
    applyFilterSort();
};

const getUser = (id) => {
    user.value = userStore.getUsers
        .find(item => item.id === id);
};

const showNewUserModal = () => {
    alertStore.clear();
    form = initialFormData();
    newUserModal = new bootstrap.Modal(document.getElementById('newUser'));
    newUserModal.show();
};

const showEditUserModal = (id) => {
    alertStore.clear();
    editUserModal = new bootstrap.Modal(document.getElementById('editUser'));
    editUserModal.show();
    getUser(id);
};

// TODO: make view
const showViewUserModal = (id) => {
    viewUserModal = new bootstrap.Modal(document.getElementById('viewUser'));
    viewUserModal.show();
    getUser(id);
};

// TODO: upload images
const saveUser = async () => {
    const response = await userStore.save(form);
    if ( response && response.status === 'success' ) {
        form = initialFormData();
        alertStore.clear();
        newUserModal.hide();
        resetSearchKeys(searchBy);
        orderColumn = 'id';
        orderDirection = 'desc';
        await getUsers();
    }
};

const updateUser = async (user) => {
    const response = await userStore.update(user);
    if ( response && response.status === 'success' ) {
        alertStore.clear();
        editUserModal.hide();
        await getUsers();
    }
};

const clearSearch = () => {
    resetSearchKeys(searchBy);
    applyFilterSort(
        (orderColumn = 'id'),
        (orderDirection = 'asc'),
    );
};

watch(searchBy, () => applyFilterSort());

const applyFilterSort = (
    column = orderColumn,
    direction = orderDirection,
    sort_by_numeric = true,
) => {
    orderColumn = column;
    orderDirection = direction;

    let tempArr = userStore.getUsers.slice();

    tempArr = arrSort(tempArr, sort_by_numeric, direction, column);
    tempArr = arrFilter(tempArr, searchBy);

    users.value = tempArr;
};
</script>
