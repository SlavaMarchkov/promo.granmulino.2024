<template>
    <div v-if="alert" class="alert alert-dismissible fade show" :class="alert.type" role="alert">
        <ul v-if="alert.message.validation" class="mb-0 list-unstyled">
            <li v-for="error in alert.message.validation" :key="error" class="text-start">
                {{ error }}
            </li>
        </ul>
        <div v-if="alert.message.message" class="mb-0 text-start">
            {{ alert.message.message }}
        </div>
        <button
            v-if="alert.closeable"
            @click="alertStore.clear()"
            type="button"
            class="btn-close"
            aria-label="Close"
        ></button>
    </div>
</template>

<script setup>
import { useAlertStore } from '@/stores/alerts.js';
import { storeToRefs } from 'pinia';

const alertStore = useAlertStore();
const { getAlert: alert } = storeToRefs(alertStore);
</script>
