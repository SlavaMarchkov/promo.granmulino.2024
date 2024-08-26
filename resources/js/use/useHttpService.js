import http from '@/api/http.js';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import { useConvertCase } from '@/use/useConvertCase.js';

const { makeConvertibleObject, toSnake } = useConvertCase();

const $toast = useToast({
    position: 'top-right',
});

export function useHttpService() {
    const spinnerStore = useSpinnerStore();
    const alertStore = useAlertStore();

    const get = (url, config = {}) => {
        spinnerStore.showSpinner();
        return http.get(url, config)
            .then((response) => {
                $toast.success(response?.data.message);
                return response?.data;
            })
            .catch((error) => {
                alertStore.error(error);
                return false;
            })
            .finally(() => {
                spinnerStore.hideSpinner();
            });
    };

    const post = (url, data, config = {}) => {
        spinnerStore.disableButton();
        const formData = makeConvertibleObject(data, toSnake);

        return http.post(url, formData, config)
            .then((response) => {
                $toast.success(response?.data.message);
                return response?.data;
            })
            .catch((error) => {
                alertStore.error(error, true);
                return false;
            })
            .finally(() => {
                spinnerStore.enableButton();
            });
    };

    /*const update = (url, data, config = {}) => {
        spinnerStore.disableButton();
        const formData = makeConvertibleObject(data, toSnake);

        return http.put(url, formData, config)
            .then((response) => {
                $toast.success(response?.data.message);
                return response?.data;
            })
            .catch((error) => {
                alertStore.error(error, true);
                return false;
            })
            .finally(() => {
                spinnerStore.makeButtonEnabled();
            });
    };*/

    return {
        get,
        post,
    };
}
