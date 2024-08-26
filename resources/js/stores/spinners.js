import { defineStore } from 'pinia';

import state from '@/stores/spinners/state.js';
import getters from '@/stores/spinners/getters.js';
import actions from '@/stores/spinners/actions.js';

export const useSpinnerStore = defineStore(
    {
        id: 'spinners',
        state: () => (state),
        getters,
        actions,
    });
