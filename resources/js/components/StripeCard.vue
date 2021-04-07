<template>
   <div>
       <div v-if="card_brand && card_last_four">
           <h2>
               Your current card: <span class="badge badge-info"> {{ card_brand_update + ':' + card_last_four_update }}</span>
               </h2>
           <form @submit.prevent="updatePaymentMethod" action="" method="POST" id="subscribe-form">
               <div class="alert alert-danger" v-if="this.error">
                   {{ error }}
               </div>
               <div class="form-group">
                   <label for="card-holder-name" class="font-weight-bold">Card Holder Name</label>
                   <input class="form-control" id="card-holder-name" type="text">
               </div>

               <div class="form-row">
                   <div class="form-group">
                       <label for="card-element" class="font-weight-bold">Credit or debit card</label>
                       <div id="card-element" class="form-control">
                       </div>
                       <!-- Used to display form errors. -->
                       <div id="card-errors" role="alert"></div>
                   </div>
               </div>
               <div class="stripe-errors"></div>
               <div class="form-group text-center">
                   <button type="submit" id="card-button"
                           class="btn btn-lg btn-primary btn-block" :disabled="loading" >
                       <i v-if="loading" class="fas fa-spinner fa-spin"> </i>
                       <span v-else>Update card</span>
                   </button>
               </div>
           </form>
       </div>
       <div v-else>
           <h2>
               You haven't subscribe yet
           </h2>
       </div>
   </div>
</template>

<script>
export default {
    props: ['card_brand', 'card_last_four', 'stripe_key'],
    name: "StripeCard",
    data() {
        return {
            card: {},
            error:'',
            stripe: {},
            loading: false,
            card_brand_update:this.card_brand,
            card_last_four_update:this.card_last_four
        }
    },
    methods:{
        async updatePaymentMethod(){
            this.error = ''
            this.loading = true
            const cardHolderName = document.getElementById('card-holder-name');
            console.log("attempting");
            const {paymentMethod, error} = await this.stripe.createPaymentMethod(
                'card', this.card, {
                        billing_details: {name: cardHolderName.value}
                }
            );
            if (error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
                this.loading = false

            } else {
                this.paymentMethodHandler(paymentMethod.id);
            }

        },
        paymentMethodHandler(payment_method) {
            axios.post(`/update-payment-method`,{
                payment_method
            })
                .then((res) => {
                    let timerInterval
                    Notification.notify(...[,,'You have update payment method successfully'])
                    this.card_brand_update = res.data.data.card_brand
                    this.card_last_four_update = res.data.data.card_last_four

                })
                .catch(err => {
                    if(err.response.data.errors){
                        this.error = err.response.data.errors.plan[0]
                    }
                    else{
                        this.error = err.response.data.message
                    }

                })
                .then(res => {
                    this.loading = false
                })
        }
    },
    mounted() {
        if(this.card_brand && this.card_last_four){
            this.stripe = Stripe(this.stripe_key);
            var elements =  this.stripe.elements();
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };
            this.card = elements.create('card', {
                hidePostalCode: true,
                style: style
            });
            this.card.mount('#card-element');
            this.card.addEventListener('change', function (event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
        }
    }
}
</script>

<style scoped>
.StripeElement {
    background-color: white;
    padding: 8px 12px;
    border-radius: 4px;
    border: 1px solid transparent;
    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
}

.StripeElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
    border-color: #fa755a;
}

.StripeElement--webkit-autofill {
    background-color: #fefde5 !important;
}

.subscription-option {
    display: flex;
    align-items: center;
    justify-content: flex-start;
}

.subscription-option label {
    margin-right: 10px;
    margin-bottom: 0;
}

.plan-price, .plan-name, label {
    font-size: 18px;
}
</style>
