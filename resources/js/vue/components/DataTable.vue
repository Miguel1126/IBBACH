<script setup>
import { onMounted } from "@vue/runtime-core"

const props = defineProps({
    title: String,
    personalized: {
        type: Boolean,
        default: false
    },
    headers: Array,
    items: Array,
})
const getValues = (item) => {

    if (props.personalized) {
        let headers = [...props.headers]

        let filteredItem = []

        if (headers.at(-1).title == 'Acciones') {
            headers = headers.slice(0, -1)
        }

        headers.forEach(header => {
            filteredItem.push(Object.keys(item).filter((key) => key == header.value).reduce((cur, key) => { return Object.assign(item[key]) }, {}))
        })
        return filteredItem
    }
    else {
        return Object.values(item)
    }
}
</script>
<template>
    <div class="p-3 table-color rounded">
        <h3 class="h3 fw-semibold mb-3 text-black">{{ title }}</h3>
        <div v-if="items[0] === 'loading'" class="d-flex justify-content-center">
            <div class="waveform">
                <div class="waveform__bar"></div>
                <div class="waveform__bar"></div>
                <div class="waveform__bar"></div>
                <div class="waveform__bar"></div>
            </div>
        </div>
        <div v-else-if="!items.length" class="d-flex justify-content-center">
            <h4 class="text-black">No hay datos para mostrar</h4>
        </div>
        <div v-else-if="items[0] === 'error'" class="d-flex justify-content-center">
            <h4 class="text-black">Ups... Ocurrió un error, inténtalo de nuevo más tarde.</h4>
        </div>
        <div class="table-container d-flex justify-content-center" v-else>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th class="text-center" v-for="header in headers" :key="header" scope="col">{{ header.title }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items" :key="item">
                        <td class="text-center" v-for="itemValue in getValues(item)" :key="itemValue">{{ itemValue }}
                        </td>
                        <td class="actions-row" v-if="headers[headers.length - 1].title == 'Acciones'">
                            <slot :item="item" name="actions"></slot>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
.table-container {
    scrollbar-color: #eee #eee;
    scrollbar-width: thin;
}
:-webkit-scrollbar {
    width: 0.25rem;
}
::-webkit-scrollbar-track {
    background: #eee;
}
::-webkit-scrollbar-thumb {
    background: #eee;
}
.styled-table {
    color: #000;
    border-collapse: collapse;
    margin: 25px 0;
    border-radius: 20px !important;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    width: 100%;
}

.styled-table thead tr {
    background-color: #009879;
    color: #ffffff;
    text-align: left;
}

.styled-table th,
.styled-table td {
    padding: 12px 15px;
}

.styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}

.styled-table tbody tr.active-row {
    font-weight: bold;
    color: #009879;
}

.actions-row {
    display: flex;
    justify-content: center;
}

.table-color {
    background-color: #eee;
}

.table-container {
    overflow-x: scroll;
}

tr:hover {
    background-color: #dddddd;
}

/**loader styles */
.waveform {
    --uib-size: 40px;
    --uib-speed: 1s;
    --uib-color: black;
    --uib-line-weight: 3.5px;

    display: flex;
    flex-flow: row nowrap;
    align-items: center;
    justify-content: space-between;
    width: var(--uib-size);
    height: calc(var(--uib-size) * 0.9);
}

.waveform__bar {
    width: var(--uib-line-weight);
    height: 100%;
    background-color: var(--uib-color);
}

.waveform__bar:nth-child(1) {
    animation: grow var(--uib-speed) ease-in-out calc(var(--uib-speed) * -0.45) infinite;
}

.waveform__bar:nth-child(2) {
    animation: grow var(--uib-speed) ease-in-out calc(var(--uib-speed) * -0.3) infinite;
}

.waveform__bar:nth-child(3) {
    animation: grow var(--uib-speed) ease-in-out calc(var(--uib-speed) * -0.15) infinite;
}

.waveform__bar:nth-child(4) {
    animation: grow var(--uib-speed) ease-in-out infinite;
}

@keyframes grow {

    0%,
    100% {
        transform: scaleY(0.3);
    }

    50% {
        transform: scaleY(1);
    }
}
</style>