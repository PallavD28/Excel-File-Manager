@extends('layouts.app')

@section('content')
<div class="w-full max-w-md bg-white shadow-md rounded-lg p-8 mx-4">
    <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                Email Address
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" name="email" placeholder="Email Address" required>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password" placeholder="******************" required>
        </div>
        @if ($errors->any())
            <div class="mb-4">
                <div class="font-medium text-red-600">{{ $errors->first() }}</div>
            </div>
        @endif
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Sign In
            </button>
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('register') }}">
                Register
            </a>
        </div>
    </form>
</div>
@endsection
