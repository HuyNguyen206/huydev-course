@component('mail::message')
# One more step before joining HuyDev-Course

The body of your message.

@component('mail::button', ['url' => route('confirm-register').'?token='.$user->confirm_token])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
