<script>
export default {
    mounted() {
        this.getTeachers();
    },
    data() {
        return {
            teachers: [],
            teaSelected: [],
        }
    },
    methods: {
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
        selectTea(event, teacher) {
            this.teaSelected = []
            this.teaSelected.push(teacher)
        }
    }
}
</script>
<template>
    <main>
        <hr class="separator" />
        <section class="p-3">
            <div class="table-container p-3 mb-5 table-color rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado </h3>
                <table class="table table-bordered border-dark">
                    <thead class="table-info table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Codigo</th>
                            <th scope="col">Estado</th>
                            <th scope="col" class="w-25">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="teacher in teachers" :key="teacher.id">
                            <th scope="row">{{ teacher.id }}</th>
                            <td>{{ teacher.teacher }}</td>
                            <td>{{ teacher.last_name }}</td>
                            <td>{{ teacher.code }}</td>
                            <td>{{ teacher.status }}</td>
                            <td class="d-flex justify-content-center">
                                <button type="button" class="btn btn-primary me-2">Modificar</button>
                                <button type="button" class="btn btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</template>