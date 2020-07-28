<template>
    <div class="form-container" id="loadingContainer" ref="loadingContainer">
        <div class="row">
            <div class="col-md-12 ml-2">
                    <table class="table" >
                        <thead>
                        <tr class="" style="background-color: lightgray;">
                            <th>Title</th>
                            <th>Status</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Product Category Name</th>
                            <th>Product Brand Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(wish, index) in wishes" v-if="wishes.length > 0">
                            <td>{{ wish.title}}</td>
                            <td>{{ wish.status  }}</td>
                            <td>{{ wish.product.name}}</td>
                            <td>{{ wish.product.price}}</td>
                            <td>{{ wish.product.category.name}}</td>
                            <td>{{ wish.product.brand.name}}</td>
                        </tr>
                        <tr v-if="wishes.length <= 0">
                            <td colspan="6" class="text-center">
                                <strong>No wish was found</strong>
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
                wishes: []
            }
        },

        methods: {
            getTimeline() {
                axios({
                    method: this.method,
                    url: this.url
                }).then(response => {
                    this.wishes = response.data.data
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
