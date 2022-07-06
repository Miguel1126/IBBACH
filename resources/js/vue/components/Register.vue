<script>
import axios from 'axios';
    export default{
        data(){
        return{
            name: '',
            last_name: '',
            email: '',
            password: '',
            password_confirm: '',
            role: ''
        }
    },

        methods: {
           async handleSubmit(){
           const response = await axios.post('http://127.0.0.1:8000/Register', {
                name: this.name,
                last_name: this.last_name,
                email: this.email,
                password: this.password,
                password_confirm: this.password_confirm,
                role: this.role
            });
            console.log(response);
        }
        }
    }
</script>

<template>
    <form @submit.prevent="handleSubmit">
        <h3>Sign up</h3>
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" v-model="name" placeholder="Nombre"/>
        </div>
        <div class="form-group">
            <label>Apellido</label>
            <input type="text" class="form-control" v-model="last_name" placeholder="Apellido"/>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" v-model="email" placeholder="Correo electronico"/>
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" class="form-control" v-model="password" placeholder="Contraseña"/>
        </div>
        <div class="form-group">
            <label>Confirmar contraseña</label>
            <input type="password" class="form-control" v-model="password_confirm" placeholder="Confirmar contraseña"/>
        </div>
        <div class="form-group">
            <label>Tipo de usuario</label>
            <input type="text" class="form-control" v-model="role" placeholder="Rol de ususario"/>
        </div>
        <button class="btn btn-primary btn-block">Registrarse</button>
    </form>
</template>