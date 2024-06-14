@extends('layouts.app')

@section('content')
<div class="flex w-full h-full">
    <!-- Main Content -->
    <div class="w-full p-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Welcome, {{ Auth::user()->name }}</h1>
        </div>
        
        <!-- Uploaded Tables Section -->
        <div>
            <h2 class="text-lg font-bold mb-4">Uploaded Tables</h2>
            
            @if ($tables->isEmpty())
                <p>No uploaded tables found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2">Table Name</th>
                                <th class="py-2 text-right">Date Uploaded</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($tables as $table)
                                <tr>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('table.data', ['tableName' => $table->table_name]) }}" class="text-blue-500 hover:text-blue-700 transition duration-300 ease-in-out no-underline">
                                            {{ $table->table_name }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-4 text-gray-500 text-right">
                                        {{ $table->created_at->format('Y-m-d') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
