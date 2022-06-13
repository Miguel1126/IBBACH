<template>
    <main>
        <div class="cards-container">
            <section class="card p-3 mb-5 bg-body rounded">
                <h3>Reporte general de carga academica</h3>
                <a href="/testpdf/loads_report.pdf" target="_blank">Generar reporte <i class="material-icons">description</i></a>
            </section>
            <section class="card p-3 mb-5 bg-body rounded">
                <h3>Reporte de carga academica filtrado por ciclos</h3>
                <a href="/testpdf/loads_report_cicle.pdf" target="_blank">Generar reporte <i class="material-icons">description</i></a>
            </section>
        </div>
    </main>
</template>

<style scoped>
.cards-container {
    display: flex;
    flex-direction: row;
}
.card {
    min-width: 20rem;
    height: 10rem;
    box-shadow: 5px 5px 2px 1px rgba(255, 255, 255, 0.75);
    margin: 20px;
}
.card h3 {
    color: #000;
}
.card a {
    margin-top: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    background: rgb(89, 81, 81);
    text-align: center;
    border-radius: 10px;
    width: 140px;
    height: 45px;
    text-decoration: none;
}
</style>