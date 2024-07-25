<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                <div class="d-flex justify-content-center py-4">
                    <RouterLink :to="{ name: 'Dashboard' }" class="logo d-flex align-items-center w-auto">
                        <img src="/assets/img/logo.png" alt="">
                        <span class="d-none d-lg-block">{{ props.brand }}</span>
                    </RouterLink>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="pt-2 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Вход в панель управления</h5>
                            <p class="text-center small">Введите email и пароль для входа</p>
                        </div>
                        <Alert/>
                        <form @submit.prevent="handleLogin" class="row g-3">
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input
                                    v-model="credentials.email"
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    placeholder="email@mail.ru"
                                    autocomplete="current-email"
                                >
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Пароль</label>
                                <input
                                    v-model="credentials.password"
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    autocomplete="current-password"
                                >
                            </div>
                            <div class="col-12">
                                <button
                                    class="btn btn-primary w-100"
                                    type="submit"
                                    :disabled="authStore.isLoading"
                                >
                                    <span
                                        v-if="authStore.isLoading"
                                        class="spinner-border spinner-border-sm"
                                        role="status"
                                        aria-hidden="true"
                                    ></span>
                                    <span v-else>Войти</span>
                                </button>
                            </div>
                            <div class="col-12">
                                <p class="small mb-0">Нет аккаунта?
                                    <RouterLink :to="{ name: 'Register' }">Зарегистрироваться</RouterLink>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth.js';
import Alert from '@/components/Alert.vue';

const authStore = useAuthStore();

const props = {
    brand,
};

const credentials = ref({
    email: '',
    password: '',
});

const handleLogin = async () => {
    await authStore.login(credentials.value);
};
</script>
