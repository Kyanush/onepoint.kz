@php
    $address = config('shop.address');
    $number_phones = config('shop.number_phones');
@endphp

<div class="footer">
    <div class="footer__contacts">
        <div class="footer__contacts-call">
            <span class="icon icon_phone"></span>
            <a class="footer__contacts-number" href="tel:{{ $number_phones[0]['number'] }}">
                {{ $number_phones[0]['format'] }}
            </a>
        </div>
        <div class="footer__contacts-text">
            <b>Адрес:</b>
            {{ $address[0]['addressLocality'] }}, {{ $address[0]['streetAddress'] }}
        </div>
        <div class="footer__contacts-text">
            <b>Время работы:</b>
            {{ $address[0]['working_hours'] }}
        </div>
        <div class="footer__contacts-text">
            <b>E-mail:</b>
            <a href="mailto:{{ config('shop.site_email') }}">{{ config('shop.site_email') }}</a>
        </div>
    </div>
    <div class="footer__links">
        <a class="footer__link" href="/login">Вход в кабинет</a>
    </div>
    <div class="footer__copyright">
        <a class="footer__copyright-link" href="/register">
            Регистрация
        </a>
        <br/>
        <br/>
        © {{ env('APP_NAME') }}, 2018-{{ date('Y') }}
    </div>
</div>