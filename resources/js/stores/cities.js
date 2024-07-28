import { defineStore } from 'pinia';

import state from '@/stores/cities/state.js';
import getters from '@/stores/cities/getters.js';
import actions from '@/stores/cities/actions.js';

export const useCityStore = defineStore(
    {
        id: 'cities',
        state: () => (state),
        getters,
        actions,
    });
