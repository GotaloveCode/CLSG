<template>
    <div>
        <h5>Breakdown of short-term COVID-19 related emergency interventions and estimated costs:</h5>
        <table class="table">
            <thead>
            <tr>
                <th>Type of service / items</th>
                <th>Name of Low income area</th>
                <th>Total No. of facilities required</th>
                <th></th>
            </tr>
            </thead>
            <tr>
                <th colspan="4">People served by</th>
            </tr>
            <tr is="connection-row"
                v-for="(d, index) in eoi.connections"
                @add="addConnection"
                @remove="removeConnection(index)"
                :connections="connections"
                :connection="d"
                v-bind:key="index"
                :index="index"></tr>
        </table>
    </div>
</template>

<script>
import ConnectionRow from "./ConnectionRow";


export default {
    components: {
        ConnectionRow,
    },
    props: {
        eoi: {required: true, type: Object},
        connections: {required: true, type: Array},
    },
    methods: {
        addConnection() {
            this.eoi.connections.push({areas: "", total: "", connection_id: null});
        },
        removeConnection(index) {
            if (this.eoi.connections.length > 1) {
                this.eoi.connections.splice(index, 1);
            }
        }
    }
}
</script>

