@extends('layouts.app')

@section('content')
<div class="w-full h-full p-4">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Welcome, {{ Auth::user()->name }}</h1>
    </div>
    
    <!-- Account Management Form -->
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('account.update') }}" method="POST">
            @csrf
            @method('PUT') <!-- Use PUT method for update -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name
                </label>
                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
                <p class="text-gray-600 text-xs italic">Email cannot be changed.</p>
            </div>
            <div class="mb-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection