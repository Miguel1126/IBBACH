<script setup>
import EcclesiasticalInformation from "./EcclesiasticalInformation.vue"
import PersonalInformation from "./PersonalInformation.vue"
import MinisterialInformation from "./MinisterialInformation.vue"
import { useVuelidate } from '@vuelidate/core'
import { required, helpers } from '@vuelidate/validators'
</script>

<script>
export default {
    data() {
        return {
            v$: useVuelidate(),
            formData: {},
            img: '',
            thumbnailImage: ''
        }
    },
    validations() {
        return {
            img: { required: helpers.withMessage('Agregar una imagen es obligatorio', required) }
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
            this.thumbnailImage = null
            this.img = null
        },
        async submitForm() {
            const button = document.querySelector('#submit-btn')
            button.disabled = 'true'
            button.value = 'Enviando...'
            this.getData()
            this.v$.$validate()
            // console.log(this.v$)
            if (!this.v$.$error) {
                try {
                    let data = new FormData;
                    data.append('img', this.img);
                    Object.keys(this.formData).forEach(form => {
                        data.append(form, this.formData[form]);
                    });
                    const response = await this.axios.post('/api/aplicante', data);
                    if (response.status === 201) {
                        if (typeof (response.data) === 'object') {
                            this.clearInputs()
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
            }

            button.value = `Enviar formulario`
            button.disabled = ''
        },
        getImage(e) {
            let file = e.target.files[0];
            let fileInput = document.getElementById('formFile');
            let filePath = fileInput.value;
            let allowedExtensions = /(.jpg|.jpeg)$/i;
            if (!allowedExtensions.exec(filePath)) {
                alert('La extension de la imagen debe ser .jpg o .jpeg');
                fileInput.value = '';
                return false;
            }
            this.img = file;
            this.showImage(file);
        },
        showImage(file) {
            let reader = new FileReader();
            reader.onload = (e) => {
                this.thumbnailImage = e.target.result;

            }
            reader.readAsDataURL(file);
        }
    },
    computed: {
        images() {
            return this.thumbnailImage;
        }
    }
}
</script>

<template>
    <div class="container-fluid d-block">
        <div class="m-0 rounded form-container">
            <h2 class="text-center m-4 text-black">Formulario de inscripción</h2>
            <h4 class="text-center m-3 text-black">Ingresa tus datos a continación, revisa muy bien la información antes
                de enviarla.</h4>
            <form @submit.prevent="submitForm" class="d-block p-5" action="" enctype="multipart/form-data">
                <div class="d-flex justify-content-center">
                    <label for="formFile" class="btn btn-success m-3">Selecciona una foto</label>
                    <input class="d-none" type="file" id="formFile" @change="getImage" accept=".jpg">
                </div>
                <div class="d-flex justify-content-center"><span class="text-danger" v-if="v$.img.$error">{{
                v$.img.$errors[0].$message}}</span></div>
                <div class="d-flex justify-content-center">
                    <div class="m-3" v-if="thumbnailImage"><img :src="images" class="img-fluid rounded shadow"
                            style="width: 200px; height: 200px" />
                    </div>
                </div>
                <PersonalInformation ref="personalInfo" @personalInfo="getPersonalInformation($event)" />
                <EcclesiasticalInformation ref="ecclesiasticalInfo"
                    @ecclesiasticalInfo="getEcclesiasticalInfo($event)" />
                <MinisterialInformation ref="ministerialInfo" @ministerialInfo="getMinisterialInformation($event)" />
                <input type="submit" id="submit-btn" class="btn btn-primary m-3 text-light" value="Enviar formulario" />
            </form>
        </div>
    </div>
</template>

<style scoped>
.form-container {
    background: var(--bs-gray-400);
    border: 6px solid #ccc;
}

.questions-container {
    display: grid;
    justify-content: left;
}
</style>