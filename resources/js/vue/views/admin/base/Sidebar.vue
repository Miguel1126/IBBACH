<script setup>
import '../../../styles/side-nav-bar.scss'
import Link from '../../../components/Link.vue'
import { ref } from 'vue'
import logoURL from '../../../assets/logo.jpg'
import ProfileInfo from '../../../components/ProfileInfo.vue';
const is_expanded = ref(localStorage.getItem("is_expanded") === "true")
const ToggleMenu = () => {
	is_expanded.value = !is_expanded.value
	localStorage.setItem("is_expanded", is_expanded.value)
}
</script>

<template>
	<div class="d-flex">
		<nav class="navbar nav w-100 d-flex justify-content-between" :class="`${is_expanded ? 'navbar-reduced' : ''}`">
			<div class="d-flex align-items-center">
				<div class="navbar-toggle menu-toggle-wrap mx-3">
					<button class="menu-toggle d-flex" @click="ToggleMenu">
						<span class="material-icons fs-1 text-light">keyboard_double_arrow_right</span>
					</button>
				</div>
				<span class="navbar-title mb-0">Instituto Bíblico Betel Anexo Chalatenango</span>
			</div>
			<ProfileInfo></ProfileInfo>
		</nav>
		<aside :class="`${is_expanded ? 'is-expanded' : ''}`">
			<div class="logo">
				<router-link class="home-link" to="/">
					<img :src="logoURL" alt="IBBACH" />
				</router-link>
			</div>

			<div class="menu-toggle-wrap">
				<button class="menu-toggle" @click="ToggleMenu">
					<span class="material-icons">keyboard_double_arrow_right</span>
				</button>
			</div>

			<h3>Menu</h3>
			<div class="menu">
				<Link url="Loads" name="Cargas" icon="dataset">
				</Link>
				<Link url="Subject" name="Materias" icon="collections_bookmark">
				</Link>
				<Link url="Cycles" name="Ciclos" icon="autorenew">
				</Link>
				<Link url="Schedules" name="Horarios" icon="schedule">
				</Link>
			</div>

			<h3>Reportes</h3>
			<div class="menu">
				<Link url="Reports" name="Reportes" icon="folder_open">
				</Link>
			</div>
		</aside>
	</div>
	<div class="sidebar-cover" :class="`${is_expanded ? 'cover' : ''}`" @click="ToggleMenu"></div>
</template>