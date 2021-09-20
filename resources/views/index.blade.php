@extends('layout')

@section('content')
@livewire('index', ['books' => $books])
@endsection
