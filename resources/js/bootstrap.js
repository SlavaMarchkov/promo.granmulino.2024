import axios from 'axios';
import * as bootstrap from 'bootstrap';

const brand = import.meta.env.VITE_APP_NAME;

window.bootstrap = bootstrap;
window.axios = axios;
window.brand = brand;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
window.axios.defaults.withXSRFToken = true;
