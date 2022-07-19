<script setup>
    import EcclesiasticalInformation from "./EcclesiasticalInformation.vue"
    import PersonalInformation from "./PersonalInformation.vue"
    import MinisterialInformation from "./MinisterialInformation.vue"
</script>

<script>
export default {
    data() {
        return {
            personalInformation:{},
            ecclesiasticalInformation: {},
            ministerialInformation: {}
        }
    },
    methods: {
        getPersonalInformation(data) {
            this.personalInformation = data
            console.log(this.personalInformation)
        },
        getEcclesiasticalInfo(data) {
            this.ecclesiasticalInformation = data
            console.log(this.ecclesiasticalInformation)
        },
        getMinisterialInformation(data) {
            this.ministerialInformation = data
            console.log(this.ministerialInformation)
        },
        getData() {
            this.$refs.personalInfo.passData()
            this.$refs.ecclesiasticalInfo.passData()
            this.$refs.ministerialInfo.passData()
        }
    }
}
</script>

<template>
    <div class="container-fluid d-block">
    <div class="m-auto">
        <h2 class="text-center m-4 form-title">Formulario de inscripción</h2>
        <h4 class="text-center m-3">Ingresa tus datos a continación, revisa muy bien la información antes de enviarla.</h4>
    </div>
    <div class="m-5 rounded form-container">
        <form class="d-block p-5" action="">
            <PersonalInformation ref="personalInfo" @personalInfo="getPersonalInformation($event)" />
            <EcclesiasticalInformation ref="ecclesiasticalInfo" @ecclesiasticalInfo="getEcclesiasticalInfo($event)" />
            <MinisterialInformation ref="ministerialInfo" @ministerialInfo="getMinisterialInformation($event)"/>
         </form>
         <button @click="getData">Click</button>
    </div>
</div>
</template>

<style scoped>
    .form-title {
        text-shadow: 2px 2px 3px rgb(0, 0, 0);
    }
    .form-container {
        background: var(--bs-gray-400);
        border: 6px solid #ccc;
    }
    .section-title {
        text-decoration: underline;
    }
    .questions-container {
        display: grid;
        justify-content: left;
    }
</style>