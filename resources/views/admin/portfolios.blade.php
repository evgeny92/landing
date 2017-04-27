{{--Будет наледовать глобальный макет--}}
@extends('layouts.admin')

@section('header')
    @include('admin.header')
@endsection

@section('content')
    @include('admin.content_portfolios')
@endsection