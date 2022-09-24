<script setup>
import '../../../styles/side-nav-bar.scss'
import Link from '../../../components/Link.vue'
import { ref } from 'vue'
import logoURL from '../../../assets/logo.jpg'
const is_expanded = ref(localStorage.getItem("is_expanded") === "true")
const ToggleMenu = () => {
	is_expanded.value = !is_expanded.value
	localStorage.setItem("is_expanded", is_expanded.value)
}
</script>

<template>
	<div class="d-flex">
		<nav class="navbar nav w-100" :class="`${is_expanded ? 'navbar-reduced' : ''}`">
			<div class="d-flex align-items-center">
				<div class="navbar-toggle menu-toggle-wrap mx-3">
					<button class="menu-toggle d-flex" @click="ToggleMenu">
						<span class="material-icons fs-1 text-light">keyboard_double_arrow_right</span>
					</button>
				</div>
				<span class="navbar-title navbar-brand mb-0">Instituto Bíblico Betel Anexo Chalatenango</span>
			</div>
		</nav>
		<aside :class="`${is_expanded ? 'is-expanded' : ''}`">
			<div class="logo">
				<router-link class="home-link" to="/">
					<img :src="logoURL" alt="Vue" />
				</router-link>
			</div>

			<div class="menu-toggle-wrap">
				<button class="menu-toggle" @click="ToggleMenu">
					<span class="material-icons">keyboard_double_arrow_right</span>
				</button>
			</div>

			<h3>Menu</h3>
			<div class="menu">
				<Link url="Testtea" name="Test" icon="home">
				</Link>
				<Link url="Assistances" name="Asistencia" icon="today">
				</Link>
				<Link url="Notes" name="Notas" icon="note_alt">
				</Link>
			</div>

			<div class="flex"></div>

			<div class="menu">
				<!-- <Link url="/settings" name="Settings" icon="settings"></Link> -->
			</div>
		</aside>
	</div>
	<div class="sidebar-cover" :class="`${is_expanded ? 'cover' : ''}`" @click="ToggleMenu"></div>
</template>