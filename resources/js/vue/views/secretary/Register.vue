<script>
    export default{
        data(){
        return{
            name: '',
            last_name: '',
            code: '',
            password: '',
            password_confirmation: '',
            role: ''
        }
    },

        methods: {
           async handleSubmit(){
           const response = await this.axios.post('/api/register', {
                name: this.name,
                last_name: this.last_name,
                code: this.code,
                password: this.password,
                password_confirmation: this.password_confirmation,
                role: this.role
            });
            if (response.status === 200) {
                this.$swal.fire(
                        'Listo',
                        'Se registró el usuario',
                        'success'
                    )
            }
        }
        }
    }
</script>

<template>
    <form @submit.prevent="handleSubmit">
        <h3>Registrar usuario</h3>
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" v-model="name" placeholder="Nombre"/>
        </div>
        <div class="form-group">
            <label>Apellido</label>
            <input type="text" class="form-control" v-model="last_name" placeholder="Apellido"/>
        </div>
        <div class="form-group">
            <label>Código</label>
            <input type="text" class="form-control" v-model="code" placeholder="codigo"/>
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" class="form-control" v-model="password" placeholder="Contraseña"/>
        </div>
        <div class="form-group">
            <label>Confirmar contraseña</label>
            <input type="password" class="form-control" v-model="password_confirmation" placeholder="Confirmar contraseña"/>
        </div>
        <div class="form-group">
            <label>Tipo de usuario</label>
            <input type="text" class="form-control" v-model="role" placeholder="Rol de ususario"/>
        </div>
        <button class="btn btn-primary btn-block">Registrarse</button>
    </form>
</template>