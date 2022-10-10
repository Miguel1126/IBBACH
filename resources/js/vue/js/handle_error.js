import { router } from '../router/index'
import { useUserStore } from '../stores/user'
import { removeToken } from './handle_token'

/**
 * 
 * @param {Object} error
 * 
 * Esta función ayuda a redireccionar el usuario al login cuando el token ha expirado, la sesión se ha cerrado o el token no tiene permiso para ejecutar dicha acción 
 */
export const handleErrors = (error) => {
    const userStore = useUserStore()

    if (error.response.status == 401 || error.response.status == 498) {
        router.push("/login")
        removeToken(userStore.user.role)
    }
}