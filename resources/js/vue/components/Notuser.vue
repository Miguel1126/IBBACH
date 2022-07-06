<script>
name: 'Notuser'
import Nav from './Nav.vue'
    export default{
        components: {
    Nav
}
    }
</script>

<template>
    <div id="app">
       <Nav />
        <div class="auth-wrapper">
            <div class="auth-inner">
                <p>no es un usuario registrado</p>
            </div>
        </div>
    </div>
</template>