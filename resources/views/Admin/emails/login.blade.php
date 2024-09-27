@component('mail::message')
# Вход для администратора

### Пользователь, имеющий права администратора, только что выполнил вход в систему {{ config('app.name') }}:
- ФИО: {{ $name }}
- Email: {{ $email }}

Приятной работы,<br>
{{ config('app.name') }}
@endcomponent
