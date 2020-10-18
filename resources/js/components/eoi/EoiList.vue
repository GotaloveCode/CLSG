<template>
  <div>
      <v-app id="inspire">
          <v-card>
              <v-card-title>
                  Nutrition
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
                      <v-btn class="mx-1 my-1"  dark color="cyan" small @click="showItem(item.createdAt)">
                          <v-icon small>mdi-eye</v-icon>
                      </v-btn>
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
    left: 73% !important;
    top: 70% !important;
}

</style>

<script>
import FielDefs from "./FieldDefs"
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
    method:{
        showItem(item){
            return item;
        }
    }
}
</script>
