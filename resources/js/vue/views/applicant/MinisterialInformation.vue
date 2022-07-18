<script>
export default{
    data() {
        return {
            ministerialInfo:{
                ministry_performed: '',
                current_ministry: '',
                full_time: '',
                ministry_qualification: '',
                aspirated_ministry: '',
                reason_aspiring_ministry: '',
                cicle_to_be_taken: '',
                previous_institution: '',
                last_year_studied:'',
                qualities_religious_worker:'',
                registration_date: ''
            }
        }
    },
    methods: {
        passData() {
            this.$emit('ministerialInfo', this.ministerialInfo)
        },
    }
}
</script>

<template>
    <section class="w-100 text-black">
        <h3 class="fw-bold text-center mb-5 section-title">Datos Ministeriales</h3>
        <div class="questions-container">
            <div class="mb-3">
                <label for="privilegesHeld" class="form-label">¿En qué ministerio se ha desempeñado?</label>
                <input type="text" class="form-control" id="privilegesHeld" placeholder="ministerial" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Está a tiempo completo:</label>
                <select class="form-select">
                    <option selected>-- --</option>
                    <option value="1">Si</option>
                    <option value="2">No</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="privilegesHeld" class="form-label">¿Porque?</label>
                <input type="text" class="form-control" id="privilegesHeld" placeholder="porque tengo tiempo" required>
            </div>
            <div class="mb-3">
                <label for="denomination" class="form-label">¿A qué ministerio cree que Dios lo está llamando?</label>
                <input type="text" class="form-control" id="denomination" placeholder="nose" required>
            </div>
            <div class="mb-3">
                <label for="studyReason" class="form-label">¿En qué Institución estudio el ciclo o los ciclos
                    anteriores? </label>
                <input type="text" class="form-control" id="studyReason" placeholder="ya se me olvido" required>
            </div>
            <div class="mb-3">
                <label for="studyReason" class="form-label">¿En qué año estudió la última vez? </label>
                <input type="text" class="form-control" id="studyReason" placeholder="2018" required>
            </div>
            <div class="mb-3">
                <label for="studyReason" class="form-label">¿Qué ministerio desempeña aparte de su iglesia? </label>
                <input type="text" class="form-control" id="studyReason" placeholder="cristiano" required>
            </div>
            <div class="mb-3">
                <label for="studyReason" class="form-label">Escriba las cualidades de un obrero cristiano: </label>
                <input type="text" class="form-control" id="studyReason" placeholder="respetuso" required>
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