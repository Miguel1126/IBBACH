<script>
import DataTable from '../../../components/DataTable.vue';
export default {
    mounted() {
        this.getInscriptionsD();
        this.getInscriptionsS()

    },
    data() {
        return {
            inscriptionsD: [],
            inscriptionsS: []
        };
    },
    methods: {
        async getInscriptionsD() {
            try {
                const response = await this.axios.get("/api/getInscrip");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.inscriptionsD = response.data;
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
         async getInscriptionsS() {
            try {
                const response = await this.axios.get("/api/getInscript");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.inscriptionsS = response.data;
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
        <section class="p-3">
            <DataTable title="Listado de alumnos inscritos en el grupo diurno" :headers="[
                { title: 'Id' },
                { title: 'Fecha de registro' },
                { title: 'Estado' },
                { title: 'Ciclo' },
                { title: 'Grupo' },
                { title: 'Alumno' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Asignatura' },
                { title: 'Descripcion' }
            ]" :items="inscriptionsD">
            </DataTable>
        </section>
        <section class="p-3">
            <DataTable title="Listado de alumnos inscritos en el grupo sabatino" :headers="[
                { title: 'Id' },
                { title: 'Fecha de registro' },
                { title: 'Estado' },
                { title: 'Ciclo' },
                { title: 'Grupo' },
                { title: 'Alumno' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Asignatura' },
                { title: 'Descripcion' }
            ]" :items="inscriptionsS">
            </DataTable>
        </section>
    </main>
</template>

<style scoped>
</style>