<template>
    <!-- Modal -->
    <!--    <div class="card card-shadowed p-50 w-400 mb-0" style="max-width: 100%">-->
    <!--        <h5 class="text-uppercase text-center">Login</h5>-->
    <!--        <br><br>-->

    <!--        <form>-->
    <!--            <div class="form-group">-->
    <!--                <input type="text" class="form-control" placeholder="Username">-->
    <!--            </div>-->

    <!--            <div class="form-group">-->
    <!--                <input type="password" class="form-control" placeholder="Password">-->
    <!--            </div>-->

    <!--            <div class="form-group flexbox py-10">-->
    <!--                <label class="custom-control custom-checkbox">-->
    <!--                    <input type="checkbox" class="custom-control-input" checked>-->
    <!--                    <span class="custom-control-indicator"></span>-->
    <!--                    <span class="custom-control-description">Remember me</span>-->
    <!--                </label>-->

    <!--                <a class="text-muted hover-primary fs-13" href="#">Forgot password?</a>-->
    <!--            </div>-->

    <!--            <div class="form-group">-->
    <!--                <button class="btn btn-bold btn-block btn-primary" type="submit">Login</button>-->
    <!--            </div>-->
    <!--        </form>-->

    <!--        <div class="divider">Or Sign In With</div>-->
    <!--        <div class="text-center">-->
    <!--            <a class="btn btn-circular btn-sm btn-facebook mr-4" href="#"><i class="fa fa-facebook"></i></a>-->
    <!--            <a class="btn btn-circular btn-sm btn-google mr-4" href="#"><i class="fa fa-google"></i></a>-->
    <!--            <a class="btn btn-circular btn-sm btn-twitter" href="#"><i class="fa fa-twitter"></i></a>-->
    <!--        </div>-->

    <!--        <hr class="w-30">-->

    <!--        <p class="text-center text-muted fs-13 mt-20">Don't have an account? <a href="page-register.html">Sign up</a></p>-->
    <!--    </div>-->

    <div class="modal fade" id="login-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 50px">
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="form.email" placeholder="Email" :class="{ 'is-invalid': errors.email}">
                            <div class="invalid-feedback" v-if="errors.email">
                                {{errors.email[0]}}
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" v-model="form.password" placeholder="Password">
                        </div>

                        <div class="form-group flexbox py-10">
                            <label class="custom-control custom-checkbox">
                                <input v-model="form.remember" type="checkbox" class="custom-control-input" checked>
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Remember me</span>
                            </label>

                            <a class="text-muted hover-primary fs-13" href="#">Forgot password?</a>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-bold btn-block btn-primary" @click.prevent="login" :disabled="isInvalidData" type="submit">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <p class="text-center text-muted fs-13 mt-20" style="width: 100%">Don't have an account? <a
                        href="page-register.html">Sign up</a></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    },
    data() {
        return {
            form:{
                email: '',
                password: '',
                remember: false,
            },
            loading: false,
            errors:[]
        }
    },
    computed: {
        isInvalidData() {
            return !this.validateEmail(this.form.email) || !this.form.password || this.loading
        }
    },
    methods: {
        login(){
            this.loading = true
          axios.post('/login', this.form)
            .then(res => {
                console.log(res)
                location.reload()
            })
            .catch(err => {
                this.loading = false
                if(err.response.status == 422){
                    this.errors = err.response.data.errors
                }
                else{
                    alert(err.response.statusText)
                }
            })
        },
        validateEmail(email) {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
    }
}
</script>
