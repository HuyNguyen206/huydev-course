<template>
    <div>
        <div class="alert alert-danger" v-if="this.error">
            {{ error }}
        </div>
        <div v-if="current_plan">
            <h2>Your current plan: <label for="" class="badge badge-success"> {{ current_plan.product.name }}</label>
            </h2>
            <div v-for="(plan, index) in plans" :key="index">
                <div class="subscription-option">
                    <label :for="planLabel(plan.id)">
                        <span class="plan-name">{{ plan.product.name }}</span>
                        <span
                            class="plan-price">{{
                                plan.amount / 100 + " " + plan.currency
                            }} <small> / {{ plan.interval_count + ' ' + plan.interval }}</small></span>

                    </label>
                    <input type="radio" v-model="plan_id" :id="planLabel(plan.id)" name="plan" :value="plan.id">
                </div>
            </div>
        </div>
        <div v-else>
            <h2>You haven't subscribe yet</h2>
        </div>

        <button v-if="current_plan" style="margin-top: 30px" :disabled="loading" class="btn btn-primary"
                @click="updatePlan">
            <i v-if="loading" class="fas fa-spinner fa-spin"> </i>
            <span v-else> Update Plan</span>
        </button>
    </div>
</template>

<script>
export default {
    props: ['current_plan_json', 'plans_json'],
    data() {
        return {
            current_plan: JSON.parse(this.current_plan_json),
            plans: JSON.parse(this.plans_json),
            plan_id: JSON.parse(this.current_plan_json) ? JSON.parse(this.current_plan_json).id : null,
            loading: false,
            error: ''
        }
    },
    methods: {
        planLabel(id) {
            return `plan-silver-${id}`
        },
        updatePlan() {
            this.loading = true
            axios.post(`/update-plan`, {
                plan: this.plan_id
            })
                .then(res => {
                    Notification.notify(...[, , 'You have update plan successfully'])
                })
                .catch(err => {
                    this.error = err.response.data.message
                })
                .then(() => {
                    this.loading = false
                })
        }
    },
    name: "StripeSubscription"
}
</script>

<style scoped>
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
