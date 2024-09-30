<template>
    <div class="row mb-4">
        <div class="col-12">
            <button
                class="btn btn-primary"
                type="button"
                @click="createUserInit"
            >
                Новый пользователь
            </button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <Filter @reset-filter="clearSearch">
                <div class="col-md-4 mb-2">
                    <InputGroup v-model="searchBy.lastName" placeholder="Поиск по фамилии">Фамилия</InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <InputGroup v-model="searchBy.firstName" placeholder="Поиск по имени">Имя</InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <InputGroup v-model="searchBy.middleName" placeholder="Поиск по отчеству">Отчество</InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <InputGroup v-model="searchBy.email" placeholder="Поиск по email">Email</InputGroup>
                </div>
                <div class="col-md-4 mb-2">
                    <Checkbox
                        id="is_active"
                        v-model="searchBy.isActive"
                    >
                        Работает?
                    </Checkbox>
                </div>
            </Filter>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-0">
                    <div v-if="filteredItems.length > 0" class="table-responsive">
                        <table class="table table-bordered my-4 text-center align-middle text-nowrap"
                               style="width: 100%;">
                            <thead>
                            <tr>
                                <template
                                    v-for="{ column, label, sortable, is_num, width } in thItems"
                                    :key="column"
                                >
                                    <ThSort
                                        :column="column"
                                        :is-numeric="is_num"
                                        :sort-by-asc="arrayHandlers.sortBy.asc"
                                        :sort-by-column="arrayHandlers.sortBy.column === column"
                                        :sortable="sortable"
                                        :width="width"
                                        @setSort="arrayHandlers.setSort(column, is_num)"
                                    >{{ label }}
                                    </ThSort>
                                </template>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in filteredItems" :key="item.id">
                                <th scope="row">
                                    {{ item.id }}
                                </th>
                                <td class="text-start">
                                    <RouterLink :to="{
                                        name: 'User.View',
                                        params: {
                                            'id': item.id
                                        }
                                    }">
                                        {{ item.lastName }}
                                    </RouterLink>
                                </td>
                                <td class="text-start">
                                    {{ item.firstName }}
                                </td>
                                <td class="text-start">
                                    {{ item.middleName }}
                                </td>
                                <td class="text-start">
                                    {{ item.email }}
                                </td>
                                <td class="text-start">
                                    {{ item.loggedInAt }}
                                </td>
                                <td>
                                    <TheBadge :is-active="item.isActive"/>
                                </td>
                                <TdButton
                                    :id="item.id"
                                    intent="view"
                                    @runButtonHandler="viewUserInit"
                                >View
                                </TdButton>
                                <template
                                    v-if="isSuperAdmin"
                                >
                                    <TdButton
                                        :id="item.id"
                                        intent="edit"
                                        @runButtonHandler="editUserInit"
                                    >Edit
                                    </TdButton>
                                    <TdButton
                                        :id="item.id"
                                        intent="delete"
                                        @runButtonHandler="deleteUser"
                                    >Delete
                                    </TdButton>
                                </template>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <p v-else class="mt-3 text-center lead">
                        {{ spinnerStore.isLoading ? 'Подождите, загружаю...' : 'Записей не найдено...' }}
                    </p>
                    <p>Всего записей: <span class="fw-bold">{{ filteredItems.length }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <Modal
        id="modalPopUp"
        :close-func="closeModal"
        :custom-classes="['']"
    >
        <template #title>
            <span v-if="state.isEditing">Редактирование пользователя <b>{{ state.user.fullName }}</b></span>
            <span v-else>Добавление пользователя</span>
        </template>
        <template #body>
            <Alert/>
            <div class="row g-3">
                <div class="col-12">
                    <TheLabel for="last-name" required>Фамилия</TheLabel>
                    <TheInput
                        id="last-name"
                        v-model="state.user.lastName"
                        placeholder="Например: Овчинникова"
                        type="text"
                    />
                </div>
                <div class="col-12">
                    <TheLabel for="first-name" required>Имя</TheLabel>
                    <TheInput
                        id="first-name"
                        v-model="state.user.firstName"
                        placeholder="Например: Екатерина"
                        type="text"
                    />
                </div>
                <div class="col-12">
                    <TheLabel for="middle-name">Отчество</TheLabel>
                    <TheInput
                        id="middle-name"
                        v-model="state.user.middleName"
                        placeholder="Например: Александровна"
                        type="text"
                    />
                </div>
                <div class="col-12">
                    <TheLabel for="email" required>Email</TheLabel>
                    <TheInput
                        id="email"
                        v-model="state.user.email"
                        placeholder="Например: 508@altan.ru"
                        type="email"
                    />
                </div>
                <div class="col-12">
                    <TheLabel for="password" :required="!state.isEditing">{{ state.isEditing ? 'Пароль (оставьте пустым, если не изменяете пароль)': 'Пароль' }}</TheLabel>
                    <TheInput
                        id="password"
                        v-model="state.user.password"
                        type="password"
                    />
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input
                            id="is-active"
                            v-model="state.user.isActive"
                            :checked="state.user.isActive"
                            class="form-check-input"
                            type="checkbox"
                        >
                        <label class="form-check-label" for="is-active">
                            Работает?
                        </label>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <Button
                :class="state.isEditing
                    ? 'btn-warning'
                    : 'btn-primary'"
                :disabled="spinnerStore.isButtonDisabled"
                :loading="spinnerStore.isButtonDisabled"
                class="w-25"
                type="button"
                @click="saveUser"
            >
                <span v-if="state.isEditing">Сохранить</span>
                <span v-else>Создать</span>
            </Button>
        </template>
    </Modal>

    <Modal
        id="viewModalPopUp"
        :close-func="closeViewModal"
        :custom-classes="['']"
    >
        <template #title>
            Просмотр пользователя <b>{{ state.user.fullName }}</b>
        </template>
        <template #body>
            <table class="table table-bordered mt-3 align-middle text-wrap"
                   style="width: 100%;">
                <tbody>
                <tr>
                    <th style="width: 35%;">ID</th>
                    <td>{{ state.user.id }}</td>
                </tr>
                <tr>
                    <th>Фамилия</th>
                    <td>{{ state.user.lastName }}</td>
                </tr>
                <tr>
                    <th>Имя</th>
                    <td>{{ state.user.firstName }}</td>
                </tr>
                <tr>
                    <th>Отчество</th>
                    <td>{{ state.user.middleName }}</td>
                </tr>
                <tr>
                    <th>Системное имя</th>
                    <td>{{ state.user.fullName }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ state.user.email }}</td>
                </tr>
                <tr>
                    <th>Работает?</th>
                    <td><TheBadge :is-active="state.user.isActive" /></td>
                </tr>
                <tr>
                    <th>Админ?</th>
                    <td><TheBadge :is-active="state.user.isAdmin" /></td>
                </tr>
                <tr>
                    <th>Последний вход</th>
                    <td>{{ state.user.loggedInAt }}</td>
                </tr>
                </tbody>
            </table>
        </template>
        <template #footer>
            <span></span>
        </template>
    </Modal>
</template>

<script setup>
import TheInput from '@/components/form/TheInput.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import Button from '@/components/core/Button.vue';
import Alert from '@/components/Alert.vue';
import { computed, onMounted, reactive } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useAuthStore } from '@/stores/auth.js';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import InputGroup from '@/components/form/InputGroup.vue';
import Filter from '@/components/core/Filter.vue';
import Modal from '@/components/Modal.vue';
import ThSort from '@/components/table/ThSort.vue';
import TdButton from '@/components/table/TdButton.vue';
import Checkbox from '@/components/form/Checkbox.vue';
import TheBadge from '@/components/core/TheBadge.vue';
import { ADMIN_URLS, DELETE_TH_FIELD, EDIT_TH_FIELD, ROLES, USER_TH_FIELDS } from '@/helpers/constants.js';

const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const authStore = useAuthStore();
const arrayHandlers = useArrayHandlers();
const { get, post, update, destroy } = useHttpService();

const role = authStore.getUser.role;
const isSuperAdmin = computed(() => role === ROLES.SUPER_ADMIN);

const thItems = computed(() => {
    return isSuperAdmin
        ? USER_TH_FIELDS.concat(EDIT_TH_FIELD, DELETE_TH_FIELD)
        : USER_TH_FIELDS;
});

const initialFormData = () => ({
    firstName: '',
    lastName: '',
    middleName: '',
    displayName: '',
    email: '',
    password: '',
    isActive: true,
});

const state = reactive({
    users: [],
    user: initialFormData(),
    isEditing: false,
});

const searchBy = reactive({
    firstName: '',
    lastName: '',
    middleName: '',
    email: '',
    isActive: false,
});

let modalPopUp = null;
let viewModalPopUp = null;

function resetState() {
    state.isEditing = false;
    state.user = initialFormData();
}

onMounted(async () => {
    await getUsers();
    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', resetState);
});

const getUsers = async () => {
    const { data } = await get(ADMIN_URLS.USER);
    state.users = data.users;
};

const getOneUser = (id) => state.users.find(user => user.id === id);

const createUserInit = () => {
    alertStore.clear();
    state.isEditing = false;
    state.user = initialFormData();
    modalPopUp.show();
};

const editUserInit = (id) => {
    alertStore.clear();
    state.isEditing = true;
    state.user = getOneUser(id);
    modalPopUp.show();
};

const viewUserInit = (id) => {
    viewModalPopUp = new bootstrap.Modal(document.getElementById('viewModalPopUp'));
    state.user = getOneUser(id);
    viewModalPopUp.show();
    viewModalPopUp._element.addEventListener('hide.bs.modal', resetState);
};

const closeModal = () => {
    modalPopUp.hide();
    modalPopUp._element.removeEventListener('hide.bs.modal', resetState);
};

const closeViewModal = () => {
    viewModalPopUp.hide();
    viewModalPopUp._element.removeEventListener('hide.bs.modal', resetState);
};

const clearSearch = () => {
    arrayHandlers.resetSearchKeys(searchBy);
    arrayHandlers.resetSortKeys();
};

const saveUser = async () => {
    if ( state.isEditing ) {
        const response = await update(`${ ADMIN_URLS.USER }/${ state.user.id }`, state.user);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            modalPopUp.hide();
            await getUsers();
        }
    } else {
        const response = await post(ADMIN_URLS.USER, state.user);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            state.user = initialFormData();
            modalPopUp.hide();
            arrayHandlers.resetSearchKeys(searchBy);
            arrayHandlers.resetSortKeys('id', false);
            await getUsers();
        }
    }
};

const deleteUser = async (id) => {
    if ( confirm('Точно удалить пользователя? Уверены?') ) {
        const response = await destroy(`${ ADMIN_URLS.USER }/${ id }`);
        if ( response && response.status === 'success' ) {
            await getUsers();
        }
    }
};

const sortedItems = computed(() => {
    return arrayHandlers.sortArray(state.users);
});

const filteredItems = computed(() => {
    return arrayHandlers.filterArray(sortedItems.value, searchBy);
});
</script>
