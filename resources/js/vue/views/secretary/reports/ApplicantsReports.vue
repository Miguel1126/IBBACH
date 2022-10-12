<script>
import DataTable from '../../../components/DataTable.vue';
import { handleErrors } from '../../../js/handle_error';
export default {
    mounted() {
        //this.getApplicant();
        this.getPersonalInfo(1, true);
        this.getEcclesiasticalInfo(1, true);
        this.getMinisterialInfo(1, true);
    },
    data() {
        return {
            //Applicant:[],
            PersonalInfo: [],
            EcclesiasticalInfo: [],
            MinisterialInfo: [],
            paginationLinks1: [],
            paginationLinks2: [],
            paginationLinks3: [],
            
        };
    },
    methods: {
        async getPersonalInfo(pageNumber, firstPersonalInfo = false) {
            if (firstPersonalInfo) this.PersonalInfo[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }

            try {
                const response = await this.axios.get('/api/getAplicants?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.PersonalInfo = response.data.data;
                        this.paginationLinks1 = response.data.links
                    }
                    else {
                        this.PersonalInfo[0] = 'error'
                    }
                }
            }
            catch (error) {
                this.PersonalInfo[0] = 'error'
                handleErrors(error)
            }
        },
        async getEcclesiasticalInfo(pageNumber, firstEcclesiasticalInfo = false) {
            if (firstEcclesiasticalInfo) this.EcclesiasticalInfo[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }

            try {
                const response = await this.axios.get('/api/getEcclesiasticalInform?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.EcclesiasticalInfo = response.data.data;
                        this.paginationLinks2 = response.data.links
                        console.log(response);
                    }
                    else {
                        this.PersonalInfo[0] = 'error'
                    }
                }
            }
            catch (error) {
                this.PersonalInfo[0] = 'error'
                handleErrors(error)
            }
        },
        async getMinisterialInfo(pageNumber, firstMinisterialInfo = false) {
            if (firstMinisterialInfo) this.MinisterialInfo[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getMinisterialInform?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.MinisterialInfo = response.data.data;
                        this.paginationLinks3 = response.data.links
                        console.log(response);
                    }
                    else {
                        this.MinisterialInfo[0] = 'error'
                    }
                }
            }
            catch (error) {
                this.MinisterialInfo[0] = 'error'
                handleErrors(error)
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
            <DataTable title="Informacion Personal" personalized :headers="[
                { title: 'Nombre', value: 'name' },
                { title: 'Apellido', value: 'last_name' },
                { title: 'Correo', value: 'email' },
                { title: 'Telefono', value: 'phone' },
                { title: 'Direccion', value:'address' },
                { title: 'Nacionalidad', value: 'nationality' },
                { title: 'Fecha de nacimiento', value: 'birth_date' },
                { title: 'Estado civil', value: 'marital_status' },
                { title: 'Nombre del conyuge', value: 'mate_name' },
                { title: 'Grado secular', value: 'secular_degree' },
                { title: 'Ocupacion actual', value: 'current_ocupation' },
                {title: 'Foto', value: 'extra'}
            ]" :items="PersonalInfo">
                <template #actions>
                    <img class="img-fluid" :src="`${siteUrl}/images/users/${item.item.img}`">
                </template> 

            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks1.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks1" :key="page">
                        <span class="page-link" @click.prevent="getPersonalInfo(page.url)">{{ page.label ==
                        'pagination.previous'
                        ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
            </nav>
        </section>
        <section class="p-3">
            <DataTable title="Informacion Eclesiastica" personalized :headers="[
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Es pastor' },
                { title: 'Es miembro' },
                { title: 'Telefono' },
                { title: 'Nombre de la iglesia' },
                { title: 'Direccion de la iglesia' },
                { title: 'Telefono de la iglesia' },
                { title: 'Distrito' },
                { title: 'Pastor de la iglesia' },
                { title: 'Licencia' },
                { title: 'Pastor' },
                { title: 'Telefono' },
                { title: 'Pastor' },
                { title: 'Telefono' },
                { title: 'Cuando acepto a cristo' },
                { title: 'Fecha de bautizo' },
                { title: 'Tiempo siendo miembro' },
                { title: 'Privilegios donde se desempeño' },
                { title: 'Demominacion a la pertenece' },
                { title: 'Interes de estudio' },
            ]" :items="EcclesiasticalInfo">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks2.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks2" :key="page">
                        <span class="page-link" @click.prevent="getEcclesiasticalInfo(page.url)">{{ page.label ==
                        'pagination.previous'
                        ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
            </nav>
        </section>
        <section class="p-3">
            <DataTable title="Informacion Ministerial" :headers="[
                { title: '#', value: 'id' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Miniserios desempeñados' },
                { title: 'Ministerio actual' },
                { title: 'Tiempo completo' },
                { title: 'Calificasion del ministerio actual' },
                { title: 'Ministerio deseado' },
                { title: 'Porque cree asi' },
                { title: 'Ciclo correspondiente' },
                { title: 'Institucion donde estudio' },
                { title: 'Ultimo año estudiado'},
                { title: 'Cualidades' },
            ]" :items="MinisterialInfo">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks3.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks3" :key="page">
                        <span class="page-link" @click.prevent="getMinisterialInfo(page.url)">{{ page.label ==
                        'pagination.previous'
                        ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
            </nav>
        </section>
    </main>
</template>