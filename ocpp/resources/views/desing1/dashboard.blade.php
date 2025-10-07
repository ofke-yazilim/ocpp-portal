@extends('desing1.app')
@section('main')
<main class="flex-1 px-4 sm:px-6 lg:px-10 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Dashboard</h1>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="flex flex-col gap-2 rounded-lg p-6 bg-white dark:bg-primary/10 border border-primary/20 dark:border-primary/30 shadow-sm">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-primary text-3xl">power</span>
                    <p class="text-base font-medium text-gray-600 dark:text-gray-300">Charge Points Online</p>
                </div>
                <p class="text-4xl font-bold text-gray-900 dark:text-white">15 <span class="text-lg font-medium text-gray-500 dark:text-gray-400">/ 20</span></p>
            </div>
            <div class="flex flex-col gap-2 rounded-lg p-6 bg-white dark:bg-primary/10 border border-primary/20 dark:border-primary/30 shadow-sm">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-primary text-3xl">electric_bolt</span>
                    <p class="text-base font-medium text-gray-600 dark:text-gray-300">Total Energy Consumed</p>
                </div>
                <p class="text-4xl font-bold text-gray-900 dark:text-white">2345<span class="text-lg font-medium text-gray-500 dark:text-gray-400"> kWh</span></p>
            </div>
            <div class="flex flex-col gap-2 rounded-lg p-6 bg-white dark:bg-primary/10 border border-primary/20 dark:border-primary/30 shadow-sm">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-primary text-3xl">ev_station</span>
                    <p class="text-base font-medium text-gray-600 dark:text-gray-300">Active Sessions</p>
                </div>
                <p class="text-4xl font-bold text-gray-900 dark:text-white">3</p>
            </div>
            <div class="flex flex-col gap-2 rounded-lg p-6 bg-white dark:bg-primary/10 border border-primary/20 dark:border-primary/30 shadow-sm">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-primary text-3xl">history</span>
                    <p class="text-base font-medium text-gray-600 dark:text-gray-300">Recent Activity</p>
                </div>
                <p class="text-lg font-medium text-gray-900 dark:text-white">Last session: 2h ago</p>
            </div>
        </div>
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white mt-12 mb-6">Charge Point Status</h2>
        <div class="@container overflow-hidden rounded-lg border border-primary/20 dark:border-primary/30 bg-white dark:bg-primary/10 shadow-sm">
            <table class="w-full text-left">
                <thead class="bg-primary/5 dark:bg-primary/20">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-700 dark:text-gray-200">Charge Point ID</th>
                    <th class="p-4 text-sm font-semibold text-gray-700 dark:text-gray-200">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-700 dark:text-gray-200 hidden @[768px]:table-cell">Location</th>
                    <th class="p-4 text-sm font-semibold text-gray-700 dark:text-gray-200 hidden @[1024px]:table-cell">Last Session</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-primary/10 dark:divide-primary/20">
                <tr>
                    <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">CP001</td>
                    <td class="p-4 text-sm">
                    <span class="inline-flex items-center gap-2 rounded-full bg-green-100 dark:bg-green-900/50 px-3 py-1 text-xs font-semibold text-green-800 dark:text-green-300">
                        <span class="h-2 w-2 rounded-full bg-green-500"></span>
                        Online
                   </span>
                    </td>
                    <td class="p-4 text-sm text-gray-600 dark:text-gray-400 hidden @[768px]:table-cell">Parking Lot A</td>
                    <td class="p-4 text-sm text-gray-600 dark:text-gray-400 hidden @[1024px]:table-cell">1 hour ago</td>
                </tr>
                <tr>
                    <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">CP002</td>
                    <td class="p-4 text-sm">
                        <span class="inline-flex items-center gap-2 rounded-full bg-red-100 dark:bg-red-900/50 px-3 py-1 text-xs font-semibold text-red-800 dark:text-red-300">
                            <span class="h-2 w-2 rounded-full bg-red-500"></span>
                            Offline
                        </span>
                    </td>
                    <td class="p-4 text-sm text-gray-600 dark:text-gray-400 hidden @[768px]:table-cell">Parking Lot B</td>
                    <td class="p-4 text-sm text-gray-600 dark:text-gray-400 hidden @[1024px]:table-cell">2 days ago</td>
                </tr>
                <tr>
                    <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">CP003</td>
                    <td class="p-4 text-sm">
                        <span class="inline-flex items-center gap-2 rounded-full bg-green-100 dark:bg-green-900/50 px-3 py-1 text-xs font-semibold text-green-800 dark:text-green-300">
                        <span class="h-2 w-2 rounded-full bg-green-500"></span>
                      Online
                    </span>
                    </td>
                    <td class="p-4 text-sm text-gray-600 dark:text-gray-400 hidden @[768px]:table-cell">Parking Lot A</td>
                    <td class="p-4 text-sm text-gray-600 dark:text-gray-400 hidden @[1024px]:table-cell">30 minutes ago</td>
                </tr>
                <tr>
                    <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">CP004</td>
                    <td class="p-4 text-sm">
                        <span class="inline-flex items-center gap-2 rounded-full bg-blue-100 dark:bg-blue-900/50 px-3 py-1 text-xs font-semibold text-blue-800 dark:text-blue-300">
                        <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                        Charging
                      </span>
                    </td>
                    <td class="p-4 text-sm text-gray-600 dark:text-gray-400 hidden @[768px]:table-cell">Parking Lot C</td>
                    <td class="p-4 text-sm text-gray-600 dark:text-gray-400 hidden @[1024px]:table-cell">2 hours ago</td>
                </tr>
                <tr>
                    <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">CP005</td>
                    <td class="p-4 text-sm">
                        <span class="inline-flex items-center gap-2 rounded-full bg-red-100 dark:bg-red-900/50 px-3 py-1 text-xs font-semibold text-red-800 dark:text-red-300">
                        <span class="h-2 w-2 rounded-full bg-red-500"></span>
                      Offline
                    </span>
                    </td>
                    <td class="p-4 text-sm text-gray-600 dark:text-gray-400 hidden @[768px]:table-cell">Parking Lot B</td>
                    <td class="p-4 text-sm text-gray-600 dark:text-gray-400 hidden @[1024px]:table-cell">1 day ago</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
