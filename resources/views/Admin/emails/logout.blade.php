@component('mail::message')
# Выход администратора

### Пользователь, имеющий права администратора, только что вышел из системы {{ config('app.name') }}:
- ФИО: {{ $name }}
- Email: {{ $email }}

Приятной работы,<br>
{{ config('app.name') }}
@endcomponent
