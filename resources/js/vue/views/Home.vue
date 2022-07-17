<script>
import Nav from '../components/Nav.vue'
	export default {
		components: {
    Nav,
},
		setup() {
			document.title = "IBBACH | Home"
		}
	}
</script>
<template>
	<main id="Home-page">
		<Nav />
		<h1>Instituto Bíblico Betel Anexo Chalatenango</h1>
		<p>Pagina de inicio</p>
		<router-link to="/admin">Admin</router-link> | 
		<router-link to="/secretaria">Secretaria</router-link> | 
		<router-link to="/docente">Docente</router-link> | 
		<router-link to="/estudiante">Estudiante</router-link> |
		<router-link to="/informacion-personal">Formulario de ingreso - personal</router-link> |
		<router-link to="/informacion-eclesiastica">Formulario de ingreso - eclesiastica</router-link> |
		<router-link to="/informacion-ministerial">Formulario de ingreso - ministerial</router-link> |
		<div>
			<router-view />
		</div>
	</main>
</template> 
