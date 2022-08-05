<script>
export default {
    mounted() {
        this.getCycles()
    },
    data() {
        return {
            cycles: [],
            start_date: [],
            end_date: [],
            status: [],
            groups: [],
        }
    },
    methods: {
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
    }

}        
</script>
<template>
    <main>
        <section class=" p-3 ">
        </section>
        <section class="p-3">
            <div class="table-container p-3 mb-5 table-color rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado de ciclos</h3>
                <table class="table table-bordered border-dark bg-light">
                    <thead class="table-success table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ciclos</th>
                            <th scope="col">Fecha de inicio</th>
                            <th scope="col">Fecha de finalización</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Grupo</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="cycle in cycles" :key="cycle.id">
                            <th scope="row">{{ cycle.id }}</th>
                            <td>{{ cycle.cycle }}</td>
                            <td>{{ cycle.start_date }}</td>
                            <td>{{ cycle.end_date }}</td>
                            <td>{{ cycle.status }}</td>
                            <td>{{ cycle.group }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</template>

<style scoped>
</style>