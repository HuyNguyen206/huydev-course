<template>
<div>
    <div class="alert alert-noty" :class="alertClass" role="alert" v-if="notification">
        {{notification.message}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<!--    <div class=`alert alert-${notification.status} alert-noty` v-if="notification">-->
<!--        <p class="text-center">-->
<!--            {{notification.message}}-->
<!--        </p>-->

<!--    </div>-->
</div>
</template>

<script>
export default {
    name: "Noty",
    computed:{
      alertClass(){
          return `alert-${this.notification.status}`
        }
    },
    created() {
        Event.$on('notify', payload => {
           this.notification = payload
            setTimeout(()=> {
                this.notification = null
            }, 3000)
        })
    },
    data() {
        return {
            notification: {
                message: '',
                status:''
            }
        }
    }
}
</script>

<style scoped>
.alert-noty{
    position: fixed;
    top: 10px;
    right: 10px;
    z-index: 9999;
}
</style>
