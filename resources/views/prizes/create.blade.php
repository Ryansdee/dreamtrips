@extends('layouts.app')

@section('content')
    <h1>Add Prize</h1>
    <form action="{{ route('prizes.store', $contest->id) }}" method="POST">
        @csrf
        <label for="name">Prize Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" required>
        <button type="submit">Add Prize</button>
    </form>
@endsection
