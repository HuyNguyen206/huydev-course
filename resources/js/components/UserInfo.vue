<template>
    <div class="tab-pane fade" id="personal" aria-expanded="false">
        <form @submit.prevent="updateUser" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group"><input type="text"
                                           name="name" placeholder="Your name"
                                           class="form-control form-control-lg" :class="{ 'is-invalid':  this.errors.name }" v-model="user_name"></div>
            <div class="invalid-feedback" v-if="this.errors.name">
                {{this.errors.name[0]}}
            </div>
            <div class="form-group"><input type="text"
                                           name="email" placeholder="Your email"
                                           class="form-control form-control-lg" disabled :value="email"></div>

            <button type="submit" class="btn btn-lg btn-primary btn-block" :disabled="loading">
                <i v-if="loading" class="fas fa-spinner fa-spin"> </i>
                <span v-else>Save change</span>
                </button>
        </form>
    </div>
</template>

<script>
export default {
    name: "UserInfo",
    props: ['name', 'email'],
    data(){
        return {
            user_name: this.name,
            loading: false,
            errors: ''
        }
    },
    methods:{
        updateUser(){
            this.errors = []
            this.loading = true
            axios.post(`/update-user/${this.email}`, {name: this.user_name})
            .then(res => {
                this.loading = false
                Notification.notify(...[,,'Your info has been updated successfully'])
            })
            .catch(err => {
                if(err.response.data.errors){
                    this.errors = err.response.data.errors
                }
                else{
                    Notification.notify('error', 'Error', err.response.data.message)
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
