import axios from 'axios'
export const setAxiosHeader = () => {
    if (localStorage.getItem('auth')) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('auth')
    }
    if (localStorage.getItem('access')) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('access')
    }
    if (localStorage.getItem('permission')) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('permission')
    }
    if (localStorage.getItem('token')) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
    }
}