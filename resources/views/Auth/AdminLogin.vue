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
                    <TheLabel for="email">Email</TheLabel>
                    <TheInput
                        id="email"
                        v-model="credentials.email"
                        placeholder="email@mail.ru"
                        autocomplete="current-email"
                        type="email"
                    />
                </div>
                <div class="col-12">
                    <TheLabel for="password">Пароль</TheLabel>
                    <TheInput
                        id="password"
                        v-model="credentials.password"
                        autocomplete="current-password"
                        type="password"
                    />
                </div>
                <div class="col-12">
                    <TheButton
                        type="submit"
                        :loading="spinnerStore.isLoading"
                        :disabled="spinnerStore.isLoading"
                        class="btn-primary w-100"
                    >Войти в админку
                    </TheButton>
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
import { useSpinnerStore } from '@/stores/spinners.js';
import { useRouter } from 'vue-router';
import Alert from '@/components/Alert.vue';
import TheButton from '@/components/core/TheButton.vue';
import TheLabel from '@/components/form/TheLabel.vue';
import TheInput from '@/components/form/TheInput.vue';

const authStore = useAuthStore();
const spinnerStore = useSpinnerStore();
const router = useRouter();

const credentials = reactive({
    email: '',
    password: '',
});

const handleAdminLogin = async () => {
    const response = await authStore.login(credentials, true);
    if ( response && response.status === 'success' ) {
        await router.push({
            name: 'Admin.Index'
        });
    }
};
</script>
