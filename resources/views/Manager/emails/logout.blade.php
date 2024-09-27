@component('mail::message')
# Выход менеджера

### Пользователь, имеющий права менеджера, только что вышел из системы {{ config('app.name') }}:
- ФИО: {{ $userName }}
- Email: {{ $userEmail }}

Приятной работы,<br>
{{ config('app.name') }}
@endcomponent
