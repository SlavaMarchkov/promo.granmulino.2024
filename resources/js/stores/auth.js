import { defineStore } from 'pinia';

import state from '@/stores/auth/state.js';
import getters from '@/stores/auth/getters.js';
import actions from '@/stores/auth/actions.js';

export const useAuthStore = defineStore(
    {
        id: 'auth',
        state: () => (state),
        getters,
        actions,
    });
