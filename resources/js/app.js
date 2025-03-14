import 'bootstrap';
import "./components/bookmark.js";
import "./components/search.js";
import "./components/permissions_update.js";
import "./components/role_update.js";

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
