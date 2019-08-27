@extends('layouts.mobile')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

    @include('mobile.includes.topbar', [
        'class'       => '_fixed',
        'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>' . $seo['title'] . '</a>',
        'search_show' => false,
        'menu_link'   => '',
        'menu_class'  => 'icon_menu'
    ])
    @include('mobile.includes.space', ['style' => 'height: 3.073vw;'])

    @php
        $address = config('shop.address');
        $number_phones = config('shop.number_phones');
    @endphp

    <div class="container">
        <p>
            Обсудить с нами возникшие вопросы или проконсультироваться звоните к нам по номеру:
            <a style="font-size: 14px;text-decoration: none;" href="tel:{{ $number_phones[0]['number'] }}">
                {{ $number_phones[0]['format'] }}
            </a>
            ({{ $address[0]['working_hours'] }}).
            Кроме того, Вы можете отправить любые запросы или вопросы нам на электронную почту

            <a style="font-size: 14px;text-decoration: none;" href="mailto:{{ config('shop.site_email') }}">
                {{ config('shop.site_email') }}
            </a> ,

            не забудьте указать Ваше имя и контактные номера телефонов. Если Вас не устраивают какие-либо наши товары или услуги,
            мы с удовольствием выслушаем Вас. Мы всегда готовы решить проблему.
        </p>
        <p>
            <ul>
                <li>
                    <b>Телефоны:</b>
                    <br/>
                    Ежедневно, круглосуточно(телефон или WhatsApp)
                    <br/>
                    <a href="tel: {{ $number_phones[0]['number'] }}"> {{ $number_phones[0]['format'] }}</a>
                </li>
                <li>
                    <b>Время работы:</b>
                    <br/>
                    {{ $address[0]['working_hours'] }}
                </li>
                <li>
                    <b>Адрес:</b>
                    <br/>
                    {{ $address[0]['addressLocality'] }}, {{ $address[0]['streetAddress'] }}
                </li>
                <li>
                    <b>E-mail:</b>
                    <br/>
                    Вопросы по розничным продажам и.д.
                    <br/>
                    <a href="mailto:{{ config('shop.site_email') }}">{{ config('shop.site_email') }}</a>
                </li>

            </ul>
        </p>
        <p>
            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A809d57a2d5e1595921eb0d4243f8faaa2748651e7ca204d04724d363036ff2ab&amp;source=constructor" width="100%" height="300" style="margin: 0;" frameborder="0"></iframe>
        </p>
    </div>

    @include('mobile.includes.footer')

@endsection