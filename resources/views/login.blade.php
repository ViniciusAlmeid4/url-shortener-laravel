<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/login/login.js'])
</head>

<body
    class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
        <nav class="flex items-center justify-end gap-4">
                <a href="{{ route('register') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    Register
                </a>
        </nav>
    </header>
    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 starting:opacity-0">
        <main class="flex w-full flex-col max-w-[335px] lg:max-w-4xl lg:flex-row">

            <!-- Left content -->
            <div
                class="flex-1 p-6 pb-12 lg:p-20 text-[16px] leading-[20px] 
                            bg-white dark:bg-[#161615] dark:text-[#EDEDEC] 
                            shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] 
                            dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] 
                            rounded-t-lg lg:rounded-bl-lg lg:rounded-tr-none">

                <h1 class="mb-1 font-medium">Let's shorten some URLs</h1>
                <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
                    Here you can send your URLs encrypted and with passwords, so that they aren't exposed for everyone.
                </p>
                <div class="h-full flex">
                    <form action="{{ route('postLogin') }}" method="POST" class="w-full h-fit mt-12 m-auto">
                        <div class="sm:col-span-4">
                            <label for="email" class="block text-sm/6 font-medium text-[#706f6c] dark:text-[#A1A09A]">Email</label>
                            <div class="mt-2">
                                <div
                                    class="flex items-center rounded-md bg-white/5 outline-1 -outline-offset-1 outline-black/10 dark:outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                                    <input id="email" type="text" name="email" placeholder="testing@gmail.com"
                                        class="block w-[100px] grow bg-transparent rounded-md py-1.5 px-3 text-base text-[#706f6c] dark:text-[#A1A09A]e placeholder:text-gray-500 focus:outline-none sm:text-sm/6" />
                                </div>
                            </div>  
                        </div>
                        <div class="sm:col-span-4 mt-4">
                            <label for="password" class="block text-sm/6 font-medium text-[#706f6c] dark:text-[#A1A09A]">Password</label>
                            <div class="mt-2">
                                <div
                                    class="flex items-center rounded-md bg-white/5 outline-1 -outline-offset-1 outline-black/10 dark:outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                                    <input id="password" type="password" name="password" placeholder="--------------------"
                                        class="block w-[100px] grow bg-transparent rounded-md py-1.5 px-3 text-base text-[#706f6c] dark:text-[#A1A09A] placeholder:text-gray-500 focus:outline-none sm:text-sm/6" />
                                </div>
                            </div>
                        </div>
                        <div class="sm:col-span-4 mt-6">
                            <button
                                id="btnLogin"
                                class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right image block -->
            <div
                class="bg-[#fff2f2] dark:bg-[#1D0002] relative 
                            lg:-ml-px -mb-px lg:mb-0 
                            rounded-b-lg lg:rounded-bl-none lg:rounded-r 
                            w-full lg:w-[338px] shrink-0 overflow-hidden">

                <img src="{{ asset('images/imgUrl.png') }}" class="w-full h-auto" alt="Preview" />
            </div>
        </main>
    </div>
</body>

</html>
