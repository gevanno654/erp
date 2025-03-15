@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">Create Account</h2>

    @if(session('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('employees.store-account') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium">Full Name:</label>
            <input type="text" name="name" class="w-full p-2 border rounded-md">
        </div>

        <div>
            <label class="block font-medium">Email:</label>
            <input type="email" name="email" class="w-full p-2 border rounded-md">
        </div>

        <div>
            <label class="block font-medium">Password:</label>
            <input type="password" name="password" class="w-full p-2 border rounded-md">
        </div>

        <div>
            <label class="block font-medium">Confirm Password:</label>
            <input type="password" name="password_confirmation" class="w-full p-2 border rounded-md">
        </div>

        <div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Create Account</button>
        </div>
    </form>
</div>
@endsection
