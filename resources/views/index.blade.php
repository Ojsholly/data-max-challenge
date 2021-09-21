@extends('layout')

@section('title', 'Index')

@section('content')
@livewire('index', ['books' => $books])
@endsection
