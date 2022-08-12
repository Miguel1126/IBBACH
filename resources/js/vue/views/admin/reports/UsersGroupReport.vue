<script>
import DataTable from '../../../components/DataTable.vue';
export default {
    mounted() {
        this.getGroupD();
        this.getGroupS();
    },
    data() {
        return {
            usersD: [],
            usersS: [],
            editing: false
        };
    },
    methods: {
        async getGroupD() {
            try {
                const response = await this.axios.get("/api/getGrupoD");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.usersD = response.data;
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
        async getGroupS() {
            try {
                const response = await this.axios.get("/api/getGrupoS");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.usersS = response.data;
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
    }
}
</script>
<template>
    <main>
        <section class="p-3">
            <DataTable title="Listado de alumnos inscritos en el grupo diurno" :headers="[
                { title: 'Id' },
                { title: 'Fecha de inscripcion' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Grupo' }
            ]" :items="usersD">
            </DataTable>
        </section>
        <section class="p-3">
            <DataTable title="Listado de alumnos inscritos en el grupo sabatino" :headers="[
                { title: 'Id' },
                { title: 'Fecha de inscripcion' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Grupo' }
            ]" :items="usersS">
            </DataTable>
        </section>
    </main>
</template>
