<x-app-layout :showDefaultNavigation="false">
    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0">{{ $title ?? 'Page' }}</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">This page is ready. Content for {{ $title ?? 'this page' }} will be added here.</p>
            </div>
        </div>
    </div>
</x-app-layout>

