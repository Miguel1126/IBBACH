<script setup>
    
</script>
<template>
    <h1>Hola Mundo</h1>
    <nav>
        <router-link to="/hola">Hola</router-link> |
        <router-link to="/como">Como</router-link> |
        <router-link to="/estas">Estas</router-link>
    </nav>
    <router-view></router-view>
</template>