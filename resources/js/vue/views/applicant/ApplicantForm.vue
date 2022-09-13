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
            },
            img: '',
            thumbnailImage: ''
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

            try {
                let data = new FormData;
                data.append('img', this.img);
                data.append('name', this.formData.name);
                data.append('last_name', this.formData.last_name);
                data.append('email', this.formData.email);
                data.append('phone', this.formData.phone);
                data.append('address', this.formData.address);
                data.append('nationality', this.formData.nationality);
                data.append('birth_date', this.formData.birth_date);
                data.append('marital_status', this.formData.marital_status);
                data.append('mate_name', this.formData.mate_name);
                data.append('secular_degree', this.formData.secular_degree);
                data.append('current_ocupation', this.formData.current_ocupation);
                data.append('is_pastor', this.formData.is_pastor);
                data.append('is_member', this.formData.is_member);
                data.append('pastor_phone', this.formData.pastor_phone);
                data.append('church_name', this.formData.church_name);
                data.append('church_address', this.formData.church_address);
                data.append('church_phone', this.formData.church_phone);
                data.append('district', this.formData.district);
                data.append('pastor_name', this.formData.pastor_name);
                data.append('licence', this.formData.licence);
                data.append('reference_name_one', this.formData.reference_name_one);
                data.append('reference_phone_one', this.formData.reference_phone_one);
                data.append('reference_name_two', this.formData.reference_name_two);
                data.append('reference_phone_two', this.formData.reference_phone_two);
                data.append('christ_accepted', this.formData.christ_accepted);
                data.append('christening_date', this.formData.christening_date);
                data.append('time_being_member', this.formData.time_being_member);
                data.append('privileges_held', this.formData.privileges_held);
                data.append('denomination', this.formData.denomination);
                data.append('study_reason', this.formData.study_reason);
                data.append('ministry_performed', this.formData.ministry_performed);
                data.append('current_ministry', this.formData.current_ministry);
                data.append('full_time', this.formData.full_time);
                data.append('ministry_qualification', this.formData.ministry_qualification);
                data.append('aspirated_ministry', this.formData.aspirated_ministry);
                data.append('reason_aspiring_ministry', this.formData.reason_aspiring_ministry);
                data.append('cicle_to_be_taken', this.formData.cicle_to_be_taken);
                data.append('previous_institution', this.formData.previous_institution);
                data.append('last_year_studied', this.formData.last_year_studied);
                data.append('qualities_religious_worker', this.formData.qualities_religious_worker);
                const response = await this.axios.post('/api/aplicante', data,{
                });
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
        },
        getImage(e){
            let file = e.target.files[0];
            console.log(file);
            this.img = file;
            this.showImage(file);
        },
        showImage(file){
            let reader = new FileReader();
            reader.onload = (e) => {
                this.thumbnailImage = e.target.result;

            }
            reader.readAsDataURL(file);
        }
    },
    computed: {
        images(){
            return this.thumbnailImage;
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
            <form @submit.prevent="submitForm" class="d-block p-5" action="" enctype="multipart/form-data">
                <div>
                    <label for="formFile" class="btn btn-success">Select Image</label>
                    <input class="d-none" type="file" id="formFile" @change="getImage">
                    <div class="m-3"><img :src="images" class="img-fluid"/></div>
                </div>
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