import { createApp } from 'vue'
import App from './App.vue'
import { router } from './router'
import axios from 'axios'
import VueAxios from 'vue-axios'

import { setAxiosHeader } from './js/set_axios_header'

import './styles/app.scss'
import './styles/index.css'

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

setAxiosHeader()

createApp(App).use(router).use(VueAxios, axios).use(VueSweetalert2).mount('#app')