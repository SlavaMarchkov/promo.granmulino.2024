@component('mail::message')
# Вход для менеджера

### Пользователь, имеющий права менеджера, только что выполнил вход в систему {{ config('app.name') }}:
- ФИО: {{ $userName }}
- Email: {{ $userEmail }}

Приятной работы,<br>
{{ config('app.name') }}
@endcomponent
