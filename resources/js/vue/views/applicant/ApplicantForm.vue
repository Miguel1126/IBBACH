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
                registration_date: ''
            }
        }
    },
    methods: {
        getPersonalInformation(data) {
            let entries = Object.entries(data)
            entries.forEach(elm => {
                this.formData[elm[0]] = elm[1]
            })
        },
        getEcclesiasticalInfo(data) {
            let entries = Object.entries(data)
            entries.forEach(elm => {
                this.formData[elm[0]] = elm[1]
            })
        },
        getMinisterialInformation(data) {
            let entries = Object.entries(data)
            entries.forEach(elm => {
                this.formData[elm[0]] = elm[1]
            })
        },
        getData() {
            this.$refs.personalInfo.passData()
            this.$refs.ecclesiasticalInfo.passData()
            this.$refs.ministerialInfo.passData()
        },
        clearInputs() {
            this.$refs.personalInfo.clearInputs()
            this.$refs.ecclesiasticalInfo.clearInputs()
            this.$refs.ministerialInfo.clearInputs()
        },
        async sendForm() {
            const button = document.querySelector('#submit-btn')
            button.disabled = 'true'
            button.value = 'Enviando...'


            this.getData()

            const date = new Date()
            const formatedDate = `${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`
            this.formData.registration_date = formatedDate

            try {
                const response = await this.axios.post('/api/aplicante', this.formData)
                if (response.status === 201) {
                    if (typeof (response.data) === 'object') {
                        this.$swal.fire(
                            'Listo',
                            '¡El Formulario de ingreso se ha enviado correctamente!',
                            'success'
                        )
                    }
                }
                else {
                    this.$swal.fire(
                        'Error',
                        'Ocurrió un error, intentalo de nuevo',
                        'error'
                    )
                    console.log(response)
                }
            }
            catch (error) {
                this.$swal.fire(
                    'Error',
                    'Ocurrió un error, intentalo de nuevo',
                    'error'
                )
                console.error(error)
            }

            button.value = `Enviar formulario`
            button.disabled = ''
            this.clearInputs()
        }
    }
}
</script>

<template>
    <div class="container-fluid d-block">
        <div class="m-auto">
            <h2 class="text-center m-4 form-title">Formulario de inscripción</h2>
            <h4 class="text-center m-3">Ingresa tus datos a continación, revisa muy bien la información antes de
                enviarla.</h4>
        </div>
        <div class="m-5 rounded form-container">
            <form @submit.prevent="sendForm" class="d-block p-5" action="">
                <PersonalInformation ref="personalInfo" @personalInfo="getPersonalInformation($event)" />
                <EcclesiasticalInformation ref="ecclesiasticalInfo"
                    @ecclesiasticalInfo="getEcclesiasticalInfo($event)" />
                <MinisterialInformation ref="ministerialInfo" @ministerialInfo="getMinisterialInformation($event)" />
                <input type="submit" id="submit-btn" class="btn btn-primary text-light" value="Enviar formulario" />
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