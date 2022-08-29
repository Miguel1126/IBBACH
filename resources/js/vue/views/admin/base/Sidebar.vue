<script setup>
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
			<Link url="Loads" name="Cargas" icon="dataset">
			</Link>
			<Link url="Groups" name="Grupos" icon="workspaces">
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
			<Link url="LoadsReport" name="Cargas" icon="summarize">
			</Link>
			<Link url="TeachersReport" name="Docentes" icon="person">
			</Link>
			<Link url="SubjectsReport" name="Asignaturas" icon="book">
			</Link>
			<Link url="CyclesReport" name="Ciclos" icon="autorenew">
			</Link>
			<Link url="ApplicantsReport" name="Aplicantes" icon="account_circle">
			</Link>
			<Link url="NotesReport" name="Notas" icon="note_alt">
			</Link>
			<Link url="AssistancesReport" name="Asistencias" icon="view_cozy">
			</Link>
			<Link url="NoteStatusReport" name="Estado" icon="groups">
			</Link>
			<Link url="UsersGroupReport" name="UsuarioGrupo" icon="report">
			</Link>
			<Link url="InscriptionsReport" name="Inscripciones" icon="report">
			</Link>
			<Link url="UsersReport" name="Usuarios" icon="report">
			</Link>
			<Link url="PaymentsPReport" name="Pagos" icon="report">
			</Link>
			<Link url="RatesReport" name="Cuotas" icon="report">
			</Link>
		</div>
	</aside>
</template>

<style lang="scss" scoped>
aside {
	position: fixed;
	display: flex;
	flex-direction: column;
	background-color: var(--dark);
	color: var(--light);
	width: calc(2rem + 32px);
	overflow: hidden;
	min-height: 100vh;
	padding: 1rem;
	z-index: 9999;
	transition: 0.2s ease-in-out;

	.flex {
		flex: 1 1 0%;
	}

	.logo {
		margin-bottom: 1rem;

		img {
			width: 2rem;
			transition: 0.2s ease-in-out;
			border-radius: 10px;
		}
	}

	.menu-toggle-wrap {
		display: flex;
		justify-content: flex-end;
		position: relative;
		top: 0;
		transition: 0.2s ease-in-out;

		.menu-toggle {
			transition: 0.2s ease-in-out;

			.material-icons {
				font-size: 2rem;
				color: var(--light);
				transition: 0.2s ease-out;
			}

			&:hover {
				.material-icons {
					color: var(--primary);
					transform: translateX(0.5rem);
				}
			}
		}
	}

	h3,
	.button .text {
		opacity: 0;
		transition: opacity 0.3s ease-in-out;
	}

	h3 {
		color: var(--grey);
		font-size: 0.875rem;
		margin-bottom: 0.5rem;
		text-transform: uppercase;
	}

	.menu {
		margin: 0 -1rem;
		margin-bottom: 1.6rem;

		.button {
			display: flex;
			align-items: center;
			text-decoration: none;
			transition: 0.2s ease-in-out;
			padding: 0.5rem 1rem;

			.material-icons {
				font-size: 2rem;
				color: var(--light);
				transition: 0.2s ease-in-out;
			}

			.text {
				color: var(--light);
				transition: 0.2s ease-in-out;
			}

			&:hover {
				background-color: var(--dark-alt);

				.material-icons,
				.text {
					color: var(--primary);
				}
			}

			&.router-link-exact-active {
				background-color: var(--dark-alt);
				border-right: 5px solid var(--primary);

				.material-icons,
				.text {
					color: var(--primary);
				}
			}
		}
	}

	.footer {
		opacity: 0;
		transition: opacity 0.3s ease-in-out;

		p {
			font-size: 0.875rem;
			color: var(--grey);
		}
	}

	&.is-expanded {
		width: var(--sidebar-width);

		img {
			margin-bottom: 30px;
			width: 150px;
			transition: 0.2s ease-in-out;
		}

		.menu-toggle-wrap {
			top: -2rem;

			.menu-toggle {
				transform: rotate(-180deg);
			}
		}

		h3,
		.button .text {
			opacity: 1;
		}

		.button {
			.material-icons {
				margin-right: 1rem;
			}
		}

		.footer {
			opacity: 0;
		}
	}

	@media (max-width: 1024px) {
		z-index: 99;
		left: -65px;
	}
}
</style>