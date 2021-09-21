@extends('layout')
@section('title', "Edit ". $book->name)

@section('content')
<h1 class="my-10 text-3xl text-center">Edit {{ $book->name }}</h1>
@livewire('update', ['book' => $book])
@endsection
