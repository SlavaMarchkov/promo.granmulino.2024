<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                <div class="d-flex justify-content-center py-4">
                    <RouterLink :to="{ name: 'Manager.Index' }" class="logo d-flex align-items-center w-auto">
                        <img src="/assets/img/logo.png" alt="">
                        <span class="d-none d-lg-block">{{ props.brand }}</span>
                    </RouterLink>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="pt-2 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Регистрация</h5>
                            <p class="text-center small">Введите имя, email и придумайте пароль</p>
                        </div>
                        <Alert/>
                        <form @submit.prevent="handleRegister" class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">ФИО</label>
                                <input
                                    v-model="credentials.name"
                                    type="text"
                                    class="form-control"
                                    id="name"
                                    placeholder="Фамилия Имя"
                                    autocomplete="current-name"
                                >
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input
                                    v-model="credentials.email"
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    placeholder="email@mail.ru"
                                    autocomplete="email"
                                >
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Пароль</label>
                                <input
                                    v-model="credentials.password"
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    placeholder="Придумайте пароль"
                                    autocomplete="current-password"
                                >
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Зарегистрироваться</button>
                            </div>
                            <div class="col-12">
                                <p class="small mb-0">Есть аккаунт?
                                    <RouterLink :to="{ name: 'Login' }">Войти</RouterLink>
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
import { useAuthStore } from '@/stores/auth.js';
import { ref } from 'vue';
import Alert from '@/components/Alert.vue';

const authStore = useAuthStore();

const props = {
    brand,
};

const credentials = ref({
    name: '',
    email: '',
    password: '',
});

const handleRegister = async () => {
    await authStore.register(credentials.value);
};
</script>
