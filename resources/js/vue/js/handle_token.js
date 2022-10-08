import axios from "axios";
import { useRouter } from "vue-router";
import { useUserStore } from "../stores/user";

export const handleToken = async (role) => {

    const router = useRouter();
    const userStore = useUserStore();
    const endPoint = "/api/getUser";

    const localStorageValue = {
        admin: "auth",
        secretaria: "access",
        docente: "permission",
        alumno: "token",
    };

    const token = localStorage.getItem(localStorageValue[role]);

    if (token) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
        try {
            const response = await axios.get(endPoint, token);
            if (response.data.role !== role) {
                router.push("/login");
            }
            else {
                userStore.setUser(response.data);
                return { status: "authenticated", token: token };
            }
        } catch (error) {
            if (error.response.status === 401) {
                removeToken(role)
                router.push("/login");
            }
            if (error.response.status === 500) {
                return "error";
            }
        }
    } else {
        router.push("/login");
    }

    return ''
}

export const removeToken = (role) => {
    console.log(role)
    const localStorageValue = {
        admin: "auth",
        secretaria: "access",
        docente: "permission",
        alumno: "token",
    };

    if (localStorage.getItem(localStorageValue[role])) localStorage.removeItem(localStorageValue[role])
}