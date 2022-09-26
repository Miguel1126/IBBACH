<script>
export default {
    mounted() {
        this.showUserLogged()
    },
    data() {
        return {
            user : ''
        }
    },
    methods: {
        showUserLogged() {
            if (localStorage.getItem('auth')) {
                this.user += 'Admin, '
            }
    
            if (localStorage.getItem('access')) {
                this.user += 'Secretaria, '
            }

            if (localStorage.getItem('permission')) {
                this.user += 'Docente, '
            }

            if (localStorage.getItem('token')) {
                this.user += 'Alumno, '
            }
        }
    }
}
</script>

<template>
    <nav class="navbar navbar-expand navbar-dark fixed-top">
        <div class="container">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/login">Iniciar Sesión</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/secretaria/register">Registrar</router-link>
                    </li>
                    <div class="position-absolute top-0 end-0 m-3">
                        <p class="fs-4">Has iniciado sesión como: {{ user }}</p>
                    </div>
                </ul>
            </div>
        </div>
    </nav>

</template>
<style>
</style>