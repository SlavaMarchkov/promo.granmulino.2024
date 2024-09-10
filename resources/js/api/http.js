import Axios from 'axios';
import { useAuthStore } from '@/stores/auth.js';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';

const $toast = useToast({
    position: 'top-right',
});

const http = Axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    timeout: 60_000,
    withCredentials: true,
    responseType: 'json',
    headers: {
        'Accept': 'application/json',
    },
});

const convertPostToFormData = (config) => {
    if ( config.method === 'post' && !(config.data instanceof FormData) ) {
        const formData = new FormData();
        for ( const item in config.data ) {
            if ( config.data.hasOwnProperty(item) ) {
                formData.append(item, config.data[item]);
            }
        }
        config.data = formData;
    }
    return config;
};

const tokenHandler = (config) => {
    const { getToken: token } = useAuthStore();
    if ( token ) {
        config.headers.Authorization = `Bearer ${ token }`;
        localStorage.setItem('token', token);
    }
    return config;
};

const responseErrorHandler = (err) => {
    const error = {
        status: err.response?.status,
        original: err,
        validation: {},
        message: null,
    };

    switch ( err.response?.status ) {
        case 422:
            for ( let field in err.response.data.errors ) {
                error.validation[field] = err.response.data.errors[field][0];
            }
            break;
        case 404:
            error.message = 'Ошибка 404. Запрашиваемый ресурс не найден.';
            break;
        case 403:
            error.message = 'Доступ к этому ресурсу закрыт.';
            break;
        case 401:
            error.message = 'Пароль или email введены неверно.';
            break;
        case 500:
            error.message = 'Сервер не отвечает. Попробуйте позже.';
            break;
        default:
            error.message = 'Ошибка сервера. Попробуйте позже.';
    }

    return error;
};

http.interceptors.request.use(
    convertPostToFormData,
    (err) => Promise.reject(err),
);

http.interceptors.request.use(
    tokenHandler,
    (err) => Promise.reject(err),
);

const toastHandler = (response) => {
    if ( response.data.status ) {
        const message = response.data.message;
        switch ( response.data.status ) {
            case 'success':
                $toast.success(message);
                break;
            case 'error':
                $toast.error(message);
                break;
            default:
                $toast.warning(message);
        }
    }
};

http.interceptors.response.use(
    (response) => {
        toastHandler(response);
        return response;
    },
    (err) => Promise.reject(responseErrorHandler(err)),
);

export default http;
