@extends('layouts.main-app')
@section('header')
    <header class="header header-inverse" style="background-color: #3498db;">
        <div class="container text-center">

            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2">

                    <h1>{{$user->name}}</h1>
                    <h1>{{$user->getTotalNumberOfCompletedLesson()}} </h1>
                    <p class="fs-20 opacity-70">Lesson completed</p>
                </div>
            </div>

        </div>
    </header>
@endsection
@section('content')
    <section class="section">
        <div class="container">
            <div class="row gap-y">
                <div class="col-12">
                    <form action="{{route('post-subscribe')}}" method="POST" id="subscribe-form">
                        @csrf
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Pricing plan</label>
                            <div class="row" >
                                @foreach($plans as $plan)
                                    <div class="col-md-4">
                                        <div class="subscription-option">
                                            <label for="plan-silver-{{$plan->id}}}">
                                                <span class="plan-price">{{$plan->amount/100}} {{\Illuminate\Support\Str::upper($plan->currency)}}<small> /{{$plan->interval}}</small></span>
                                                <span class="plan-name">{{$plan->product->name}}</span>
                                            </label>
                                            <input type="radio"  id="plan-silver-{{$plan->id}}}" name="plan" value='{{$plan->id}}'>
                                        </div>
                                    </div>
                                @endforeach
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
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group text-center">
                            <button type="submit" id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-lg btn-primary btn-block">SUBMIT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('css')
    <style>
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

        .plan-price, .plan-name, label{
            font-size: 14px;
        }
    </style>
@endsection

@section('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(function(){
            var stripe = Stripe('{{ config('services.stripe.key') }}');
            var elements = stripe.elements();
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
            var card = elements.create('card', {hidePostalCode: true,
                style: style});
            card.mount('#card-element');
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
            var form = document.getElementById('subscribe-form')
            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;
            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                console.log("attempting");
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: card,
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                );
                if (error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;
                } else {
                    console.log('setupIntent'+ setupIntent)
                    paymentMethodHandler(setupIntent.payment_method);
                }
            });
            function paymentMethodHandler(payment_method) {
                var form = document.getElementById('subscribe-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method');
                hiddenInput.setAttribute('value', payment_method);
                form.appendChild(hiddenInput);
                form.submit();
            }
        })

    </script>
@endsection
