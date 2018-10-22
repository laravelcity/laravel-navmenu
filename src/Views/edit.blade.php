@extends('NavMenu::layout')
@section('content')
        <form method="post" action="{{route('nav.update',['id'=>$nav->nav_id])}}" >
            {{method_field('PUT')}}
            @include('NavMenu::form')
        <form>
@endsection
