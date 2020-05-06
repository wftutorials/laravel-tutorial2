@extends('layouts.main')

@section('title',"My Users")

@section('content')
<h1>{{ $title  }}</h1>
@if($show == true)
    <p>The title is passed from the controller</p>
    <ul>
        @for ($i = 0; $i < 10; $i++)
            <li>The current value is item: {{ $i }} </li>
        @endfor
    </ul>
@endif
@endsection
