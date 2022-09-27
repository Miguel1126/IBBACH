<script>
export default {
    data() {
        return {
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
        }
    },
    methods: {
        passData() {
            this.$emit('ministerialInfo', this.ministerialInfo)
        },
        clearInputs() {
            this.ministerialInfo.ministry_performed = ''
            this.ministerialInfo.current_ministry = ''
            this.ministerialInfo.full_time = ''
            this.ministerialInfo.ministry_qualification = ''
            this.ministerialInfo.aspirated_ministry = ''
            this.ministerialInfo.reason_aspiring_ministry = ''
            this.ministerialInfo.cicle_to_be_taken = ''
            this.ministerialInfo.previous_institution = ''
            this.ministerialInfo.last_year_studied = ''
            this.ministerialInfo.qualities_religious_worker = ''
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
                    v-model="ministerialInfo.ministry_performed" required>
            </div>
            <div class="col-6 col-md-4">
                <label for="current_ministry" class="form-label">¿Su ministerio actual?</label>
                <input type="text" class="form-control" id="current_ministry" placeholder="Escribir ministerio"
                    v-model="ministerialInfo.current_ministry" required>
            </div>
            <div class="col-6 col-md-4">
                <label class="form-label">Está a tiempo completo:</label>
                <select class="form-select" v-model="ministerialInfo.full_time">
                    <option selected>-- --</option>
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="col-6 col-md-4">
                <label for="ministry_qualification" class="form-label">¿Cómo califica su ministerio actual?</label>
                <textarea type="text" class="form-control" id="ministry_qualification"
                    placeholder="En la escala de bueno, intermedio o malo"
                    v-model="ministerialInfo.ministry_qualification" required></textarea>
            </div>
            <div class="col-6 col-md-4">
                <label for="aspirated_ministry" class="form-label">¿A qué ministerio cree que Dios lo está
                    llamando?</label>
                <input type="text" class="form-control" id="aspirated_ministry"
                    placeholder="Escribir ministerio deseado" v-model="ministerialInfo.aspirated_ministry" required>
            </div>
            <div class="col-6 col-md-4">
                <label for="reason_aspiring_ministry" class="form-label">¿Por qué cree así?</label>
                <textarea type="text" class="form-control" id="reason_aspiring_ministry"
                    placeholder="Escribir un pensamiento" v-model="ministerialInfo.reason_aspiring_ministry"
                    required></textarea>
            </div>
            <div class="col-6 col-md-4">
                <label for="cicle_to_be_taken" class="form-label">¿Qué ciclo le corresponde cursar en el
                    bíblico?</label>
                <input type="text" class="form-control" id="cicle_to_be_taken"
                    placeholder="Escribir el primero, segundo, etc" v-model="ministerialInfo.cicle_to_be_taken"
                    required>
            </div>
            <div class="col-6 col-md-4">
                <label for="qualities_religious_worker" class="form-label">Escriba las cualidades de un obrero
                    cristiano: </label>
                <textarea type="text" class="form-control" id="qualities_religious_worker"
                    placeholder="Escribir cuantas considere necesario"
                    v-model="ministerialInfo.qualities_religious_worker" required></textarea>
            </div>
            <div class="col-6 col-md-4">
                <label for="previous_institution" class="form-label">¿En qué Institución estudio el ciclo o los ciclos
                    anteriores? </label>
                <input type="text" class="form-control" id="previous_institution" placeholder="Nombre de la institucion"
                    v-model="ministerialInfo.previous_institution" required>
            </div>
            <div class="col-6 col-md-4">
                <label for="last_year_studied" class="form-label">¿En qué año estudió la última vez? </label>
                <input type="text" class="form-control" id="last_year_studied" placeholder="Ejemplo: 2018"
                    v-model="ministerialInfo.last_year_studied" required>
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

.col-6{
    min-width: 300px;
}
</style>