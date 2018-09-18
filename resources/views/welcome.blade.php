@extends('layouts.app')

@section('content')
    {{--{{dd($posts)}}--}}
    <welcome-component :posts="{{$posts}}">
    </welcome-component>
@endsection