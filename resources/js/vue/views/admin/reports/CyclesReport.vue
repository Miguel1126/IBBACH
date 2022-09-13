<script>
import DataTable from '../../../components/DataTable.vue'
export default {
    mounted() {
        this.getCyclesReport(1, true);
    },
    data() {
        return {
            cycles: [],
            start_date: [],
            end_date: [],
            status: [],
            groups: [],
            paginationLinks: []
        };
    },
    methods: {
        async getCyclesReport(pageNumber, firstCycle = false) {
            if (firstCycle) this.cycles[0] = 'loading'
    
                if (typeof (pageNumber) == 'string') {
                    pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
                }
                try {
                    this.cycles[0] = 'loading'
                const response = await this.axios.get('/api/getCyclesReport?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.cycles = response.data.data;
                        this.paginationLinks = response.data.links
                    }
                    else {
                        this.cycles[0] = "error";
                    }
                }
            }
            catch {(error) 
                console.error(error);
                this.cycles[0] = "error";

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
            <DataTable title="Listado de Ciclos" :headers="[
                { title: 'Id' },
                { title: 'Ciclos' },
                { title: 'Fecha de inicio' },
                { title: 'Fecha de finalización' },
                { title: 'Estado' },
                { title: 'Grupo' },
            ]" :items="cycles">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                    <ul class="pagination">
                        <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                            v-for="page in paginationLinks" :key="page">
                            <span class="page-link" @click="getCyclesReport(page.url)">{{ page.label == 'pagination.previous'
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