<script>
import DataTable from '../../../components/DataTable.vue';
import { handleErrors } from '../../../js/handle_error';
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
                    this.usersD = response.data;
                }
                else {
                    this.usersD[0] = 'error'
                }
            } 
            catch (error) {
                handleErrors(error)
                this.usersD[0] = 'error'
            }
        },
        async getGroupS() {
            try {
                const response = await this.axios.get("/api/getGrupoS");
                if (response.status === 200) {
                    this.usersS = response.data;
                }
                else {
                    this.usersS[0] = 'error'
                }
            } 
            catch (error) {
                handleErrors(error)
                this.usersS[0] = 'error'
            }
        },
    },
    components: {DataTable}
}
</script>
<template>
    <main>
        <section class="p-3">
            <DataTable title="Listado de alumnos inscritos en la modalidad diurna" personalized :headers="[
                { title: 'Nombre', value: 'name' },
                { title: 'Apellido', value: 'last_name'},
                { title: 'Codigo', value: 'code' },
                { title: 'Modalidad', value: 'group' }
            ]" :items="usersD">
            </DataTable>
        </section>
        <section class="p-3">
            <DataTable title="Listado de alumnos inscritos en la modalidad sabatina" personalized :headers="[
                  { title: 'Nombre', value: 'name' },
                { title: 'Apellido', value: 'last_name'},
                { title: 'Codigo', value: 'code' },
                { title: 'Modalidad', value: 'group' }
            ]" :items="usersS">
            </DataTable>
        </section>
    </main>
</template>
