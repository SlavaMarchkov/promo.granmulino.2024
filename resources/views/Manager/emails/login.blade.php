@component('mail::message')
# Вход для менеджера

### Пользователь, имеющий права менеджера, только что выполнил вход в систему {{ config('app.name') }}:
- ФИО: {{ $userName }}
- Email: {{ $userEmail }}

@component('mail::button', ['url' => config('app.url')])
Вход в систему
@endcomponent

Приятной работы,<br>
{{ config('app.name') }}
@endcomponent
