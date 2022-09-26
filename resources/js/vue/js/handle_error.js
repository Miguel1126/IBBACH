import { router } from '../router/index'

export const handleErrors = (error) => {

    if (error.response.status == 401 || error.response.status == 498) {
        router.push("/login")
    }
}