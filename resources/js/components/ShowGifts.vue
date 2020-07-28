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
                        <tr v-for="(gift, index) in gifts" v-if="gifts.length > 0">
                            <td>{{ gift.receiver.first_name + ' ' + gift.receiver.last_name}}</td>
                            <td>{{ gift.receiver.connection.relation}}</td>
                            <td>{{ gift.occasion  }}</td>
                            <td>{{ gift.gift_item }}</td>
                            <td>{{ gift.price  }}</td>
                            <td>{{ gift.status  }}</td>
                            <td>{{ gift.formatted_date }}</td>
                        </tr>
                        <tr v-if="gifts.length <= 0">
                            <td colspan="6" class="text-center">
                                <strong>No gift was found</strong>
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
                gifts: []
            }
        },

        methods: {
            getTimeline() {
                axios({
                    method: this.method,
                    url: this.url
                }).then(response => {
                    this.gifts = response.data.data
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
