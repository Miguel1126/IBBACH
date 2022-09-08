<script>
import DataTable from '../../../components/DataTable.vue';
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
            PersonalInfo:[],
            EcclesiasticalInfo:[],
            MinisterialInfo:[],
            paginationLinks:[],
            paginationLinks2:[],
            paginationLinks3:[]
        };
    },
    methods: {
        async getPersonalInfo(pageNumber, firstLoad = false) {
            if (firstLoad) this.PersonalInfo[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }

            try {
                const response = await this.axios.get('/api/getPersonalInfo?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.PersonalInfo = response.data.data;
                        this.paginationLinks = response.data.links
                    }
                     else {
                        this.PersonalInfo[0] = 'error'
                    }
                }
            }
            catch (error) {
                this.PersonalInfo[0] = 'error'
                console.error(error);
            }
        },
        async getEcclesiasticalInfo(pageNumber, firstLoad = false) {
            if (firstLoad) this.EcclesiasticalInfo[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }

            try {
                const response = await this.axios.get('/api/getEcclesiasticalInfo?page=' + pageNumber);
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
                console.error(error);
            }
        },
        async getMinisterialInfo(pageNumber, firstLoad = false) {
            if (firstLoad) this.MinisterialInfo[0]= 'loading'
            if(typeof(pageNumber) == 'string'){
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getMinisterialInfo?page=' + pageNumber);
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
            <DataTable title="Informacion Personal" :headers="[
                { title: '#', value: 'id' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Correo' },
                { title: 'Telefono' },
                { title: 'Direccion' },
                { title: 'Nacionalidad' },
                { title: 'Fecha de nacimiento' },
                { title: 'Estado civil' },
                { title: 'Nombre del conyuge' },
                { title: 'Grado secular' },
                { title: 'Ocupacion actual' },
            ]" :items="PersonalInfo">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
                        <span class="page-link" @click.prevent="getPersonalInfo(page.url)">{{ page.label == 'pagination.previous'
                                ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
                </nav>
        </section>
        <section class="p-3">
            <DataTable title="Informacion Eclesiastica" :headers="[
                { title: '#', value: 'id' },
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
                        <span class="page-link" @click.prevent="getEcclesiasticalInfo(page.url)">{{ page.label == 'pagination.previous'
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
                        <span class="page-link" @click.prevent="getMinisterialInfo(page.url)">{{ page.label == 'pagination.previous'
                                ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
            </nav>
        </section>
    </main>
</template>