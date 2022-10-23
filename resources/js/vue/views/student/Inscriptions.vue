<script>
import { formatDate } from '../../js/format_time';
import { handleErrors } from '../../js/handle_error';
import LoadingDots from '../../components/LoadingDots.vue';

export default {
    data() {
        return {
            cycle: {},
            subjects: [],
            canInscribe: false,
            isInscribed: false,
            loading: false,
        };
    },
    methods: {
        async getInscription() {
            try {
                const response = await this.axios.get("/api/get-inscription");
                if (response.status === 200 && response.data.subjects) {
                    this.cycle = this.formateDate(response.data.cycle);
                    this.subjects = response.data.subjects;
                    this.canInscribe = true;
                }
                else if (response.status === 200 && !response.data.subjects) {
                    this.isInscribed = true;
                }
            }
            catch (error) {
                handleErrors(error);
            }
        },
        async inscribe() {
            this.loading = true
            let subjectsId = []
            this.subjects.forEach(subject => {
                subjectsId.push(subject.id)
            });
            try {
                const response = await this.axios.post("/api/inscribe", { loads: subjectsId });
                if (response.status === 201) {
                    this.canInscribe = false;
                    this.isInscribed = true;
                }
            }
            catch (error) {
                this.$swal.fire("Error", "No se pudo inscribir el ciclo", "error");
                this.loading = false
                handleErrors(error);
            }
        },
        formateDate(data) {
            data.forEach(cycle => {
                cycle.start_date = formatDate(cycle.start_date);
                cycle.end_date = formatDate(cycle.end_date);
            });
            return data[0];
        },
    },
    mounted() {
        this.getInscription();
        document.title = "IBBACH | Inscripción";
    },
    components: { LoadingDots }
}
</script>
<template>
    <main>
        <h1>Inscripción de Ciclo</h1>
        <div class="alert-insc" v-if="!canInscribe">
            <div class="alert alert-success alert-dismisable fade show d-flex" role="alert">
                <span class="material-icons d-flex align-items-center me-3">check</span>
                <span v-if="isInscribed">¡Ya estás inscrito en este ciclo!.</span>
                <span v-else>No tienes ciclos disponibles para inscribir en este momento.</span>
            </div>
        </div>
        <div class="inscription-container" v-else>
            <div>
                <div>
                    <h4><b>Ciclo:</b> {{ cycle.cycle }}</h4>
                    <h5 class="d-inline-block"><b>Fecha de inicio:</b> {{ cycle.start_date }} &nbsp;&nbsp; <b>Fecha de
                            finalización:</b> {{ cycle.end_date }}</h5>
                </div>
                <hr>
                <div class="table-responsive">
                    <h4>Asignaturas a inscribir:</h4>
                    <table class="table text-light">
                        <thead>
                            <tr>
                                <th><b>Nombre</b></th>
                                <th><b>Descripción</b></th>
                                <th><b>UV</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="subject in subjects">
                                <td>{{ subject.subject }}</td>
                                <td>{{ subject.description }}</td>
                                <td>{{ subject.uv }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <LoadingDots class="m-3" v-if="loading"></LoadingDots>
                    <button v-else class="btn btn-secondary d-inline-flex align-items-center gap-1 fs-5"
                        @click="inscribe">Inscribirse <span
                            class="material-symbols-outlined">arrow_circle_right</span></button>
                </div>
            </div>
        </div>
    </main>
</template>
<style scoped>
.alert-insc {
    max-width: 40rem;
}

.alert-success {
    color: #71ff56;
    background-color: #41a00bba;
    border-color: #2cff00;
}

.inscription-container {
    background: var(--dark);
    max-width: 40rem;
    padding: 1rem;
    border-radius: 5px;
}

thead {
    background-color: var(--dark-alt);
}
</style>