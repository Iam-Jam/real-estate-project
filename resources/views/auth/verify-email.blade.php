@component('mail::message')
# Verify Your Email Address

Thank you for registering with our site. Please click the button below to verify your email address:

@component('mail::button', ['url' => route('verification.verify', $registration->verification_token)])
Verify Email Address
@endcomponent

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
