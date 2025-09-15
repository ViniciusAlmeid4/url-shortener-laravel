<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/register/register.js'])
</head>

<body
    class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">

    <!-- Header -->
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
        <nav class="flex items-center justify-end gap-4">
            <a href="{{ route('login') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                Login
            </a>
        </nav>
    </header>

    <!-- Main Content -->
    <main
        class="flex w-full flex-col max-w-[335px] lg:max-w-4xl lg:flex-row transition-opacity opacity-100 duration-750 starting:opacity-0">

        <!-- Left: Welcome Message -->
        <section
            class="flex-1 p-6 pb-12 lg:p-20 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] rounded-t-lg lg:rounded-bl-lg lg:rounded-tr-none shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
            <h1 class="mb-1 font-medium">It's great having you here</h1>
            <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
                You're one step away from shortening and sharing your URLs.
            </p>
            <img src="{{ asset('images/logoUrl.png') }}" class="w-full h-auto mt-8" alt="Preview" />
        </section>

        <!-- Right: Registration Form -->
        <section
            class="flex-1 p-6 pb-12 lg:p-20 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] rounded-b-lg lg:rounded-bl-none lg:rounded-r shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
            <form action="{{ route('postRegister') }}" method="POST" class="w-full h-fit m-auto">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-white">Email</label>
                    <input id="email" type="text" name="email" placeholder="testing@gmail.com"
                        class="mt-2 w-full bg-transparent rounded-md py-1.5 px-3 text-base text-white placeholder:text-gray-500 focus:outline-none border border-gray-300 dark:border-gray-600" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-white">Password</label>
                    <input id="password" type="password" name="password" placeholder="••••••••••••••••"
                        class="mt-2 w-full bg-transparent rounded-md py-1.5 px-3 text-base text-white placeholder:text-gray-500 focus:outline-none border border-gray-300 dark:border-gray-600" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="confirmPassword" class="block text-sm font-medium text-white">Confirm Password</label>
                    <input id="confirmPassword" type="password" name="confirmPassword" placeholder="••••••••••••••••"
                        class="mt-2 w-full bg-transparent rounded-md py-1.5 px-3 text-base text-white placeholder:text-gray-500 focus:outline-none border border-gray-300 dark:border-gray-600" />
                </div>

                <!-- Submit -->
                <button id="btnRegister" type="submit"
                    class="w-full px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                    Register
                </button>
            </form>
        </section>
    </main>
</body>

</html>
