<script>
import { useVuelidate } from '@vuelidate/core'
import { required, email, helpers, requiredIf } from '@vuelidate/validators'
import { computed, reactive } from 'vue';
export default {
    setup() {
        const state = reactive({
            personalInfo: {
                name: '',
                last_name: '',
                email: '',
                phone: null,
                address: '',
                nationality: '',
                birth_date: '',
                marital_status: '',
                mate_name: '',
                secular_degree: '',
                current_ocupation: ''
            }
        })
        const rules = computed(() => {
            const alpha = helpers.regex(/^[ a-zA-ZñÑáéíóúÁÉÍÓÚ'° ]+$/) 
            const alpha2 = helpers.regex(/^[ a-zA-ZñÑáéíóúÁÉÍÓÚ,.:;'° ]+$/)
            const alpha3 = helpers.regex(/^[ a-zA-ZñÑáéíóúÁÉÍÓÚ,.:;0-9'° ]+$/)
            const phone = helpers.regex(/^[0-9](\d{7})$/)    
            return {
                personalInfo: {
                name: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras',  alpha) },
                last_name: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha) },
                email: { required: helpers.withMessage('Llenar este campo es obligatorio', required), email: helpers.withMessage('Debes escribir en formato de correo electronico', email) },
                phone: { required: helpers.withMessage('Llenar este campo es obligatorio', required), phone: helpers.withMessage('Debes ingresar 8 digitos, sin letras o caracteres especiales', phone) },
                address: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alphaNum: helpers.withMessage('Este campo solo admite letras y numeros',alpha3) },
                nationality: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha) },
                birth_date: { required: helpers.withMessage('Llenar este campo es obligatorio', required) },
                marital_status: { required: helpers.withMessage('Llenar este campo es obligatorio', required) },
                mate_name: { requiredIf:  helpers.withMessage('Llenar este campo es obligatorio', requiredIf(state.personalInfo.marital_status == 'Casado/a')) },
                secular_degree: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha3) },
                current_ocupation: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha2) }
            }
            }
        })

        const v$ = useVuelidate(rules, state)

        return { state, v$ }
    },
    methods: {
        passData() {
            let checkPhone = this.state.personalInfo.phone ? this.state.personalInfo.phone.replace('-', '') : null
            this.state.personalInfo.phone = checkPhone
            this.$emit('personalInfo', this.state.personalInfo)
        },
        clearInputs() {
            this.state.personalInfo.name = ''
            this.state.personalInfo.last_name = ''
            this.state.personalInfo.email = ''
            this.state.personalInfo.phone = ''
            this.state.personalInfo.address = ''
            this.state.personalInfo.nationality = ''
            this.state.personalInfo.birth_date = ''
            this.state.personalInfo.marital_status = ''
            this.state.personalInfo.mate_name = ''
            this.state.personalInfo.secular_degree = ''
            this.state.personalInfo.current_ocupation = ''
        }
    },
    expose: ['passData', 'clearInputs'],
    watch: {
        'state.personalInfo.phone'(newValue) {
            let phoneNumber = newValue
            if (phoneNumber.length === 8) {
                let cleaned = ('' + phoneNumber).replace(/\D/g, '')
                let match = cleaned.match(/^(\d{4})(\d{4})$/)
                if (match) {
                    this.state.personalInfo.phone = match[1] + '' + match[2]
                }
                else {
                    this.state.personalInfo.phone = ''
                }
            }
            if (phoneNumber.length > 9) {
                this.state.personalInfo.phone = phoneNumber.slice(0, -1)
            }
        }
    }
}
</script>

<template>
    <section class="w-100 text-black">
        <h3 class="fw-bold text-center mb-5 section-title">Datos Personales</h3>
        <div class="questions-container">
            <div class="row g-3">
                <div class="col-6 col-md-4">
                    <label for="name" class="form-label">Nombres</label>
                    <input type="text" class="form-control" id="name" placeholder="Juan José"
                        v-model="state.personalInfo.name" >
                        <span class="text-danger" v-if="v$.personalInfo.name.$error">{{ v$.personalInfo.name.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="lastname" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="lastname" placeholder="Perez López"
                        v-model="state.personalInfo.last_name" >
                        <span class="text-danger" v-if="v$.personalInfo.last_name.$error">{{ v$.personalInfo.last_name.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" placeholder="juanperez@gmail.com"
                        v-model="state.personalInfo.email" >
                        <span class="text-danger" v-if="v$.personalInfo.email.$error">{{ v$.personalInfo.email.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="phone1" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="phone1" placeholder="6458-5955"
                        v-model="state.personalInfo.phone" >
                        <span class="text-danger" v-if="v$.personalInfo.phone.$error">{{ v$.personalInfo.phone.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="address" class="form-label">Dirección donde reside</label>
                    <input type="text" class="form-control" id="address"
                        placeholder="Barrio el centro, Chalatenango, Chalatenango, El Salvador"
                        v-model="state.personalInfo.address" >
                        <span class="text-danger" v-if="v$.personalInfo.address.$error">{{ v$.personalInfo.address.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="nationality" class="form-label">Nacionalidad</label>
                    <input type="text" class="form-control" id="nationality" placeholder="Salvadoreñe"
                        v-model="state.personalInfo.nationality" >
                        <span class="text-danger" v-if="v$.personalInfo.nationality.$error">{{ v$.personalInfo.nationality.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="birthDate" class="form-label">Fecha de nacimiento</label>
                    <input type="date" class="form-control" id="birthDate" v-model="state.personalInfo.birth_date"
                        >
                        <span class="text-danger" v-if="v$.personalInfo.birth_date.$error">{{ v$.personalInfo.birth_date.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label class="form-label">Estado civil</label>
                    <select class="form-select" v-model="state.personalInfo.marital_status">
                        <option selected>-- --</option>
                        <option value="Soltero/a">Soltero/a</option>
                        <option value="Casado/a">Casado/a</option>
                        <option value="Divorsiado/a">Divorciado/a</option>
                        <option value="Viudo/a">Viudo/a</option>
                    </select>
                    <span class="text-danger" v-if="v$.personalInfo.marital_status.$error">{{ v$.personalInfo.marital_status.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4" v-if="state.personalInfo.marital_status === 'Casado/a'">
                    <label for="mateName" class="form-label">Nombre del cónyuge</label>
                    <input type="text" class="form-control" id="mateName" placeholder="Juan Perez"
                        v-model="state.personalInfo.mate_name" >
                        <span class="text-danger" v-if="v$.personalInfo.mate_name.$error">{{ v$.personalInfo.mate_name.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="secularDegree" class="form-label">Último grado secular estudiado</label>
                    <input type="text" class="form-control" id="secularDegree" placeholder="Bachillerato stop"
                        v-model="state.personalInfo.secular_degree" >
                        <span class="text-danger" v-if="v$.personalInfo.secular_degree.$error">{{ v$.personalInfo.secular_degree.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="currentOcupation" class="form-label">Ocupación actual</label>
                    <input type="text" class="form-control" id="currentOcupation" placeholder="Corralero"
                        v-model="state.personalInfo.current_ocupation" >
                        <span class="text-danger" v-if="v$.personalInfo.current_ocupation.$error">{{ v$.personalInfo.current_ocupation.$errors[0].$message}}</span>
                </div>
            </div>
        </div>
    </section>
</template>
<style scoped>
.form-title {
    text-shadow: 2px 2px 3px rgb(0, 0, 0);
}

.form-container {
    background: var(--bs-gray-400);
    border: 6px solid #ccc;
}

.questions-container {
    display: grid;
    justify-content: left;
}

.col-6 {
    min-width: 300px;
}
</style>