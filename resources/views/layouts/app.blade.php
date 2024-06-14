<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <div id="app" class="flex flex-grow h-screen">
        @if (!Request::route()->named('register') && !Request::route()->named('login'))
        <div class="w-1/5 bg-gray-200 p-4 flex flex-col justify-between h-full rounded-lg shadow-lg">
            <div>
                <h1 class="text-lg font-bold mb-4">Options</h1>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('manage.account') }}" class="{{ Request::route()->named('manage.account') ? 'bg-gray-300 font-bold' : '' }} block px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">
                            Account Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('view.tables') }}" class="{{ Request::route()->named('view.tables') ? 'bg-gray-300 font-bold' : '' }} block px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">
                            View Uploaded Tables
                        </a>
                    </li>
                    @if (Request::route()->named('table.data') || Request::route()->named('manage.account') || Request::route()->named('view.tables'))
                        <li>
                            <a href="{{ route('dashboard') }}" class="{{ Request::route()->named('dashboard') ? 'bg-gray-300 font-bold' : '' }} block px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">
                                Dashboard
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="mt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md w-full transition duration-300">
                        Logout
                    </button>
                </form>
            </div>
        </div>
        @endif
        
        <!-- Main Content -->
        <div class="w-full flex justify-center items-center p-4">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    @yield('scripts')
</body>
</html>