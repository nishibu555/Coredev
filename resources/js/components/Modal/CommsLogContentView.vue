<template>
    <div>
        <span>
        <a type="#" class="ti-eye text-success" v-if="log_content" @click.prevent="show" title="View Detail"></a>
        </span>
        <b-modal
            id="showContent" ref="showContent"
            title="Show Content Detail"
            :header-bg-variant="''"
            :header-text-variant="'black'">

            <div class="d-block text-center">
                <span v-html="log_content"></span>
            </div>

            <div slot="modal-footer">
                <b-btn class="float-right btn btn-danger mr-3" @click="hide">
                    Close
                </b-btn>
            </div>
        </b-modal>
    </div>
</template>


<script>
    export default {
        name: 'CommsLogContentView',
        props: {
            content: { type: String, required: true}
        },
        data() {
            return {
                log_content: this.content
            }
        },
        methods: {
            show() {
                this.$refs.showContent.show();
            },
            hide() {
                this.$refs.showContent.hide();
            }
        }
    }
</script>

<style scoped>

</style>
