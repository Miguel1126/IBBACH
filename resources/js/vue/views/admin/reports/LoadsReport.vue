<script>
import DataTable from '../../../components/DataTable.vue'
export default {
    mounted() {
        this.getCycles();
        this.getSubjects();
        this.getTeachers();
        this.getSchedules();
        this.getLoads();
    },
    data() {
        return {
            loads: [],
        };
    },
    methods: {
        async getLoads() {
            try {

                const response = await this.axios.get("/api/cargas/all");

                const response = await this.axios.get('/api/getCargas')

                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.loads = response.data;
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                console.error(error);
            }
        },
        async getCycles() {
            try {

                const response = await this.axios.get("/api/ciclos/get");

                const response = await this.axios.get('/api/getCiclos')

                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.cycles = response.data;
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                console.error(error);
            }
        },
        async getSubjects() {
            try {

                const response = await this.axios.get("/api/asignaturas/get");

                const response = await this.axios.get('/api/getAsignaturas')

                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.subjects = response.data;
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                console.error(error);
            }
        },
        async getTeachers() {
            try {
                const response = await this.axios.get("/api/getDocentes");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.teachers = response.data;
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                console.error(error);
            }
        },
        async getSchedules() {
            try {

                const response = await this.axios.get("/api/horarios/get");

                const response = await this.axios.get('/api/getHorarios')

                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.schedules = response.data;
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                console.error(error);
            }
        },
    },
    components: { DataTable }
}        
</script>
<template>
    <main>
        <section class=" p-3 ">
        </section>
        <section class="p-3">
            <DataTable title="Listado de Carga Academica" :headers="[
                { title: 'Id' },
                { title: 'Ciclo' },
                { title: 'Asignaturas' },
                { title: 'Docente' },
                { title: 'Apellido' },
                { title: 'Hora de inicio' },
                { title: 'Hora de finalizacion' },
            ]" :items="loads">
            </DataTable>
        </section>
    </main>
</template>

<style scoped>
</style>