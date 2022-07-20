<script setup>
    import EcclesiasticalInformation from "./EcclesiasticalInformation.vue"
    import PersonalInformation from "./PersonalInformation.vue"
    import MinisterialInformation from "./MinisterialInformation.vue"
</script>

<script>
export default {
    data() {
        return {
            formData: {
                personalInformation:{},
                ecclesiasticalInformation: {},
                ministerialInformation: {}
            }
        }
    },
    methods: {
        getPersonalInformation(data) {
            this.formData.personalInformation = data
            console.log(this.formData.personalInformation)
        },
        getEcclesiasticalInfo(data) {
            this.formData.ecclesiasticalInformation = data
            console.log(this.formData.ecclesiasticalInformation)
        },
        getMinisterialInformation(data) {
            this.formData.ministerialInformation = data
            console.log(this.formData.ministerialInformation)
        },
        getData() {
            this.$refs.personalInfo.passData()
            this.$refs.ecclesiasticalInfo.passData()
            this.$refs.ministerialInfo.passData()
        },
        sendForm() {

            this.getData()

            /* const response = await this.axios.post('/api/aplicante', this.formData)
            console.log(response) */

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
        <form @submit.prevent="sendForm" class="d-block p-5" action="">
            <PersonalInformation ref="personalInfo" @personalInfo="getPersonalInformation($event)" />
            <EcclesiasticalInformation ref="ecclesiasticalInfo" @ecclesiasticalInfo="getEcclesiasticalInfo($event)" />
            <MinisterialInformation ref="ministerialInfo" @ministerialInfo="getMinisterialInformation($event)"/>
            <input type="submit" class="btn btn-primary text-light" value="Enviar formulario" />
         </form>
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