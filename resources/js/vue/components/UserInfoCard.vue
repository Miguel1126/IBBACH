<script setup>
defineProps({
    userinfo: {
        required: true,
        type: Object
    },
    changedpass: Boolean
})
setTimeout(() => {
    window.scroll({
    top: screen.height,
    behavior: 'smooth'
})
}, 1000)
</script>
<template>
    <div class="mt-4 d-flex">
        <div class="p-4 bg-dark text-light w-75 rounded">
            <div>
                <div class="alert alert-success alert-dismisable fade show d-flex" role="alert">
                    <span class="material-icons d-flex align-items-center me-3">check</span> <span>¡{{
                    userinfo.user.role == 'admin' ? 'Admin' : userinfo.user.role == 'secretaria' ? 'Secretaria' :
                    userinfo.user.role == 'docente' ? 'Docente' : userinfo.user.role == 'alumno' ? 'Alumno' :
                    'Usuario' }} {{ changedpass ? 'actualizado/a' : 'registrado/a' }} exitosamente!</span>
                </div>
            </div>
            <div>
                <p class="fs-5"><b>Nombre del usuario:</b> {{ userinfo.user.name }} {{ userinfo.user.last_name}}</p>
                <p class="fs-5"><b>Código:</b> {{ userinfo.user.code }}</p>
                <p class="fs-5"><b>Contraseña:</b> {{ userinfo.pass }}</p>
                <p class="fs-5"><b>Tipo de usuario:</b> {{ userinfo.user.role }}</p>
            </div>
            <div>
                <p class="fs-9 text-muted">
                    *Esta tarjeta con los datos de inicio de sesión estará disponible hasta que recargue la pagina o
                    cambie de pestaña. <br>
                    Si desea consultar estos datos nuevamente puede hacerlo en la pestaña de <b>Administrar cuentas.</b>
                </p>
            </div>
        </div>
    </div>
</template>
<style scoped>
.alert-success {
    color: #71ff56;
    background-color: #41a00bba;
    border-color: #2cff00;
}
</style>