import { defineStore } from 'pinia';

import state from '@/stores/regions/state.js';
import getters from '@/stores/regions/getters.js';
import actions from '@/stores/regions/actions.js';

export const useRegionStore = defineStore(
    {
        id: 'regions',
        state: () => (state),
        getters,
        actions,
    });
