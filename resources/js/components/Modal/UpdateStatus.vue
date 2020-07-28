<template>
    <div>
        <span>
        <a type="#" class="ti-pencil-alt" @click.prevent="show" title="update status"></a>
        </span>
        <b-modal
            id="updateStatus" ref="updateStatus"
            title="Update Status"
            :header-bg-variant="''"
            :header-text-variant="'black'">

            <div class="d-block text-center">
                <b-form-select v-model="status" :options="gift_plans_statuses"></b-form-select>
            </div>

            <div slot="modal-footer">
                <b-btn class="float-right btn btn-info" @click="submit">
                    <span>Update</span>
                </b-btn>
                <b-btn class="float-right btn btn-danger mr-3" @click="hide">
                    Close
                </b-btn>
            </div>
        </b-modal>
    </div>
</template>


<script>
    export default {
        name: 'UpdateStatus',
        props: {
            url: { type: String, required: true},
            gift_plans_statuses : { type: Array, required: true },
            gift_plan_status : { type: String, required: true },
        },
        data() {
            return {
                status: this.gift_plan_status
            }
        },
        methods: {
            show() {
                this.$refs.updateStatus.show();
            },
            hide() {
                this.$refs.updateStatus.hide();
            },

            submit() {
                this.$validator.validate().then(result => {
                    if (result) {
                        axios.post(this.url, {status: this.status})
                            .then(response => {
                                if (response.data) {
                                    this.hide();
                                    window.location.href = response.data.redirect_url
                                }
                            })
                            .catch(error => {
                                this.errorList = error.response.data.errors
                            })
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>
