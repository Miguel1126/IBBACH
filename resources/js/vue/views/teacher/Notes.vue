<script>
import { handleErrors } from '../../js/handle_error';
import LoadingDots from '../../components/LoadingDots.vue';

export default {
    data() {
        return {
            selectedGroup: "",
            groups: [],
            loads: [],
            currentCycle: {},
            loading: false
        };
    },
    methods: {
        async getGroups() {
            try {
                const response = await this.axios.get("/api/groups");
                if (response.status === 200)
                    this.groups = response.data;
            }
            catch (error) {
                handleErrors(error);
            }
        },
        async getAssignedLoads() {
            this.loading = true
            this.loads = [];
            this.currentCycle = {};
            try {
                const response = await this.axios.get("/api/teacher-loads?group_id=" + this.selectedGroup);
                if (response.status === 200) {
                    this.loads = response.data.loads;
                    this.currentCycle = response.data.current_cycle;
                    this.loading = false
                }
                if (response.status === 204) {
                    this.loading = false
                }
            }
            catch (error) {
                this.loading = false
                handleErrors(error);
            }
        }
    },
    watch: {
        selectedGroup() {
            this.getAssignedLoads();
        }
    },
    mounted() {
        document.title = "IBBACH | Registro de Notas";
        this.getGroups();
    },
    components: { LoadingDots }
}
</script>
<template>
    <main>
        <div class="m-2">
            <h1 class="h1 fs-1 fw-bold mb-3">Registro de notas</h1>
            <label class="d-inline-block">Selecciona la modalidad:</label>
            <select class="form-select select-input" v-model="selectedGroup">
                <option v-for="group in groups" :key="group.id" :value="group.id">{{ group.group }}</option>
            </select>
        </div>
        <hr>
        <div class="m-2 mt-4" v-if="selectedGroup">
            <div v-if="!loads.length && !loading">
                <h2>No tienes asignaturas asignadas este ciclo</h2>
            </div>
            <div v-else-if="loading" class="d-flex justify-content-center">
                <LoadingDots />
            </div>
            <div class="table-responsive d-flex" v-else>
                <table class="table text-light">
                    <thead>
                        <tr>
                            <th class="text-center fs-5">
                                <span>Ciclo Actual: {{ currentCycle.cycle }}</span><br>
                                <span>Modalidad: {{ currentCycle.group }}</span>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-center fs-5">
                                <span>Selecciona una asignatura para registrar las notas</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="load in loads" :key="load.id">
                            <td>
                                <router-link class="link-load" :to="{ name: 'RegisterNotes', params: { loadId: load.id }}">
                                    <div class="bg-darkp p-2 d-flex justify-content-between rounded-1 cursor-pointer">
                                        <p class="p-0 m-0 fs-5"><b>{{ load.subject }}</b> <br> <span class="fs-6">Desde: {{ load.start_date }} Hasta: {{ load.end_date }} &nbsp; De: {{ load.start_time }} A: {{ load.end_time }}</span></p>
                                    </div>
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</template>
<style scoped>
select {
    max-width: 400px;
    min-width: 200px;
}
table {
    max-width: 600px;
    min-width: 200px;
    background-color: var(--dark-alt);
}
.bg-darkp {
    background-color: var(--dark);
}

.link-load {
    text-decoration: none;
    color: #fff;
}
.bg-darkp:hover {
    background-color: #4a4955;
}
</style>