<script>
	export default {
		setup() {
			document.title = "IBBACH | Home"
		}
	}
</script>
<template>
	<main id="Home-page">
		<h1>Instituto Bíblico Betel Anexo Chalatenango</h1>
		<p>Pagina de inicio</p>
		<router-link to="/admin">Admin</router-link> | 
		<router-link to="/secretaria">Secretaria</router-link> | 
		<router-link to="/docente">Docente</router-link> | 
		<router-link to="/estudiante">Estudiante</router-link> | 
	</main>
</template>