<template>
    <div>
        <form @submit.prevent="fetchData()">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Month</label>
                    <select class="form-control" v-model="month" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Year</label>
                    <select v-model="year" class="form-control" required>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2024">2025</option>
                    </select>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary"> <i class="fa fa-search" aria-hidden="true"></i> Fetch Verification</button>
            </div>
        </form>


    </div>
</template>

<script>
import {SET_VERIFICATIONS,SET_SCORES} from "./../../store/verification";
import {mapGetters} from "vuex";
export default {
    data(){
        return {
            month:'',
            year:''
        }
    },
    created(){
        this.$store.dispatch(SET_SCORES);
    },
    computed:{
        ...mapGetters(['getVerification'])
    },
    methods:{
        fetchData(){
            this.$store.dispatch(SET_VERIFICATIONS,{month:this.month,year:this.year})
                .then(res => {
                    setTimeout(()=>{
                        if (Object.keys(this.getVerification).length ===0){
                            eventBus.$emit("verification_form")
                        }else {
                            eventBus.$emit("view_verification")
                        }
                    },1000)

                })
        }
    }

}
</script>
