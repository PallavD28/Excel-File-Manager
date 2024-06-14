@extends('layouts.app')

@section('content')
<div class="flex w-full">
    <div class="w-full p-4 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Table Data: {{ $tableName }}</h1>

        @if($tableData->isEmpty())
            <p class="text-gray-600">No data available for this table.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            @foreach($columns as $column)
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $column }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($tableData as $row)
                            <tr>
                                @foreach($columns as $column)
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->$column }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
