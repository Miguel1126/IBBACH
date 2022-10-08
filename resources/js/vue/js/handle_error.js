import { router } from '../router/index'
import { useUserStore } from '../stores/user'
import { removeToken } from './handle_token'


export const handleErrors = (error) => {
    const userStore = useUserStore()

    if (error.response.status == 401 || error.response.status == 498) {
        router.push("/login")
        removeToken(userStore.user.role)
    }
}