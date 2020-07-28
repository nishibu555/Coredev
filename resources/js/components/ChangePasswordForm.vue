<template>
    <b-form @submit.prevent="submit">
        <b-row>
            <b-col>
                <b-form-group label="Current Password"
                              label-for="current_password">
                    <b-form-input id="current_password"
                                  type="password"
                                  name="current password"
                                  button-variant="outline-primary"
                                  :state="Boolean(formData.current_password) && !errors.has('current password') && !errorList.current_password"
                                  v-validate="'required'"
                                  v-model="formData.current_password">
                    </b-form-input>
                    <div class="invalid-feedback" v-if="errors.has('current password') || errorList.current_password">
                        {{ errors.first('current password') || errorList.current_password[0] }}
                    </div>
                </b-form-group>
            </b-col>
            <b-col></b-col>
        </b-row>

        <b-row>
            <b-col>
                <b-form-group label="New Password"
                              label-for="new_password">
                    <b-form-input id="new_password"
                                  name="new password"
                                  type="password"
                                  button-variant="outline-primary"
                                  :state="Boolean(formData.new_password) && !errors.has('new password')"
                                  v-validate="'required|min:6'"
                                  data-vv-as="new password"
                                  v-model="formData.new_password"
                                  ref="password">
                    </b-form-input>
                    <div class="invalid-feedback" v-if="errors.has('new password') || errorList.new_password">
                        {{ errors.first('new password') || errorList.new_password[0] }}
                    </div>
                </b-form-group>
            </b-col>
            <b-col></b-col>
        </b-row>

        <b-row>
            <b-col>
                <b-form-group label="Confirm Password"
                              label-for="password_confirmation">
                    <b-form-input id="password_confirmation"
                                  name="password confirmation"
                                  type="password"
                                  button-variant="outline-primary"
                                  :state="Boolean(formData.password_confirmation) && !errors.has('password confirmation')"
                                  v-validate="'required|confirmed:password'"
                                  data-vv-as="confirm password"
                                  v-model="formData.password_confirmation">
                    </b-form-input>
                    <div class="invalid-feedback" v-if="errors.has('password confirmation') || errorList.password_confirmation">
                        {{ errors.first('password confirmation') || errorList.password_confirmation[0] }}
                    </div>
                </b-form-group>
            </b-col>
            <b-col></b-col>
        </b-row>
        <b-button type="submit" variant="primary submit mt-3" data-style="zoom-out">Submit</b-button>
    </b-form>
</template>

<script>
    export default {
        name: "ChangePasswordForm",
        props: {
            method: {type: String, required: true},
            url: {type: String, required: true},
        },

        data(){
            return{
                formData: {
                    current_password: '',
                    new_password: '',
                    password_confirmation: ''
                },
                errorList:{}
             }
        },
        methods: {
            submit(){
                let self = this;
                this.$validator.validate().then(result => {
                    if(result){
                        axios({
                            method: this.method,
                            url: this.url,
                            data: this.formData,
                        }).then(function (response) {
                            if(response.data.redirect_url) {
                                location.href = response.data.redirect_url;
                            }
                        }).catch(function (error) {
                            self.errorList = error.response.data.errors;
                            alertify.error(error.response.data.message);
                        });
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
