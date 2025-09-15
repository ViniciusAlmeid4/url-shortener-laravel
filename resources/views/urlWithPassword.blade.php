<!-- resources/views/shorturl/password.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enter Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center justify-center min-h-screen flex-col">

    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6">
        <nav class="flex items-center justify-between gap-4">
            <div class="text-base font-medium dark:text-[#EDEDEC]">
                {{ Auth::user()->email ?? 'Guest' }}
            </div>
        </nav>
    </header>

    <div class="flex items-center justify-center w-full">
        <main class="flex flex-col max-w-[335px] lg:max-w-4xl w-full p-6 bg-white dark:bg-[#161615] rounded-lg shadow-md">

            <h1 class="text-[#706f6c] dark:text-[#A1A09A] text-lg font-medium mb-4">Enter Link's Password</h1>
            <p class="text-[#706f6c] dark:text-[#A1A09A] mb-6">
                Please enter the password to access the URL: <span class="font-semibold">{{ $url->shortened }}</span>
            </p>

            <form action="{{ route('checkWithPassword', ['code' => $url->code]) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-[#EDEDEC]">Password</label>
                    <input type="password" name="password" id="password"
                        class="mt-2 block w-full rounded-md bg-white/5 dark:bg-[#1D1D1D] border border-gray-300 dark:border-gray-600 px-3 py-2 text-base text-gray-900 dark:text-[#EDEDEC] focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>

                @error('password')
                    <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                @enderror

                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                    Submit
                </button>
            </form>

        </main>
    </div>

</body>
</html>
