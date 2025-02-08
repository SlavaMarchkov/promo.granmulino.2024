<template>
    <div class="row mb-4">
        <div class="col-6">
            <h3 class="mb-1">{{ $route.meta.title }}</h3>
        </div>
        <div v-show="isSuperAdmin" class="col-6 text-end">
            <TheButton
                class="btn-primary"
                @click="createAdministratorInit"
            >Новый администратор
            </TheButton>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <TheFilter
                @reset-filter="clearSearch"
            >
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
                    <TheCheckbox
                        id="is_active"
                        v-model="searchBy.isActive"
                    >
                        Работает?
                    </TheCheckbox>
                </div>
            </TheFilter>
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
                                    {{ item.lastName }}
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
                                    {{ item.roleName }}
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
                                    @runButtonHandler="viewAdministratorInit"
                                >View
                                </TdButton>
                                <template
                                    v-if="isSuperAdmin"
                                >
                                    <TdButton
                                        :id="item.id"
                                        intent="edit"
                                        @runButtonHandler="editAdministratorInit"
                                    >Edit
                                    </TdButton>
                                    <TdButton
                                        :id="item.id"
                                        intent="delete"
                                        @runButtonHandler="deleteAdministrator"
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
            <span v-if="state.isEditing">Редактирование администратора <b>{{ state.administrator.fullName }}</b></span>
            <span v-else>Добавление администратора</span>
        </template>
        <template #body>
            <Alert/>
            <div class="row g-3">
                <div class="col-12">
                    <TheLabel for="last-name" required>Фамилия</TheLabel>
                    <TheInput
                        id="last-name"
                        v-model="state.administrator.lastName"
                        placeholder="Например: Овчинникова"
                        type="text"
                    />
                </div>
                <div class="col-12">
                    <TheLabel for="first-name" required>Имя</TheLabel>
                    <TheInput
                        id="first-name"
                        v-model="state.administrator.firstName"
                        placeholder="Например: Екатерина"
                        type="text"
                    />
                </div>
                <div class="col-12">
                    <TheLabel for="middle-name">Отчество</TheLabel>
                    <TheInput
                        id="middle-name"
                        v-model="state.administrator.middleName"
                        placeholder="Например: Александровна"
                        type="text"
                    />
                </div>
                <div class="col-12">
                    <TheLabel for="email" required>Email</TheLabel>
                    <TheInput
                        id="email"
                        v-model="state.administrator.email"
                        placeholder="Например: 508@altan.ru"
                        type="email"
                    />
                </div>
                <div class="col-12">
                    <TheLabel for="password" :required="!state.isEditing">{{ state.isEditing ? 'Пароль (оставьте пустым, если не изменяете пароль)': 'Пароль' }}</TheLabel>
                    <TheInput
                        id="password"
                        v-model="state.administrator.password"
                        type="password"
                    />
                </div>
                <div class="col-12">
                    <TheLabel for="role" required>Роль в системе</TheLabel>
                    <select id="role" v-model="state.administrator.role" class="form-select">
                        <option disabled selected value="">-- Выберите роль --</option>
                        <option
                            v-for="(role, roleName) in ADMIN_ROLES"
                            :key="roleName"
                            :value="roleName"
                        >{{ role }}
                        </option>
                    </select>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input
                            id="is-active"
                            v-model="state.administrator.isActive"
                            :checked="state.administrator.isActive"
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
            <TheButton
                :class="state.isEditing
                    ? 'btn-warning'
                    : 'btn-primary'"
                :disabled="spinnerStore.isButtonDisabled"
                :loading="spinnerStore.isButtonDisabled"
                class="w-25"
                type="button"
                @click="saveAdministrator"
            >
                <span v-if="state.isEditing">Сохранить</span>
                <span v-else>Создать</span>
            </TheButton>
        </template>
    </Modal>

    <Modal
        id="viewModalPopUp"
        :close-func="closeViewModal"
        :custom-classes="['']"
    >
        <template #title>
            Просмотр администратора <b>{{ state.administrator.fullName }}</b>
        </template>
        <template #body>
            <table class="table table-bordered mt-3 align-middle text-wrap"
                   style="width: 100%;">
                <tbody>
                <tr>
                    <th style="width: 35%;">ID</th>
                    <td>{{ state.administrator.id }}</td>
                </tr>
                <tr>
                    <th>Фамилия</th>
                    <td>{{ state.administrator.lastName }}</td>
                </tr>
                <tr>
                    <th>Имя</th>
                    <td>{{ state.administrator.firstName }}</td>
                </tr>
                <tr>
                    <th>Отчество</th>
                    <td>{{ state.administrator.middleName }}</td>
                </tr>
                <tr>
                    <th>Системное имя</th>
                    <td>{{ state.administrator.displayName }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ state.administrator.email }}</td>
                </tr>
                <tr>
                    <th>Роль</th>
                    <td>{{ state.administrator.roleName }} - {{ state.administrator.role }}</td>
                </tr>
                <tr>
                    <th>Работает?</th>
                    <td><TheBadge :is-active="state.administrator.isActive" /></td>
                </tr>
                <tr>
                    <th>Последний вход</th>
                    <td>{{ state.administrator.loggedInAt }}</td>
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
import TheButton from '@/components/core/TheButton.vue';
import Alert from '@/components/Alert.vue';
import { computed, onMounted, reactive } from 'vue';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useAuthStore } from '@/stores/auth.js';
import { useHttpService } from '@/use/useHttpService.js';
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import InputGroup from '@/components/form/InputGroup.vue';
import TheFilter from '@/components/core/TheFilter.vue';
import Modal from '@/components/Modal.vue';
import ThSort from '@/components/table/ThSort.vue';
import TdButton from '@/components/table/TdButton.vue';
import TheCheckbox from '@/components/form/TheCheckbox.vue';
import TheBadge from '@/components/core/TheBadge.vue';
import {
    ADMIN_ROLES,
    ADMIN_TH_FIELDS,
    ADMIN_URLS,
    DELETE_TH_FIELD,
    EDIT_TH_FIELD,
    ROLES,
} from '@/helpers/constants.js';

const alertStore = useAlertStore();
const spinnerStore = useSpinnerStore();
const authStore = useAuthStore();
const arrayHandlers = useArrayHandlers();
const { get, post, update, destroy } = useHttpService();

const role = authStore.getUser.role;
const isSuperAdmin = computed(() => role === ROLES.SUPER_ADMIN);

const thItems = computed(() => {
    return isSuperAdmin.value
        ? ADMIN_TH_FIELDS.concat(EDIT_TH_FIELD, DELETE_TH_FIELD)
        : ADMIN_TH_FIELDS;
});

const initialFormData = () => ({
    firstName: '',
    lastName: '',
    middleName: '',
    email: '',
    password: '',
    role: '',
    roleName: '',
    isActive: true,
    isAdmin: true,
});

const state = reactive({
    administrators: [],
    administrator: initialFormData(),
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
    state.administrator = initialFormData();
    if ( document.activeElement ) {
        document.activeElement.blur();
    }
}

onMounted(async () => {
    await getAdministrators();
    modalPopUp = new bootstrap.Modal(document.getElementById('modalPopUp'));
    modalPopUp._element.addEventListener('hide.bs.modal', resetState);
});

const getAdministrators = async () => {
    const { data } = await get(ADMIN_URLS.ADMIN);
    state.administrators = data.users;
};

const getOneAdministrator = (id) => state.administrators.find(admin => admin.id === id);

const createAdministratorInit = () => {
    alertStore.clear();
    state.isEditing = false;
    state.administrator = initialFormData();
    modalPopUp.show();
};

const editAdministratorInit = (id) => {
    alertStore.clear();
    state.isEditing = true;
    state.administrator = getOneAdministrator(id);
    modalPopUp.show();
};

const viewAdministratorInit = (id) => {
    viewModalPopUp = new bootstrap.Modal(document.getElementById('viewModalPopUp'));
    state.administrator = getOneAdministrator(id);
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

const saveAdministrator = async () => {
    if ( state.isEditing ) {
        const response = await update(`${ ADMIN_URLS.ADMIN }/${ state.administrator.id }`, state.administrator);
        if ( response && response.status === 'success' ) {
            const updatedAdministrator = response.data;
            const idx = state.administrators.findIndex(admin => admin.id === updatedAdministrator.id);
            state.administrators[idx] = updatedAdministrator;
            alertStore.clear();
            modalPopUp.hide();
        }
    } else {
        const response = await post(ADMIN_URLS.ADMIN, state.administrator);
        if ( response && response.status === 'success' ) {
            alertStore.clear();
            state.administrator = initialFormData();
            modalPopUp.hide();
            state.administrators.push(response.data);
            arrayHandlers.resetSearchKeys(searchBy);
            arrayHandlers.resetSortKeys('id', false);
        }
    }
};

const deleteAdministrator = async (id) => {
    if ( confirm('Точно удалить администратора? Уверены?') ) {
        const response = await destroy(`${ ADMIN_URLS.ADMIN }/${ id }`);
        if ( response && response.status === 'success' ) {
            const idx = state.administrators.findIndex(admin => admin.id === id);
            state.administrators.splice(idx, 1);
        }
    }
};

const sortedItems = computed(() => {
    return arrayHandlers.sortArray(state.administrators);
});

const filteredItems = computed(() => {
    return arrayHandlers.filterArray(sortedItems.value, searchBy);
});
</script>
