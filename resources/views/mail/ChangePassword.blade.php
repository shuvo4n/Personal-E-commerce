@component('mail::message')
# Change Password Confirmation - {{ $user_name_for_mail }}

@component('mail::panel')
Your passsword has been changed!
@endcomponent

@component('mail::button', ['url' => 'Shuvo'])
TEST BUTTON
@endcomponent

@component('mail::table')
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
