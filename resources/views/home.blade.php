<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>My URLs</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind / your app -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/home/home.js', 'resources/css/home/home.css'])

    <!-- Simple-DataTables (lightweight: search/sort/pagination) -->
    <link rel="stylesheet" href="https://unpkg.com/simple-datatables@9.0.3/dist/style.css" />
    <script defer src="https://unpkg.com/simple-datatables@9.0.3"></script>
</head>

<body class="bg-[#f0f7fa] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen">
    <!-- Header -->
    <header class="w-full">
        <div class="mx-auto max-w-6xl px-6 py-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logoUrl.png') }}" alt="Mascot"
                    class="h-9 w-9 rounded-xl shadow-sm dark:shadow-none" />
                <div class="text-base lg:text-lg font-medium dark:text-[#EDEDEC]">
                    {{ Auth::user()->email ?? 'Guest' }}
                </div>
            </div>
            <nav class="flex items-center gap-3">
                <a href="{{ route('home') }}"
                    class="bg-white dark:bg-transparent hidden sm:inline-block px-4 py-2 text-sm rounded-md border dark:text-[#EDEDEC] border-[#19140035] dark:border-[#3E3E3A] hover:border-[#1915014a] dark:hover:border-[#62605b]">
                    My URLs
                </a>
                <!-- Example placeholder for actions (e.g., New URL modal trigger) -->
                <a href="{{ route('logout') }}"
                    class="bg-white dark:bg-transparent px-4 py-2 text-sm rounded-md border dark:text-[#EDEDEC] border-[#19140035] dark:border-[#3E3E3A] hover:border-[#1915014a] dark:hover:border-[#62605b]">
                    Logout
                </a>
            </nav>
        </div>
    </header>

    <!-- Main -->
    <main class="mx-auto max-w-6xl px-6 pb-16">
        <section
            class="relative overflow-hidden
                 rounded-2xl shadow-[inset_0_0_0_1px_rgba(26,26,0,0.16)]
                 dark:shadow-[inset_0_0_0_1px_#fffaed2d]
                 bg-white dark:bg-[#161615] dark:text-[#EDEDEC]">

            <!-- Top bar inside the card -->
            <div
                class="flex items-center justify-between gap-4 p-6 lg:p-8 border-b border-[#ecebe7] dark:border-[#2a2a28]">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-semibold tracking-tight">Your Shortened URLs</h1>
                    <p class="text-sm lg:text-base mt-1 text-[#706f6c] dark:text-[#A1A09A]">
                        Search, sort, and manage your links. Click a short URL to open it, or copy it to share.
                    </p>
                </div>
                <img src="{{ asset('images/imgUrl.png') }}" alt="Illustration"
                    class="hidden md:block h-16 lg:h-20 opacity-90" />
            </div>

            <!-- Add new URL part -->
            <div
                class="flex justify-center items-center gap-4 p-6 lg:p-8 border-b border-[#ecebe7] dark:border-[#2a2a28]">
                <!-- URL input -->
                <div class="w-full">
                    <label for="urlInput"
                        class="block text-sm/6 font-medium text-[#706f6c] dark:text-[#A1A09A]">URL</label>
                    <div class="mt-2 w-full">
                        <div
                            class="flex items-center rounded-md bg-white/5 outline-1 -outline-offset-1 outline-black/10 dark:outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                            <input id="urlInput" type="text" name="url" placeholder="https://example.com"
                                class="block w-full grow bg-transparent rounded-md py-1.5 px-3 text-base text-[#706f6c] dark:text-[#A1A09A] placeholder:text-gray-500 focus:outline-none sm:text-sm/6" />
                        </div>
                    </div>
                </div>

                <!-- Password input -->
                <div class="w-full">
                    <label for="passwordInput"
                        class="block text-sm/6 font-medium text-[#706f6c] dark:text-[#A1A09A]">Password</label>
                    <div class="mt-2">
                        <div
                            class="flex items-center rounded-md bg-white/5 outline-1 -outline-offset-1 outline-black/10 dark:outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                            <input id="passwordInput" type="password" name="password" placeholder="Enter password"
                                class="block w-full grow bg-transparent rounded-md py-1.5 px-3 text-base text-[#706f6c] dark:text-[#A1A09A] placeholder:text-gray-500 focus:outline-none sm:text-sm/6" />
                        </div>
                    </div>
                </div>

                <!-- Add button -->
                <button id="addNewUrl" type="button"
                    class="self-end px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                    Add
                </button>
            </div>

            <!-- Table wrapper -->
            <div class="p-4 lg:p-8">
                <div class="overflow-x-auto">
                    <table id="urlsTable" class="w-full text-left">
                        <thead>
                            <tr class="text-sm border-b border-[#ecebe7] dark:border-[#2a2a28]">
                                <th class="py-2 px-3">Short</th>
                                <th class="py-2 px-3">Original URL</th>
                                <th class="py-2 px-3">Clicks</th>
                                <th class="py-2 px-3">Created</th>
                                <th class="py-2 px-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-[15px]">
                            @foreach ($urls as $url)
                                @php
                                    $short = $url->shortened; // accessor
                                    $copyId = 'copy-' . $url->id;
                                @endphp
                                <tr class="">
                                    <td class="">
                                        <a href="{{ $short }}" target="_blank"
                                            class="underline underline-offset-2 decoration-dotted">
                                            {{ $short }}
                                        </a>
                                    </td>
                                    <td class="">
                                        <div class="truncate" title="{{ $url->original }}">{{ $url->original }}</div>
                                    </td>
                                    <td class="">{{ $url->clicks }}</td>
                                    <td class="">
                                        {{ $url->created_at->locale(app()->getLocale())->isoFormat('L LT') }}
                                    </td>
                                    <td class="">
                                        <div class="flex items-center gap-2">
                                            <button id="{{ $copyId }}"
                                                class="btnCopy px-3 py-1.5 rounded-md text-sm border border-[#19140035] dark:border-[#3E3E3A] hover:border-[#1915014a] dark:hover:border-[#62605b]"
                                                onclick="copyToClipboard('{{ $short }}', '{{ $copyId }}')">
                                                Copy
                                            </button>
                                            <a href="{{ $short }}" target="_blank"
                                                class="px-3 py-1.5 rounded-md text-sm border border-[#19140035] dark:border-[#3E3E3A] hover:border-[#1915014a] dark:hover:border-[#62605b]">
                                                Open
                                            </a>
                                            <button type="button"
                                                class="btnDelete px-3 py-1.5 rounded-md text-sm border border-red-500 text-red-600 hover:bg-red-50 dark:hover:bg-red-900 dark:text-red-400"
                                                data-code="{{ $url->code }}">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if (method_exists($urls, 'links'))
                        <div class="mt-6">
                            {{ $urls->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
</body>

</html>
