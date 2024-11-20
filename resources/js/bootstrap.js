import 'bootstrap';

import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import DataTable from 'datatables.net-dt';

import 'daterangepicker';
import 'daterangepicker/daterangepicker.css';

