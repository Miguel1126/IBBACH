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
        <h3 class="fw-bold text-center mb-5 section-title">Datos Ministeriales</h3>
        <div class="questions-container">
            <div class="mb-3">
                <label for="ministry_performed" class="form-label">¿En qué ministerio se ha desempeñado?</label>
                <input type="text" class="form-control" id="ministry_performed" placeholder="ministerial"
                    v-model="ministerialInfo.ministry_performed" required>
            </div>
            <div class="mb-3">
                <label for="current_ministry" class="form-label">¿Su ministerio actual?</label>
                <input type="text" class="form-control" id="current_ministry" placeholder="ministerial"
                    v-model="ministerialInfo.current_ministry" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Está a tiempo completo:</label>
                <select class="form-select" v-model="ministerialInfo.full_time">
                    <option selected>-- --</option>
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="ministry_qualification" class="form-label">¿Cómo califica su ministerio actual?</label>
                <textarea type="text" class="form-control" id="ministry_qualification" placeholder="nose"
                    v-model="ministerialInfo.ministry_qualification" required></textarea>
            </div>
            <div class="mb-3">
                <label for="aspirated_ministry" class="form-label">¿A qué ministerio cree que Dios lo está
                    llamando?</label>
                <input type="text" class="form-control" id="aspirated_ministry" placeholder="nose"
                    v-model="ministerialInfo.aspirated_ministry" required>
            </div>
            <div class="mb-3">
                <label for="reason_aspiring_ministry" class="form-label">¿Por qué cree así?</label>
                <textarea type="text" class="form-control" id="reason_aspiring_ministry" placeholder="nose"
                    v-model="ministerialInfo.reason_aspiring_ministry" required></textarea>
            </div>
            <div class="mb-3">
                <label for="cicle_to_be_taken" class="form-label">¿Qué ciclo le corresponde cursar en el
                    bíblico?</label>
                <input type="text" class="form-control" id="cicle_to_be_taken" placeholder="nose"
                    v-model="ministerialInfo.cicle_to_be_taken" required>
            </div>
            <div class="mb-3">
                <label for="previous_institution" class="form-label">¿En qué Institución estudio el ciclo o los ciclos
                    anteriores? </label>
                <input type="text" class="form-control" id="previous_institution" placeholder="ya se me olvido"
                    v-model="ministerialInfo.previous_institution" required>
            </div>
            <div class="mb-3">
                <label for="last_year_studied" class="form-label">¿En qué año estudió la última vez? </label>
                <input type="text" class="form-control" id="last_year_studied" placeholder="2018"
                    v-model="ministerialInfo.last_year_studied" required>
            </div>
            <div class="mb-3">
                <label for="qualities_religious_worker" class="form-label">Escriba las cualidades de un obrero
                    cristiano: </label>
                <textarea type="text" class="form-control" id="qualities_religious_worker" placeholder="respetuso"
                    v-model="ministerialInfo.qualities_religious_worker" required></textarea>
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

.section-title {
    text-decoration: underline;
}

.questions-container {
    display: grid;
    justify-content: left;
}
</style>