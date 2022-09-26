<script setup>
import { ref } from "@vue/reactivity";
import axios from "axios";
import Swal from "sweetalert2";
import { handleErrors } from "../js/handle_error";
import { router } from "../router";
import { useUserStore } from "../stores/user";

const userStore = useUserStore()

const loading = ref(false)

const closeSession = async () => {
    loading.value = true

    const localStorageValue = {
        admin: "auth",
        secretaria: "access",
        docente: "permission",
        alumno: "token",
    };

    try {
        const response = await axios.post('/api/logout')
        if (response.status === 200) {
            localStorage.removeItem(localStorageValue[userStore.user.role])
            router.push("/login")
        }
    } catch (error) {
        handleErrors(error)
        Swal.fire("Error", "No se pudo cerrar la sesión", "error")
    }

    loading.value = false
}

</script>

<template>
    <div class="dropdown profile-info">
        <button class="profile-button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            <img src="https://pbs.twimg.com/profile_images/1467668510893559812/dOiA_l1Z_400x400.jpg" alt="">
        </button>
        <div class="dropdown-menu p-4">
            <h5>{{ userStore.user.name }} {{ userStore.user.last_name }}</h5>
            <p class="text-secondary fs-5">{{ userStore.user.code }}</p>
            <hr>
            <button class="btn btn-outline-secondary bg-muted btn-lg" v-if="!loading"
                @click.prevent="closeSession()">Cerrar Sesión</button>
            <div class="d-flex justify-content-center" v-else>
                <div class="mt-3 dot-pulse">
                    <div class="dot-pulse__dot"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.profile-info {
    position: fixed;
    right: 0;
    margin-right: 1.3rem;
}

.profile-button {
    width: 44px;
    height: 44px;
    border-radius: 4rem;
    background-color: var(--dark-alt);
    transition: all .2s ease;
}

.profile-button:hover {
    outline: 3px solid #747474;
}

.profile-button img {
    width: inherit;
    height: inherit;
    border-radius: inherit;
}

.dropdown-menu {
    width: 300px;
    left: unset !important;
    right: 0;
    text-align: center;
    padding: 1rem;
    border-bottom: 5px solid #7e7e7e;
}

.dot-pulse {
    --uib-size: 40px;
    --uib-speed: 1.3s;
    --uib-color: rgb(59, 59, 59);

    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: var(--uib-size);
    height: calc(var(--uib-size) * 0.27);
}

.dot-pulse__dot,
.dot-pulse::before,
.dot-pulse::after {
    content: '';
    display: block;
    height: calc(var(--uib-size) * 0.18);
    width: calc(var(--uib-size) * 0.18);
    border-radius: 50%;
    background-color: var(--uib-color);
    transform: scale(0);
}

.dot-pulse::before {
    animation: pulse var(--uib-speed) ease-in-out infinite;
}

.dot-pulse__dot {
    animation: pulse var(--uib-speed) ease-in-out calc(var(--uib-speed) * 0.125) infinite both;
}

.dot-pulse::after {
    animation: pulse var(--uib-speed) ease-in-out calc(var(--uib-speed) * 0.25) infinite;
}

@keyframes pulse {

    0%,
    100% {
        transform: scale(0);
    }

    50% {
        transform: scale(1.5);
    }
}

@media (max-width: 335px) {
    .dropdown-menu {
        width: 200px;
    }
}
</style>