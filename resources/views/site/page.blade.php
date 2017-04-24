{{-- Дочерний макет, т.е. мы должны наследовать функционал  родительского макета    --}}
@extends('layouts.site')

@section('header')
    {{-- Подключаем определённый файл шаблона  --}}
    @include('site.header')
@endsection

@section('content')
    {{-- Подключаем определённый файл шаблона  --}}
    @include('site.content_page')
@endsection