<script>
import DataTable from '../../../components/DataTable.vue';
import { handleErrors } from '../../../js/handle_error';
export default {
    mounted() {
        this.getApplicant(1, true);
    },
    data() {
        return {
            Applicant:[],
            paginationLinks: [],
            siteUrl: window.location.origin
        };
    },
    methods: {
        async getApplicant(pageNumber, firstApplicant = false) {
            if (firstApplicant) this.Applicant[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }

            try {
                const response = await this.axios.get('/api/getApplicants?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.Applicant = response.data.data;
                        this.paginationLinks = response.data.links
                    }
                    else {
                        this.Applicant[0] = 'error'
                    }
                }
            }
            catch (error) {
                this.Applicant[0] = 'error'
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
                { title: 'Direccion', value: 'address' },
                { title: 'Nacionalidad', value: 'nationality' },
                { title: 'Fecha de nacimiento', value: 'birth_date' },
                { title: 'Estado civil', value: 'marital_status' },
                { title: 'Nombre del conyuge', value: 'mate_name' },
                { title: 'Grado secular', value: 'secular_degree' },
                { title: 'Ocupacion actual', value: 'current_ocupation' },
                { title: 'Foto', value: 'extra' }
            ]" :items="Applicant">
            <template #actions="item">
                <img style="width: 200px; height: 200px"  :src="`${siteUrl}/images/users/${item.item.img}`" />
            </template>
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
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
                { title: 'Nombre', value: 'name' },
                { title: 'Apellido', value: 'last_name' },
                { title: 'Es pastor', value: 'is_pastor' },
                { title: 'Es miembro', value: 'is_member' },
                { title: 'Telefono', value: 'pastor_phone' },
                { title: 'Nombre de la iglesia', value: 'church_name' },
                { title: 'Direccion de la iglesia', value: 'church_address' },
                { title: 'Telefono de la iglesia', value: 'church_phone' },
                { title: 'Distrito', value: 'district' },
                { title: 'Pastor de la iglesia', value: 'pastor_name' },
                { title: 'Licencia', value: 'licence' },
                { title: 'Pastor', value: 'reference_name_one' },
                { title: 'Telefono', value: 'reference_phone_one' },
                { title: 'Pastor', value: 'reference_name_two' },
                { title: 'Telefono', value: 'reference_phone_two' },
                { title: 'Cuando acepto a cristo', value: 'christ_accepted' },
                { title: 'Fecha de bautizo', value: 'christening_date' },
                { title: 'Tiempo siendo miembro', value: 'time_being_member' },
                { title: 'Privilegios donde se desempeño', value: 'privileges_held' },
                { title: 'Demominacion a la pertenece', value: 'denomination' },
                { title: 'Interes de estudio', value: 'study_reason' },
            ]" :items="Applicant">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
                        <span class="page-link" @click.prevent="getEcclesiasticalInfo(page.url)">{{ page.label ==
                        'pagination.previous'
                        ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
            </nav>
        </section>
        <section class="p-3">
            <DataTable title="Informacion Ministerial" personalized :headers="[
                { title: 'Nombre', value: 'name' },
                { title: 'Apellido', value: 'last_name' },
                { title: 'Miniserios desempeñados', value: 'ministry_performed' },
                { title: 'Ministerio actual', value: 'current_ministry' },
                { title: 'Tiempo completo', value: 'full_time' },
                { title: 'Calificasion del ministerio actual', value: 'ministry_qualification' },
                { title: 'Ministerio deseado', value: 'aspirated_ministry' },
                { title: 'Porque cree asi', value: 'reason_aspiring_ministry' },
                { title: 'Ciclo correspondiente', value: 'cicle_to_be_taken' },
                { title: 'Institucion donde estudio', value: 'previous_institution' },
                { title: 'Ultimo año estudiado', value: 'last_year_studied'},
                { title: 'Cualidades', value: 'qualities_religious_worker' },
            ]" :items="Applicant">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
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