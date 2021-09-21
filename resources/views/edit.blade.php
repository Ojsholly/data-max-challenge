@extends('layout')
@section('title', "Edit ". $book->data->name)

@section('content')
<h1 class="my-10 text-3xl text-center">Edit {{ $book->data->name }}</h1>
@livewire('update', ['book' => $book])
@endsection
