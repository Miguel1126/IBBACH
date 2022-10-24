<script setup>
import axios from 'axios';
import { handleErrors } from '../js/handle_error';

const props = defineProps({
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

const downloadPDF = async () => {
    try {
        const response = await axios.get(`/api/newUser/pdf?name=${props.userinfo.user.name} ${props.userinfo.user.last_name}&code=${props.userinfo.user.code}&password=${props.userinfo.pass}`, { responseType: 'blob' })
        const href = URL.createObjectURL(response.data);
        console.log(response.data)
        const link = document.createElement('a');
        link.href = href;
        let pdfname = props.userinfo.user.name + ' ' + props.userinfo.user.last_name
        link.setAttribute('download', `${pdfname}.pdf`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(href);
    } catch (error) {
        console.log(error)
        handleErrors(error)
    }

}

const exportPDF = async () => {
    try {
        const response = await axios.get(`/api/newUser/pdf?name=${props.userinfo.user.name} ${props.userinfo.user.last_name}&code=${props.userinfo.user.code}&password=${props.userinfo.pass}`, { responseType: 'blob' })
        const href = URL.createObjectURL(response.data);
    
        const link = document.createElement('a');
        link.href = href;
        link.setAttribute('target', '_blank');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(href);
    } catch (error) {
        console.log(error)
        handleErrors(error)
    }

}
</script>
<template>
    <div class="card-container mt-4 d-flex">
        <div class="profile-card p-4 bg-dark text-light w-75 rounded">
            <div>
                <div class="alert alert-success alert-dismisable fade show d-flex" role="alert">
                    <span class="material-icons d-flex align-items-center me-3">check</span> <span>¡{{
                            userinfo.user.role == 'admin' ? 'Admin' : userinfo.user.role == 'secretaria' ? 'Secretaria' :
                                userinfo.user.role == 'docente' ? 'Docente' : userinfo.user.role == 'alumno' ? 'Alumno' :
                                    'Usuario'
                    }} {{ changedpass ? 'actualizado/a' : 'registrado/a' }} exitosamente!</span>
                </div>
            </div>
            <div>
                <p class="fs-5"><b>Nombre del usuario:</b> {{ userinfo.user.name }} {{ userinfo.user.last_name }}</p>
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
            <div class="d-flex flex-grap gap-2">
                <button class="btn btn-danger d-inline-flex" @click="downloadPDF">Descargar<span
                        class="material-symbols-outlined">file_download</span></button>
                <button class="btn btn-danger d-inline-flex gap-1" @click="exportPDF">Preview<span
                        class="material-symbols-outlined">visibility</span></button>
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

@media (max-width: 1025px) {
    .card-container {
        width: 100% !important;
    }

    .profile-card {
        width: inherit !important;
        padding: 4px !important;
    }

    .fs-5 {
        font-size: 1.3em !important;
    }
}
</style>