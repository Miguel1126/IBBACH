<script>
    export default{
        mounted() {
            this.getSubjects()
        },
        data() {
        return {
            subjects: [],
            description: [],
            status: [],
        }
    },
        methods: {
        
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
            }
        }
        
    }        
</script>
<template>
    <main>
        <section class=" p-3 ">
        </section>
        <section class="p-3">
            <div class="table-container p-3 mb-5 table-color rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado de asignaturas</h3>
                <table class="table table-bordered border-dark bg-light">
                        <thead class="table-success table-bordered border-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Materias</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr v-for="subject in subjects" :key="subject.id">
                                <th scope="row">{{ subject.id }}</th>
                                <td>{{ subject.subject }}</td>
                                <td>{{ subject.description }}</td>
                                <td>{{ subject.status }}</td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </section>
    </main>    
</template>

<style scoped>
</style>