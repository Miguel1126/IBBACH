<script>
    export default{
        mounted() {
            this.getCycles()
            this.getSubjects()
            this.getTeachers()
            this.getSchedules()
            this.getLoads()
        },
        data() {
        return {
            loads: [],
        }
    },
        methods: {
            async getLoads() {
                try {
                    const response = await this.axios.get('/api/cargas/all')
                    if (response.status === 200) {
                        if (typeof (response.data) === 'object') {
                            this.loads = response.data
                        }
                        else {
                            console.log(response)
                        }
                    }
                }
                catch (error) {
                    console.error(error);
                }
            },
            async getCycles() {
                try {
                    const response = await this.axios.get('/api/ciclos/get')
                    if (response.status === 200) {
                        if (typeof (response.data) === 'object') {
                            this.cycles = response.data
                        }
                        else {
                            console.log(response)
                        }
                    }
                }
                catch (error) {
                    console.error(error);
                }
            },
            async getSubjects() {
                try {
                    const response = await this.axios.get('/api/asignaturas/get')
                    if (response.status === 200) {
                        if (typeof (response.data) === 'object') {
                            this.subjects = response.data
                        }
                        else {
                            console.log(response)
                        }
                    }
                }
                catch (error) {
                    console.error(error);
                }
            },
            async getTeachers() {
                try {
                    const response = await this.axios.get('/api/getDocentes')
                    if (response.status === 200) {
                        if (typeof (response.data) === 'object') {
                            this.teachers = response.data
                        }
                        else {
                            console.log(response)
                        }
                    }
                }
                catch (error) {
                    console.error(error)
                }
            },
            async getSchedules() {
                try {
                    const response = await this.axios.get('/api/horarios/get')
                    if (response.status === 200) {
                        if (typeof (response.data) === 'object') {
                            this.schedules = response.data
                        }
                        else {
                            console.log(response)
                        }
                    }
                }
                catch (error) {
                    console.error(error)
                }
            },
        }
        
    }        
</script>
<template>
    <main>
        <section class=" p-3 ">
        </section>
        <section class="p-3">
            <div class="table-container p-3 mb-5 table-color rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado de carga academica</h3>
                <table class="table table-bordered border-dark bg-light">
                        <thead class="table-success table-bordered border-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ciclo</th>
                                <th scope="col">Materia</th>
                                <th scope="col">Docente</th>
                                <th scope="col">HoraInicio</th>
                                <th scope="col">HoraFinal</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr v-for="load in loads" :key="load.id">
                                <th scope="row">{{ load.id }}</th>
                                <td>{{ load.cycle }}</td>
                                <td>{{ load.subject }}</td>
                                <td>{{ load.teacher }} {{ load.last_name }}</td>
                                <td>{{ load.start_time }}</td>
                                <td>{{ load.end_time }}</td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </section>
    </main>    
</template>

<style scoped>

</style>