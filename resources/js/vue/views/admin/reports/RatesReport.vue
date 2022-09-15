<script>
import DataTable from '../../../components/DataTable.vue';
export default {
    mounted() {
       this.getrates(1, true);
        
    },
    data() {
        return {
            Rates: [],
            paginationLinks: []
        };
    },
    methods: {
         async getrates(pageNumber, firstrates = false) {
            if(firstrates) this.Rates[0] = 'loading'
            if(typeof(pageNumber) == 'string'){
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getrates?page=' + pageNumber)
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.Rates = response.data.data;
                        this.paginationLinks = response.data.links
                    }
                    else {
                        this.Rates[0] = 'error'
                    }
                }
            }
            catch (error) {
                console.error(error);
                this.Rates[0] = 'error'
            }
        },
    },
    components: { DataTable }
}        
</script>
<template>
 <main>
    <section class="p-3">
            <DataTable title="Listado de cuotas" :headers="[
                { title: 'id'},
                { title: 'Precio' },
                { title: 'Matricula' }
            ]" :items="Rates">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                    <ul class="pagination">
                        <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                            v-for="page in paginationLinks" :key="page">
                            <span class="page-link" @click="getrates(page.url)">{{ page.label == 'pagination.previous'
                                    ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                            }}</span>
                        </li>
                    </ul>
                </nav>
        </section>
    </main>
</template>

<style scoped>
</style>