@extends('layouts.mail')
@section('content')

    <p>Ваш вопрос: {{ $data->question }}</p>
    <p>Ответ администратора: {{ $data->answer }}</p>
    <p>Товар: <a href="{{ env('APP_URL') . $data->product->detailUrlProduct() }}">{{ $data->product->name }}</a></p>

@endsection