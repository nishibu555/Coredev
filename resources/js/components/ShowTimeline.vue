<template>
    <div class="form-container" id="loadingContainer" ref="loadingContainer">
        <div class="row">
            <div class="col-md-12 ml-2">
                    <table class="table" >
                        <thead>
                        <tr class="" style="background-color: lightgray;">
                            <th>Receiver Name</th>
                            <th>Relation</th>
                            <th>Occasion</th>
                            <th>Gift Item</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(timeline, index) in timelines" v-if="timelines.length > 0">
                            <td>{{ timeline.receiver.first_name + ' ' + timeline.receiver.last_name}}</td>
                            <td>{{ timeline.receiver.connection.relation}}</td>
                            <td>{{ timeline.occasion  }}</td>
                            <td>{{ timeline.gift_item }}</td>
                            <td>{{ timeline.price  }}</td>
                            <td>{{ timeline.status  }}</td>
                            <td>{{ timeline.formatted_date }}</td>
                        </tr>
                        <tr v-if="timelines.length <= 0">
                            <td colspan="6" class="text-center">
                                <strong>No timeline was found on</strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['url', 'method'],
        data() {
            return {
                timelines: []
            }
        },

        methods: {
            getTimeline() {
                axios({
                    method: this.method,
                    url: this.url
                }).then(response => {
                    this.timelines = response.data.data
                }).catch(error => {
                    console.log(error.response.data.errors)
                });
            }
        },

        mounted() {
            this.getTimeline();
        }
    }
</script>
