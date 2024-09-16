<template>
    <div class="card mb-3">
        <div class="card-body">
            <div class="pt-2 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Вход в панель администратора</h5>
                <p class="text-center small">Введите email и пароль для входа</p>
            </div>
            <Alert/>
            <form class="row g-3" @submit.prevent="handleAdminLogin">
                <div class="col-12">
                    <label class="form-label" for="email">Email</label>
                    <input
                        id="email"
                        v-model="credentials.email"
                        autocomplete="current-email"
                        class="form-control"
                        placeholder="email@mail.ru"
                        type="email"
                    >
                </div>
                <div class="col-12">
                    <label class="form-label" for="password">Пароль</label>
                    <input
                        id="password"
                        v-model="credentials.password"
                        autocomplete="current-password"
                        class="form-control"
                        type="password"
                    >
                </div>
                <div class="col-12">
                    <Button
                        :loading="authStore.isLoading"
                        class="btn-primary w-100"
                        :disabled="authStore.isLoading"
                        type="submit"
                    >Войти в админку
                    </Button>
                </div>
                <div class="col-12">
                    <p class="small mb-0">
                        <RouterLink :to="{ name: 'Login' }">Вход в менеджерскую панель</RouterLink>
                    </p>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive } from 'vue';
import { useAuthStore } from '@/stores/auth.js';
import Alert from '@/components/Alert.vue';
import Button from '@/components/core/Button.vue';

const authStore = useAuthStore();

const credentials = reactive({
    email: '',
    password: '',
});

const handleAdminLogin = async () => {
    await authStore.adminLogin(credentials);
};
</script>
