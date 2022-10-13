<script>
export default {
    mounted() {
        document.title = "IBBACH | Reportes"
    },
    data() {
        return {
            reports: [
                { icon: 'assignment_ind', name: 'Reporte de Asistencias', url: 'AssistanceReports' },
                { icon: 'school', name: 'Reporte de Notas', url: 'NotesStatusReports' },
            ]
        }
    }
}
</script>
<template>
    <main>
        <div class="container text-light">
            <h1 class="h1 mb-4 text-center border-bottom border-secondary p-3">Reportes del docente</h1>
            <div class="row gap-3 justify-content-center">
                <div class="col col-sm-3" v-for="report in reports" :key="report">
                    <div class="card border border-secondary w-100 p-3">
                        <div class="d-flex justify-content-center">
                            <span class="material-symbols-outlined icon text-center">{{ report.icon }}</span>
                        </div>
                        <div class="card-title mt-2">
                            <p class="fs-3 fw-bold text-center">{{ report.name }}</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-center">
                            <router-link class="btn btn-secondary" :to="{ name: report.url }">Ir al reporte</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<style scoped>
.card {
    background-color: var(--dark);
    transition: all 300ms ease;
    min-width: 185px;
}
.card:hover {
    box-shadow: 4px 4px 4px #ffffff7e;
    transform: translate(-10px,-11px);

}
.icon {
    font-size: 4.4em;
    font-size: 72px;
    background: -webkit-linear-gradient(45deg, #09009f, #00ff95 80%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>