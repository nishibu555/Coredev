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
                            <th>Repeatble</th>
                            <th>Visibility</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(event, index) in events" v-if="events.length > 0">
                            <td>{{ event.user.first_name + ' ' + event.user.last_name }}</td>
                            <td>{{ event.user.connection.relation  }}</td>
                            <td>{{ event.occasion  }}</td>
                            <td>{{ event.is_repeat ? 'yes' : 'no'  }}</td>
                            <td>{{ event.visibility  }}</td>
                            <td>{{ event.formatted_date }}</td>
                        </tr>
                        <tr v-if="events.length <= 0">
                            <td colspan="6" class="text-center">
                                <strong>No events was found on</strong>
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
                events: []
            }
        },

        methods: {
            getEvents() {
                axios({
                    method: this.method,
                    url: this.url
                }).then(response => {
                    this.events = response.data.data
                }).catch(error => {
                    console.log(error.response.data.errors)
                });
            }
        },

        mounted() {
            this.getEvents();
        }
    }
</script>
