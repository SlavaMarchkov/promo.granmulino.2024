@component('mail::message')
# Новая промо-акция

### Пользователь создал промо-акцию:
{{ $promo }}

@component('mail::button', ['url' => ''])
    Посмотреть
@endcomponent

Приятной работы,<br>
{{ config('app.name') }}
@endcomponent
