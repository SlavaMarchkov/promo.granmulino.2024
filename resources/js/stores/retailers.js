import { defineStore } from 'pinia';

import state from '@/stores/retailers/state.js';
import getters from '@/stores/retailers/getters.js';
import actions from '@/stores/retailers/actions.js';

export const useRetailerStore = defineStore(
    {
        id: 'retailers',
        state: () => (state),
        getters,
        actions,
    });
