<script>
    export default{
     data() {
        return{
            code: '',
            password: ''
        }
     },
     methods: {
         async handleSubmit(){
           const response = await this.axios.post('/api/login', {
                code: this.code,
                password: this.password
            });
            console.log(response)
            if (response.status === 200) {
                let role = response.data.role
                if(role === "admin"){
                    this.$router.push('/admin')
                }
                if(role === "secretaria"){
                    this.$router.push('/secretaria')
                }
                if(role === "docente"){
                    this.$router.push('/docente')
                }
                if(role === "alumno"){
                    this.$router.push('/alumno')
                }
            }

        }
     }
    }
</script>

<template>
    <form @submit.prevent="handleSubmit">
        <h3>Login</h3>
        <div class="form-group">
            <label>Código</label>
            <input type="text" class="form-control" v-model="code" placeholder="Código"/>
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" class="form-control" v-model="password" placeholder="Contraseña"/>
        </div>
        <input type="submit" class="btn btn-primary btn-block" value="Iniciar Sesión">
    </form>
</template>