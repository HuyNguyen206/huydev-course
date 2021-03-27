export default {
    name: "errorHandler",
    data(){
        return {
            errors:[]
        }
    },
    methods:{
        handerError(err){
            if (err.response.status == 422) {
                this.errors = err.response.data.errors
            } else if(err.response.message) {
                noty({message: err.response.message, status:'danger'})
            }else{
                noty({message: err.response.statusText, status:'danger'})
            }
        }
    }
}

