<script>
import { useVuelidate } from '@vuelidate/core'
import { required, alpha, email, helpers, numeric, alphaNum } from '@vuelidate/validators'
import { computed, reactive } from 'vue';
export default {
    setup() {
        const state = reactive({
            ministerialInfo: {
                ministry_performed: '',
                current_ministry: '',
                full_time: '',
                ministry_qualification: '',
                aspirated_ministry: '',
                reason_aspiring_ministry: '',
                cicle_to_be_taken: '',
                previous_institution: '',
                last_year_studied: '',
                qualities_religious_worker: ''
            }
        })

        const rules = computed(() => {
            const alpha = helpers.regex(/^[ a-zA-ZñÑáéíóúÁÉÍÓÚ'° ]+$/) 
            const alpha2 = helpers.regex(/^[ a-zA-ZñÑáéíóúÁÉÍÓÚ,.:;'° ]+$/) 
            const alpha3 = helpers.regex(/^[ a-zA-ZñÑáéíóúÁÉÍÓÚ,.:;0-9'° ]+$/) 
            return {
                ministerialInfo: {
                    ministry_performed: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha2) },
                    current_ministry: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha2) },
                    full_time: { required: helpers.withMessage('Llenar este campo es obligatorio', required)},
                    ministry_qualification: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alphaNum: helpers.withMessage('Este campo solo admite letras y numeros', alpha3) },
                    aspirated_ministry: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha2) },
                    reason_aspiring_ministry: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha2) },
                    cicle_to_be_taken: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha3) },
                    previous_institution: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha2) },
                    last_year_studied: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alphaNum: helpers.withMessage('Este campo solo admite letras y numeros', alpha3) },
                    qualities_religious_worker: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha2) },
                }
            }
        })
        const v$ = useVuelidate(rules, state)

        return { state, v$ }
    },
    methods: {
        passData() {
            this.$emit('ministerialInfo', this.state.ministerialInfo)
        },
        clearInputs() {
            this.state.ministerialInfo.ministry_performed = ''
            this.state.ministerialInfo.current_ministry = ''
            this.state.ministerialInfo.full_time = ''
            this.state.ministerialInfo.ministry_qualification = ''
            this.state.ministerialInfo.aspirated_ministry = ''
            this.state.ministerialInfo.reason_aspiring_ministry = ''
            this.state.ministerialInfo.cicle_to_be_taken = ''
            this.state.ministerialInfo.previous_institution = ''
            this.state.ministerialInfo.last_year_studied = ''
            this.state.ministerialInfo.qualities_religious_worker = ''
        }
    },
    expose: ['passData', 'clearInputs']
}
</script>

<template>
    <section class="w-100 text-black">
        <h3 class="fw-bold text-center m-5 section-title">Datos Ministeriales</h3>
        <div class="row g-3">
            <div class="col-6 col-md-4">
                <label for="ministry_performed" class="form-label">¿En qué ministerio se ha desempeñado?</label>
                <input type="text" class="form-control" id="ministry_performed" placeholder="Escribir ministerio"
                    v-model="state.ministerialInfo.ministry_performed">
                    <span class="text-danger" v-if="v$.ministerialInfo.ministry_performed.$error">{{ v$.ministerialInfo.ministry_performed.$errors[0].$message}}</span>
            </div>
            <div class="col-6 col-md-4">
                <label for="current_ministry" class="form-label">¿Su ministerio actual?</label>
                <input type="text" class="form-control" id="current_ministry" placeholder="Escribir ministerio"
                    v-model="state.ministerialInfo.current_ministry">
                    <span class="text-danger" v-if="v$.ministerialInfo.current_ministry.$error">{{ v$.ministerialInfo.current_ministry.$errors[0].$message}}</span>
            </div>
            <div class="col-6 col-md-4">
                <label class="form-label">Está a tiempo completo:</label>
                <select class="form-select" v-model="state.ministerialInfo.full_time">
                    <option selected>-- --</option>
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
                <span class="text-danger" v-if="v$.ministerialInfo.full_time.$error">{{ v$.ministerialInfo.full_time.$errors[0].$message}}</span>
            </div>
            <div class="col-6 col-md-4">
                <label for="ministry_qualification" class="form-label">¿Cómo califica su ministerio actual?</label>
                <textarea type="text" class="form-control" id="ministry_qualification"
                    placeholder="En la escala de bueno, intermedio o malo"
                    v-model="state.ministerialInfo.ministry_qualification"></textarea>
                <span class="text-danger" v-if="v$.ministerialInfo.ministry_qualification.$error">{{ v$.ministerialInfo.ministry_qualification.$errors[0].$message}}</span>

            </div>
            <div class="col-6 col-md-4">
                <label for="aspirated_ministry" class="form-label">¿A qué ministerio cree que Dios lo está
                    llamando?</label>
                <input type="text" class="form-control" id="aspirated_ministry"
                    placeholder="Escribir ministerio deseado" v-model="state.ministerialInfo.aspirated_ministry">
                <span class="text-danger" v-if="v$.ministerialInfo.aspirated_ministry.$error">{{ v$.ministerialInfo.aspirated_ministry.$errors[0].$message}}</span>

            </div>
            <div class="col-6 col-md-4">
                <label for="reason_aspiring_ministry" class="form-label">¿Por qué cree así?</label>
                <textarea type="text" class="form-control" id="reason_aspiring_ministry"
                    placeholder="Escribir un pensamiento" v-model="state.ministerialInfo.reason_aspiring_ministry"></textarea>
                <span class="text-danger" v-if="v$.ministerialInfo.reason_aspiring_ministry.$error">{{ v$.ministerialInfo.reason_aspiring_ministry.$errors[0].$message}}</span>

            </div>
            <div class="col-6 col-md-4">
                <label for="cicle_to_be_taken" class="form-label">¿Qué ciclo le corresponde cursar en el
                    bíblico?</label>
                <input type="text" class="form-control" id="cicle_to_be_taken"
                    placeholder="Escribir el primero, segundo, etc" v-model="state.ministerialInfo.cicle_to_be_taken">
                <span class="text-danger" v-if="v$.ministerialInfo.cicle_to_be_taken.$error">{{ v$.ministerialInfo.cicle_to_be_taken.$errors[0].$message}}</span>

            </div>
            <div class="col-6 col-md-4">
                <label for="qualities_religious_worker" class="form-label">Escriba las cualidades de un obrero
                    cristiano: </label>
                <textarea type="text" class="form-control" id="qualities_religious_worker"
                    placeholder="Escribir cuantas considere necesario"
                    v-model="state.ministerialInfo.qualities_religious_worker"></textarea>
                <span class="text-danger" v-if="v$.ministerialInfo.qualities_religious_worker.$error">{{ v$.ministerialInfo.qualities_religious_worker.$errors[0].$message}}</span>

            </div>
            <div class="col-6 col-md-4">
                <label for="previous_institution" class="form-label">¿En qué Institución estudio el ciclo o los ciclos
                    anteriores? </label>
                <input type="text" class="form-control" id="previous_institution" placeholder="Nombre de la institucion"
                    v-model="state.ministerialInfo.previous_institution">
                <span class="text-danger" v-if="v$.ministerialInfo.previous_institution.$error">{{ v$.ministerialInfo.previous_institution.$errors[0].$message}}</span>

            </div>
            <div class="col-6 col-md-4">
                <label for="last_year_studied" class="form-label">¿En qué año estudió la última vez? </label>
                <input type="text" class="form-control" id="last_year_studied" placeholder="Ejemplo: 2018"
                    v-model="state.ministerialInfo.last_year_studied">
                <span class="text-danger" v-if="v$.ministerialInfo.last_year_studied.$error">{{ v$.ministerialInfo.last_year_studied.$errors[0].$message}}</span>
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

.col-6 {
    min-width: 250px;
}
</style>