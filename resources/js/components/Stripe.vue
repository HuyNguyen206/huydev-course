<template>
    <form @submit.prevent="postSubscribe" action="" method="POST" id="subscribe-form">
        <div class="alert alert-danger" v-if="this.error">
            {{error}}
        </div>
        <div class="form-group">
            <label for="" class="font-weight-bold">Pricing plan</label>
            <div class="row">
                <div v-for="(plan, index) in plans" :key="index" class="col-md-4">
                    <div class="subscription-option">
                        <label :for="planLabel(plan.id)">
                            <span
                                class="plan-price">{{ plan.amount / 100 + " " + plan.currency }} <small> / {{ plan.interval_count+' '+plan.interval }}</small></span>
                            <span class="plan-name">{{ plan.name }}</span>
                        </label>
                        <input type="radio" v-model="plan_name" :id="planLabel(plan.id)" name="plan" :value="plan.id">
                    </div>
                </div>
            </div>
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
            <button type="submit" id="card-button" :data-secret="intent.client_secret"
                    class="btn btn-lg btn-primary btn-block" :disabled="loading" style="font-size: 18px">
                <i v-if="loading" class="fas fa-spinner fa-spin"> </i>
                <span v-else>Submit</span>
            </button>
        </div>
    </form>
</template>

<script>
export default {
    name: "Stripe",
    props:['plans_json', 'stripe_key', 'user', 'intent_json'],
    data() {
        return {
            plans: JSON.parse(this.plans_json),
            intent: JSON.parse(this.intent_json),
            card: {},
            plan_name:'',
            error:'',
            stripe: {},
            loading: false
        }
    },
    methods:{
        planLabel(id){
            return `plan-silver-${id}`
        },
        async postSubscribe(){
                this.error = ''
                this.loading = true
                const cardHolderName = document.getElementById('card-holder-name');
                const cardButton = document.getElementById('card-button');
                const clientSecret = cardButton.dataset.secret;
                console.log("attempting");
                const {setupIntent, error} = await this.stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: this.card,
                            billing_details: {name: cardHolderName.value}
                        }
                    }
                );
                if (error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;
                    this.loading = false

                } else {
                    console.log('setupIntent' + setupIntent)
                    this.paymentMethodHandler(setupIntent.payment_method);
                }

        },
        paymentMethodHandler(payment_method) {
            axios.post(`/post-subscribe`,{
                'payment_method':payment_method,
                'plan' : this.plan_name
            })
            .then((res) => {
                window.location = res.data.data
                alert('You have subscribe successfully')
            })
            .catch(err => {
                this.error = err.response.data.message
            })
            .then(res => {
                this.loading = false
            })
        }
    },
    mounted() {
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
