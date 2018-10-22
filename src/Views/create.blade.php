@extends('NavMenu::layout')
@section('content')
    <form method="post" action="{{route('nav.store')}}" >
        @include('NavMenu::form')
    <form>
@endsection
