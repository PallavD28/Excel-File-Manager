@extends('layouts.app')

@section('content')
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-1/4 bg-gray-200 p-4">
            <ul>
                <li><a href="{{ route('manage.account') }}">Account Management</a></li>
                <li><a href="#">View Uploaded Tables</a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="w-3/4 p-4">
            <!-- File Upload Form -->
            <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".xlsx, .xls">
                <button type="submit">Upload File</button>
            </form>
            
            <!-- Display User's Uploaded Files -->
            <h2>Uploaded Files</h2>
            <ul>
                @foreach ($user->fileUploads as $file)
                    <li>{{ $file->file_name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
