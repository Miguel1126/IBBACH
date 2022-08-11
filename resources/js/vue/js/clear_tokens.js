export const clearTokens = () => {
    if (localStorage.getItem('auth')) {
        localStorage.removeItem('auth')
    }
    if (localStorage.getItem('access')) {
        localStorage.removeItem('access')
    }
    if (localStorage.getItem('permission')) {
        localStorage.removeItem('permission')
    }
    if (localStorage.getItem('token')) {
        localStorage.removeItem('token')
    }
}