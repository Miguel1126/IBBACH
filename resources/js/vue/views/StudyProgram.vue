<script>
import Nav from '../components/Nav.vue';
import levelbasic from './LevelBasic.vue'
import LevelBasic from './LevelBasic.vue';
import MinisterialLevel from './MinisterialLevel.vue';
import SpecializedLevel from './SpecializedLevel.vue';
export default {
    data() {
        return {
            siteUrl: window.location.origin,
            tabs: ["basic", "minsterial", "specialized"],
            tab: "basic",
            defaultClass: "btn text-light m-1 mb-0",
            tabStyle1: "btn text-light m-1 mb-0 focused",
            tabStyle2: "btn text-light m-1 mb-0",
            tabStyle3: "btn text-light m-1 mb-0",
        }
    },
    components: {
    Nav,
    levelbasic,
    LevelBasic,
    MinisterialLevel,
    SpecializedLevel,
    siteUrl: window.location.origin,
},
    methods: {
        toggleComponents(tab) {
            switch (tab) {
                case 1:
                    this.tab = this.tabs.at(0);
                    this.tabStyle1 += " focused";
                    this.tabStyle2 = this.defaultClass;
                    this.tabStyle3 = this.defaultClass;
                    break;
                case 2:
                    this.tab = this.tabs.at(2);
                    this.tabStyle1 = this.defaultClass;
                    this.tabStyle2 += " focused";
                    this.tabStyle3 = this.defaultClass;
                    break;
                case 3:
                    this.tab = this.tabs.at(3);
                    this.tabStyle1 = this.defaultClass;
                    this.tabStyle2 = this.defaultClass;
                    this.tabStyle3 += " focused";
                    break;
                default:
                    break;
            }
        }
    }
}
</script>
<template>
    <nav class="navbar navbar-expand-lg ">
  <div class="container-fluid">
    <a class="navbar-brand" href="http://127.0.0.1:8000/"><img class=" img-fluid logo-image" :src="`${siteUrl}/images/logo.jpg`" /></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item m-1">
			<router-link class="links link" to="/login">Iniciar Sesión</router-link>
        </li>
        <li class="nav-item m-1">
			<router-link class="links link" to="/aplicante/formulario">Solicitud de Ingreso</router-link>
        </li>
        <li class="nav-item m-1">
			<router-Link class="links link" to="/ProgramaEstudio">Programa de estudio</router-Link>
        </li>
      </ul>
    </div>
  </div>
</nav>
    
        <h1>Programa de estudios</h1>
        <div class="d-block">
            <div class="d-flex tabs">
                <div :class="tabStyle1" @click="toggleComponents(1)">Basico</div>
                <div :class="tabStyle2" @click="toggleComponents(2)">Ministerial</div>
                <div :class="tabStyle3" @click="toggleComponents(3)">Especializado</div>
            </div>
            <div class="w-100 h-100 rounded component-container p-4">

                <LevelBasic v-if="tab === tabs.at(0)"></LevelBasic>
                <MinisterialLevel v-if="tab === tabs.at(2)"></MinisterialLevel>
                <SpecializedLevel v-if="tab === tabs.at(3)"></SpecializedLevel>
            </div>
        </div>
    
    
</template>
<style scoped>
.navbar {
	display: flex;
	justify-content: space-between;
	background-color: var(--dark-alt);
}

.links{
	color: #eee;
	text-decoration: none;
	font-style: 1.5em;
	
}
.link:hover{
	background-color: var(--dark);
	padding: 5px;
	border-radius: 13px;
}

.logo-image {
    width: 50px;
    height: 50px;
    margin-left: 9px;
    border-radius: 3px;
}

.tabs div {
    background-color: var(--dark);
}

.focused {
    background-color: var(--dark-alt) !important;
}

.component-container {
    background-color: var(--dark-alt);
}

@media (max-width: 1025px) {
    .component-container {
        padding: 3px !important;
    }
}




</style>

