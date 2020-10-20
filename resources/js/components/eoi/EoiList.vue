<template>
  <div>
      <v-app id="inspire">
          <v-card>
              <v-card-title>
                  <v-spacer></v-spacer>
                  <v-text-field
                      v-model="search"
                      append-icon="mdi-magnify"
                      label="Search"
                      single-line
                      hide-details
                  ></v-text-field>
              </v-card-title>
              <v-data-table
                  :headers="headers"
                  :items="eois"
                  :search="search"
              >
                  <template v-slot:item.actions="{ item }">
                   <button class="btn btn-info btn-sm" :title="'Review'" @click="review(item.id)"><i class="fa fa-eye"></i></button>

                  </template>
              </v-data-table>

          </v-card>
      </v-app>
  </div>
</template>

<style lang="scss">
@import "~vuetify/dist/vuetify.min.css";

.theme--light.v-application {
    background: transparent !important;
}
.v-application code {
    box-shadow: none !important;
}
.v-menu__content{
    left: 74% !important;
    top: 58% !important;
}

</style>

<script>
import '@mdi/font/css/materialdesignicons.css';
import FielDefs from "./FieldDefs";
export default {
    props:{
        eois:{type: Array}
    },
    data () {
        return {
            search: '',
            headers: FielDefs
        }
    },
    methods:{
        review(id){
          window.location.href='/eoi/'+id+'/review';
        }
    }
}
</script>
