<script>
export default {
    mounted() {
        this.getNotes();
    },
    data() {
        return {
            notes: [],
            noteSelected: [],
        }
    },
    methods: {
        async getNotes() {
            try {
                const response = await this.axios.get('/api/getNotas')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.notes = response.data
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
        selectNote(event, note) {
            this.noteSelected = []
            this.noteSelected.push(note)
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
                            <th scope="col" class="w-10">Ciclo</th>
                            <th scope="col" class="w-10">Asignatura</th>
                            <th scope="col" class="w-10">Nombre</th>
                            <th scope="col" class="w-10">Codigo</th>
                            <th scope="col" class="w-10">Grupo</th>
                            <th scope="col" class="w-10">Evalucion #1</th>
                            <th scope="col" class="w-10">Porcentaje</th>
                            <th scope="col" class="w-10">Evalucion #2</th>
                            <th scope="col" class="w-10">Porcentaje</th>
                            <th scope="col" class="w-10">Evalucion #3</th>
                            <th scope="col" class="w-10">Porcentaje</th>
                            <th scope="col" class="w-10">Evalucion #4</th>
                            <th scope="col" class="w-10">Porcentaje</th>
                            <th scope="col" class="w-10">Evalucion #5</th>
                            <th scope="col" class="w-10">Porcentaje</th>
                            <th scope="col" class="w-10">Resultado Final</th>
                            <th scope="col" class="w-10">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="note in notes" :key="note.id">
                            <th scope="row">{{ note.id }}</th>
                            <td>{{ note.cycle }}</td>
                            <td>{{ note.subject }}</td>
                            <td>{{ note.name }} {{ note.last_name }}</td>
                            <td>{{ note.code }}</td>
                            <td>{{ note.group }}</td>
                            <td>{{ note.ev1 }}</td>
                            <td>{{ note.percentege1 }}</td>
                            <td>{{ note.ev2 }}</td>
                            <td>{{ note.percentege2 }}</td>
                            <td>{{ note.ev3 }}</td>
                            <td>{{ note.percentege3 }}</td>
                            <td>{{ note.ev4 }}</td>
                            <td>{{ note.percentege4 }}</td>
                            <td>{{ note.ev5 }}</td>
                            <td>{{ note.percentege5 }}</td>
                            <td>{{ note.finalAverage }}</td>
                            <td>{{ note.status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</template>