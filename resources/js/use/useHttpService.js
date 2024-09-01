import http from '@/api/http.js';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useConvertCase } from '@/use/useConvertCase.js';

const { makeConvertibleObject, toSnake } = useConvertCase();

export function useHttpService() {
    const spinnerStore = useSpinnerStore();
    const alertStore = useAlertStore();

    const get = (url, config = {}) => {
        spinnerStore.showSpinner();
        return http.get(url, config)
            .then(response => response.data)
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
            .then(response => response.data)
            .catch((error) => {
                alertStore.error(error, true);
                return false;
            })
            .finally(() => {
                spinnerStore.enableButton();
            });
    };

    const update = (url, data, config = {}) => {
        spinnerStore.disableButton();
        const formData = makeConvertibleObject(data, toSnake);

        return http.put(url, formData, config)
            .then(response => response.data)
            .catch((error) => {
                alertStore.error(error, true);
                return false;
            })
            .finally(() => {
                spinnerStore.enableButton();
            });
    };

    const destroy = (url, config = {}) => {
        return http.delete(url, config)
            .then(response => response.data)
            .catch((error) => {
                alertStore.error(error, true);
                return false;
            });
    };

    return {
        get,
        post,
        update,
        destroy,
    };
}
