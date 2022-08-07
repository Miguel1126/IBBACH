<script>
export default {
    name: 'Nav'
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
                </ul>
            </div>
        </div>
    </nav>

</template>
<style>
</style>