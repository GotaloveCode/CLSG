<template>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-9 form-group">
                <ValidationProvider name="Specific Objective[]" rules="required"
                                    v-slot="{ errors }">
                    <textarea v-model="objective.description" class="form-control" placeholder="eg. i. Develop workable plans and activities to drive increased water and sanitation;
ii.	Increase access to affordable quality water and sanitation services to all the Low Income Area (LIA) residents;
iii.	Attract and maintain low income consumers low income consumers as paying customers;
iv.	Reduce the WSP’s NRW from the current_____% to_______%;
v.	Increase the WSP’s revenue from the current_____% to_______%;
vi.	Aggressively create awareness about supporting services such as alternatives modes of payments offered by the WSP;
"></textarea>
                    <span class="text-danger">{{ errors[0] }}</span>
                </ValidationProvider>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-sm btn-primary" @click="$emit('add')">
                    <span class="feather icon-plus"></span>
                </button>
                <button type="button" class="btn btn-sm btn-danger" @click="$emit('remove')">
                    <span class="feather icon-minus"></span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ObjectiveRow",
    props: {
        objective: {required: true, type: Object},
    }
}
</script>
