<template>
    <div>
        <span>
        <a type="#" class="ti-arrow-circle-down text-success" v-if="user_status" @click.prevent="show" title="Make Inactive"></a>
        <a type="#" class="ti-arrow-circle-down text-danger" v-else @click.prevent="show" title="Make Active"></a>
        </span>
        <b-modal
            id="updateUserStatus" ref="updateUserStatus"
            title="Update User Status"
            :header-bg-variant="''"
            :header-text-variant="'black'">

            <div class="d-block text-center">
                <h4 v-if="user_status">Are you want to inactive the user?</h4>
                <h4 v-else>Are you want to active the user?</h4>
            </div>

            <div slot="modal-footer">
                <b-btn class="float-right btn btn-info" @click="submit">
                    <span>Yes</span>
                </b-btn>
                <b-btn class="float-right btn btn-danger mr-3" @click="hide">
                    No
                </b-btn>
            </div>
        </b-modal>
    </div>
</template>


<script>
    export default {
        name: 'ActiveInactiveUser',
        props: {
            url: { type: String, required: true},
            status : { type: Boolean, required: true },
        },
        data() {
            return {
                user_status: this.status
            }
        },
        methods: {
            show() {
                this.$refs.updateUserStatus.show();
            },
            hide() {
                this.$refs.updateUserStatus.hide();
            },

            submit() {
                this.$validator.validate().then(result => {
                    if (result) {
                        axios.post(this.url)
                            .then(response => {
                                if (response.data) {
                                    this.hide();
                                    location.href = response.data.redirect_url
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
