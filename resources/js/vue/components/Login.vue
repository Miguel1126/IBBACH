<script>
    export default{
    
    }
</script>

<template>
    <form>
        <h3>Login</h3>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" v-model="email" placeholder="Email"/>
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" class="form-control" v-model="password" placeholder="Contraseña"/>
        </div>
        <button class="btn btn-primary btn-block">Iniciar Sesión</button>
    </form>
</template>