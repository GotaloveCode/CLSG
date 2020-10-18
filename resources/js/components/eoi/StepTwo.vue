<template>
    <div>
        <h5>Breakdown of short-term COVID-19 related emergency interventions and estimated costs:</h5>
        <table class="table">
            <thead>
            <tr>
                <th>Type of service / items</th>
                <th>Name of Low income area and number of facilities required</th>
                <th>Total No. required</th>
            </tr>
            </thead>
            <tr is="service-row"
                v-for="(d, index) in eoi.services"
                @add="addService"
                @remove="removeService(index)"
                :services="services"
                :service="d"
                v-bind:key="index"
                :index="index">

            </tr>
        </table>
    </div>
</template>

<script>
import ServiceRow from "./ServiceRow";


export default {
    components: {
        ServiceRow,
    },
    props: {
        eoi: {required: true, type: Object},
        services: {required: true, type: Array},
    },
    methods: {
        addService() {
            this.eoi.services.push({areas: "", total: "", service_id: null});
        },
        removeService(index) {
            if (this.eoi.services.length > 1) {
                this.eoi.services.splice(index, 1);
            }
        }
    }
}
</script>

