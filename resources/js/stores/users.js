import { defineStore } from 'pinia';

import state from '@/stores/users/state.js';
import getters from '@/stores/users/getters.js';
import actions from '@/stores/users/actions.js';

export const useUserStore = defineStore(
    {
        id: 'users',
        state: () => (state),
        getters,
        actions,
    });
