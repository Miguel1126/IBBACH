<script>
import { useVuelidate } from '@vuelidate/core'
import { required, alpha, helpers, numeric, requiredIf } from '@vuelidate/validators'
import { computed, reactive } from 'vue';
export default {
    setup() {
        document.title = 'IBBACH  | Formulario de inscripción'
        const state = reactive({
            ecclesiasticalInfo: {
                is_pastor: null,
                is_member: null,
                pastor_phone: '',
                church_name: '',
                church_address: '',
                church_phone: '',
                district: '',
                pastor_name: '',
                licence: '',
                reference_name_one: '',
                reference_phone_one: '',
                reference_name_two: '',
                reference_phone_two: '',
                christ_accepted: '',
                christening_date: '',
                time_being_member: '',
                privileges_held: '',
                denomination: '',
                study_reason: ''
            }
        })

        const rules = computed(() => {
            const alpha = helpers.regex(/^[ a-zA-ZñÑáéíóúÁÉÍÓÚ'° ]+$/) 
            const alpha2 = helpers.regex(/^[ a-zA-ZñÑáéíóúÁÉÍÓÚ,.:;'° ]+$/) 
            const alpha3 = helpers.regex(/^[ a-zA-ZñÑáéíóúÁÉÍÓÚ,.:;0-9'° ]+$/) 
            const phone = helpers.regex(/^[0-9](\d{7})$/)  
            return {
                ecclesiasticalInfo: {
                    is_pastor: { required: helpers.withMessage('Llenar este campo es obligatorio', required) },
                    is_member: { required: helpers.withMessage('Llenar este campo es obligatorio', required) },
                    pastor_phone: { requiredIf:  helpers.withMessage('Llenar este campo es obligatorio', requiredIf(state.ecclesiasticalInfo.is_member === '1')), phone: helpers.withMessage('Este campo solo admite numeros', phone) },
                    church_name: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha) },
                    church_address: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha3: helpers.withMessage('Este campo solo admite letras y numeros', alpha3 ) },
                    church_phone: { required: helpers.withMessage('Llenar este campo es obligatorio', required), phone: helpers.withMessage('Este campo solo admite numeros', phone) },
                    district: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha3: helpers.withMessage('Este campo solo admite letras y numeros', alpha3) },
                    pastor_name:  { requiredIf:  helpers.withMessage('Llenar este campo es obligatorio', requiredIf(state.ecclesiasticalInfo.is_member === '1')), alpha: helpers.withMessage('Este campo solo admite letras', alpha) },
                    licence: {  requiredIf:  helpers.withMessage('Llenar este campo es obligatorio', requiredIf(state.ecclesiasticalInfo.is_member === '1')), numeric: helpers.withMessage('Este campo solo admite numeros', numeric) },
                    reference_name_one: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha) },
                    reference_phone_one: { required: helpers.withMessage('Llenar este campo es obligatorio', required), phone: helpers.withMessage('Este campo solo admite numeros', phone) },
                    reference_name_two: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha) },
                    reference_phone_two: { required: helpers.withMessage('Llenar este campo es obligatorio', required), phone: helpers.withMessage('Este campo solo admite numeros', phone) },
                    christ_accepted: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha3) },
                    christening_date: { required: helpers.withMessage('Llenar este campo es obligatorio', required) },
                    time_being_member: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha3: helpers.withMessage('Este campo solo admite letras', alpha3) },
                    privileges_held: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha2: helpers.withMessage('Este campo solo admite letras', alpha2) },
                    denomination: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha2: helpers.withMessage('Este campo solo admite letras', alpha2) },
                    study_reason: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha2: helpers.withMessage('Este campo solo admite letras', alpha2) }
                }
            }
        })

        const v$ = useVuelidate(rules, state)

        return { state, v$ }

    },
    methods: {
        passData() {
            const referenceObject = this.state.ecclesiasticalInfo
            referenceObject.pastor_phone = referenceObject.pastor_phone ? referenceObject.pastor_phone.replace('-', '') : ''
            referenceObject.church_phone = referenceObject.church_phone ? referenceObject.church_phone.replace('-', '') : ''
            referenceObject.reference_phone_one = referenceObject.reference_phone_one ? referenceObject.reference_phone_one.replace('-', '') : ''
            referenceObject.reference_phone_two = referenceObject.reference_phone_two ? referenceObject.reference_phone_two.replace('-', '') : ''
            this.$emit('ecclesiasticalInfo', this.state.ecclesiasticalInfo)
        },
        clearInputs() {
            this.state.ecclesiasticalInfo.is_pastor = null
            this.state.ecclesiasticalInfo.is_member = null
            this.state.ecclesiasticalInfo.pastor_phone = ''
            this.state.ecclesiasticalInfo.church_name = ''
            this.state.ecclesiasticalInfo.church_address = ''
            this.state.ecclesiasticalInfo.church_phone = ''
            this.state.ecclesiasticalInfo.district = ''
            this.state.ecclesiasticalInfo.pastor_name = ''
            this.state.ecclesiasticalInfo.licence = ''
            this.state.ecclesiasticalInfo.reference_name_one = ''
            this.state.ecclesiasticalInfo.reference_phone_one = ''
            this.state.ecclesiasticalInfo.reference_name_two = ''
            this.state.ecclesiasticalInfo.reference_phone_two = ''
            this.state.ecclesiasticalInfo.christ_accepted = ''
            this.state.ecclesiasticalInfo.christening_date = ''
            this.state.ecclesiasticalInfo.time_being_member = ''
            this.state.ecclesiasticalInfo.privileges_held = ''
            this.state.ecclesiasticalInfo.denomination = ''
            this.state.ecclesiasticalInfo.study_reason = ''
        }
    },
    expose: ['passData', 'clearInputs'],
    watch: {
        'state.ecclesiasticalInfo.pastor_phone'(newValue) {
            let arrayPhoneNumber = newValue.match(/[0-9]/g) ?? [""]
            let phoneNumber = arrayPhoneNumber.join().replace(/,/g,"")
            this.state.ecclesiasticalInfo.pastor_phone = phoneNumber.length > 8 ? phoneNumber.slice(0,-1) : phoneNumber
        },
        'state.ecclesiasticalInfo.church_phone'(newValue) {
            let arrayPhoneNumber = newValue.match(/[0-9]/g) ?? [""]
            let phoneNumber = arrayPhoneNumber.join().replace(/,/g,"")
            this.state.ecclesiasticalInfo.church_phone = phoneNumber.length > 8 ? phoneNumber.slice(0,-1) : phoneNumber
        },
        'state.ecclesiasticalInfo.reference_phone_one'(newValue) {
            let arrayPhoneNumber = newValue.match(/[0-9]/g) ?? [""]
            let phoneNumber = arrayPhoneNumber.join().replace(/,/g,"")
            this.state.ecclesiasticalInfo.reference_phone_one = phoneNumber.length > 8 ? phoneNumber.slice(0,-1) : phoneNumber
        },
        'state.ecclesiasticalInfo.reference_phone_two'(newValue) {
            let arrayPhoneNumber = newValue.match(/[0-9]/g) ?? [""]
            let phoneNumber = arrayPhoneNumber.join().replace(/,/g,"")
            this.state.ecclesiasticalInfo.reference_phone_two = phoneNumber.length > 8 ? phoneNumber.slice(0,-1) : phoneNumber
        }
    }

}
</script>

<template>
    <section class="w-100 text-black">
        <h3 class="fw-bold text-center mb-5 section-title">Datos Eclesiásticos</h3>
        <div class="questions-container">
            <div class="row g-3">
                <div class="col-6 col-md-4">
                    <label class="form-label ">¿Es pastor?</label>
                    <select class="form-select" v-model="state.ecclesiasticalInfo.is_pastor">
                        <option selected>-- --</option>
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.is_pastor.$error">{{ v$.ecclesiasticalInfo.is_pastor.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label class="form-label">¿Es Miembro?</label>
                    <select class="form-select" v-model="state.ecclesiasticalInfo.is_member">
                        <option selected>-- --</option>
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.is_member.$error">{{ v$.ecclesiasticalInfo.is_member.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="churchName" class="form-label">¿De qué iglesia?</label>
                    <input type="text" class="form-control" id="churchName" placeholder="Nombre"
                        v-model="state.ecclesiasticalInfo.church_name">
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.church_name.$error">{{ v$.ecclesiasticalInfo.church_name.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="churchAddress" class="form-label">Dirección de la iglesia</label>
                    <input type="text" class="form-control" id="churchAddress" placeholder=" municipio, departamento"
                        v-model="state.ecclesiasticalInfo.church_address">
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.church_address.$error">{{ v$.ecclesiasticalInfo.church_address.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="phone2" class="form-label">Teléfono de la iglesia</label>
                    <input type="text" class="form-control" id="phone2" placeholder="6458-5955"
                        v-model="state.ecclesiasticalInfo.church_phone">
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.church_phone.$error">{{ v$.ecclesiasticalInfo.church_phone.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="district" class="form-label">Distrito</label>
                    <input type="text" class="form-control" id="district" placeholder="Distrito"
                        v-model="state.ecclesiasticalInfo.district">
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.district.$error">{{ v$.ecclesiasticalInfo.district.$errors[0].$message}}</span>
                </div>
                <div class="row g-3" v-if="state.ecclesiasticalInfo.is_member === '1'">
                    <div class="col-6 col-md-4" v-if="state.ecclesiasticalInfo.is_member === '1'">
                        <label for="MemOrPas" class="form-label">Escriba el nombre de su pastor</label>
                        <input type="text" class="form-control" id="MemOrPas" placeholder="Nombre completo"
                            v-model="state.ecclesiasticalInfo.pastor_name">
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.pastor_name.$error">{{ v$.ecclesiasticalInfo.pastor_name.$errors[0].$message}}</span>
                    </div>
                    <div class="col-6 col-md-4">
                        <label for="licence" class="form-label">Licencia</label>
                        <input type="text" class="form-control" id="licence" placeholder="licencia"
                            v-model="state.ecclesiasticalInfo.licence">
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.licence.$error">{{ v$.ecclesiasticalInfo.licence.$errors[0].$message}}</span>
                    </div>
                    <div class="col-6 col-md-4">
                        <label for="phone3" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="phone3" placeholder="6458-5955"
                            v-model="state.ecclesiasticalInfo.pastor_phone">
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.pastor_phone.$error">{{ v$.ecclesiasticalInfo.pastor_phone.$errors[0].$message}}</span>
                    </div>
                </div>
                <div class="text-left">
                    <label for="nationality" class="form-label">Anote el nombre y teléfono de dos pastores de
                        las Asambleas de Dios que puedan dar referencias suyas</label>
                </div>
                <div class="col-6 col-md-4">
                    <label for="pastor1" class="form-label">Nombre del Pastor</label>
                    <input type="text" class="form-control" id="pastor1" placeholder="Nombre completo"
                        v-model="state.ecclesiasticalInfo.reference_name_one">
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.reference_name_one.$error">{{ v$.ecclesiasticalInfo.reference_name_one.$errors[0].$message}}</span>

                </div>
                <div class="col-6 col-md-4">
                    <label for="phone4" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="phone4" placeholder="6458-5955"
                        v-model="state.ecclesiasticalInfo.reference_phone_one">
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.reference_phone_one.$error">{{ v$.ecclesiasticalInfo.reference_phone_one.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="pastor2" class="form-label">Nombre del Pastor</label>
                    <input type="text" class="form-control" id="pastor2" placeholder="Nombre completo"
                        v-model="state.ecclesiasticalInfo.reference_name_two">
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.reference_name_two.$error">{{ v$.ecclesiasticalInfo.reference_name_two.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="phone5" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="phone5" placeholder="6458-5955"
                        v-model="state.ecclesiasticalInfo.reference_phone_two">
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.reference_phone_two.$error">{{ v$.ecclesiasticalInfo.reference_phone_two.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="lgsus" class="form-label">¿Cuando aceptó a Jesucristo?</label>
                    <textarea class="form-control" id="lgsus" placeholder="Aproximado"
                        v-model="state.ecclesiasticalInfo.christ_accepted"></textarea>
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.christ_accepted.$error">{{ v$.ecclesiasticalInfo.christ_accepted.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="christeningDate" class="form-label">¿Cuando se bautizó?</label>
                    <input type="date" class="form-control" id="christeningDate"
                        v-model="state.ecclesiasticalInfo.christening_date">
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.christening_date.$error">{{ v$.ecclesiasticalInfo.christening_date.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="privilegesHeld" class="form-label">¿Cuales son los privilegios en que se ha
                        desempeñado?</label>
                    <textarea type="text" class="form-control" id="privilegesHeld" placeholder="Aproximado"
                        v-model="state.ecclesiasticalInfo.privileges_held"></textarea>
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.privileges_held.$error">{{ v$.ecclesiasticalInfo.privileges_held.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="timeBeingMember" class="form-label">¿Cuanto tiempo tiene de ser miembro de su
                        iglesia?</label>
                    <input type="text" class="form-control" id="timeBeingMember" placeholder="Aproximado"
                        v-model="state.ecclesiasticalInfo.time_being_member">
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.time_being_member.$error">{{ v$.ecclesiasticalInfo.time_being_member.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="studyReason" class="form-label">¿Cuál es el interés de estudiar en el Instituto Bíblico
                        Betel Anexo? </label>
                    <textarea type="text" class="form-control" id="studyReason" placeholder="Aproximado"
                        v-model="state.ecclesiasticalInfo.study_reason"></textarea>
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.study_reason.$error">{{ v$.ecclesiasticalInfo.study_reason.$errors[0].$message}}</span>
                </div>
                <div class="col-6 col-md-4">
                    <label for="denomination" class="form-label">¿A qué denominación pertenece?</label>
                    <input type="text" class="form-control" id="denomination" placeholder="Aproximado"
                        v-model="state.ecclesiasticalInfo.denomination">
                    <span class="text-danger" v-if="v$.ecclesiasticalInfo.denomination.$error">{{ v$.ecclesiasticalInfo.denomination.$errors[0].$message}}</span>
                </div>
            </div>
        </div>
    </section>
</template>
<style scoped>
.form-title {
    text-shadow: 2px 2px 3px rgb(0, 0, 0);
}

.questions-container {
    display: grid;
    justify-content: left;
}

.col-6 {
    min-width: 250px;
}
</style>