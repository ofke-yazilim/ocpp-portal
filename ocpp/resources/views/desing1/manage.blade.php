@extends('desing1.app')
@section('main')
    <main class="flex-1 px-4 sm:px-6 lg:px-8 py-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Charge Points</h1>
                <p class="mt-1 text-gray-500 dark:text-gray-400">Manage and monitor your EV charging infrastructure.</p>
            </div>
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="relative flex-1">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="material-symbols-outlined text-gray-400"> search </span>
                    </div>
                    <input class="block w-full rounded-lg border-primary/20 dark:border-primary/30 bg-background-light dark:bg-background-dark py-2 pl-10 pr-4 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-primary focus:ring-primary" placeholder="Search by location or charge point ID" type="search"/>
                </div>
                <div class="flex items-center gap-2">
                    <button class="flex items-center justify-center gap-2 rounded-lg bg-primary/20 dark:bg-primary/30 px-4 py-2 text-sm font-medium text-primary">All</button>
                    <button class="flex items-center justify-center gap-2 rounded-lg bg-transparent px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-primary/10 dark:hover:bg-primary/20 hover:text-primary">Online</button>
                    <button class="flex items-center justify-center gap-2 rounded-lg bg-transparent px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-primary/10 dark:hover:bg-primary/20 hover:text-primary">Offline</button>
                    <button class="flex items-center justify-center gap-2 rounded-lg bg-transparent px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-primary/10 dark:hover:bg-primary/20 hover:text-primary">Charging</button>
                </div>
            </div>
            <div class="overflow-x-auto rounded-lg border border-primary/20 dark:border-primary/30 bg-background-light dark:bg-background-dark">
                <table class="min-w-full divide-y divide-primary/20 dark:divide-primary/30">
                    <thead class="bg-primary/10 dark:bg-primary/20">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Charge Point ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Last Updated</th>
                        <th class="relative px-6 py-3" scope="col">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-primary/20 dark:divide-primary/30">
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">CP-001</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">123 Main Street, Anytown</td>
                        <td class="whitespace-nowrap px-6 py-4">
<span class="inline-flex items-center rounded-full bg-green-100 dark:bg-green-900/50 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:text-green-300">
<svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
<circle cx="4" cy="4" r="3"></circle>
</svg>
                      Online
                    </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">2024-01-26 10:00 AM</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <a class="text-primary hover:text-primary/80" href="#">View Details</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">CP-002</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">456 Oak Avenue, Anytown</td>
                        <td class="whitespace-nowrap px-6 py-4">
<span class="inline-flex items-center rounded-full bg-blue-100 dark:bg-blue-900/50 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:text-blue-300">
<svg class="-ml-0.5 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
<circle cx="4" cy="4" r="3"></circle>
</svg>
                      Charging
                    </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">2024-01-26 10:15 AM</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <a class="text-primary hover:text-primary/80" href="#">View Details</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">CP-003</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">789 Pine Lane, Anytown</td>
                        <td class="whitespace-nowrap px-6 py-4">
<span class="inline-flex items-center rounded-full bg-gray-100 dark:bg-gray-700/50 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:text-gray-300">
<svg class="-ml-0.5 mr-1.5 h-2 w-2 text-gray-400" fill="currentColor" viewBox="0 0 8 8">
<circle cx="4" cy="4" r="3"></circle>
</svg>
                      Offline
                    </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">2024-01-26 09:45 AM</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <a class="text-primary hover:text-primary/80" href="#">View Details</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">CP-004</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">101 Elm Road, Anytown</td>
                        <td class="whitespace-nowrap px-6 py-4">
<span class="inline-flex items-center rounded-full bg-green-100 dark:bg-green-900/50 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:text-green-300">
<svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
<circle cx="4" cy="4" r="3"></circle>
</svg>
                      Online
                    </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">2024-01-26 10:05 AM</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <a class="text-primary hover:text-primary/80" href="#">View Details</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">CP-005</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">222 Maple Drive, Anytown</td>
                        <td class="whitespace-nowrap px-6 py-4">
<span class="inline-flex items-center rounded-full bg-blue-100 dark:bg-blue-900/50 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:text-blue-300">
<svg class="-ml-0.5 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
<circle cx="4" cy="4" r="3"></circle>
</svg>
                      Charging
                    </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">2024-01-26 10:20 AM</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <a class="text-primary hover:text-primary/80" href="#">View Details</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
