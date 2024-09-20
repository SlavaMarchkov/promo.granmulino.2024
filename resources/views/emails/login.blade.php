@component('mail::message')
# Логин менеджера

### Этот Пользователь только что выполнил вход в систему {{ config('app.name') }}:
- ФИО: {{ $userName }}
- Email: {{ $userEmail }}

@component('mail::button', ['url' => config('app.url')])
Вход в систему
@endcomponent

Приятной работы,<br>
{{ config('app.name') }}
@endcomponent
