<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <a href="{{ route('app.dashboard') }}" class="ml-2 mr-5 flex items-center space-x-2 lg:ml-0" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="layout-grid" :href="route('app.dashboard')" :current="request()->routeIs('app.dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:navbar.item>
            </flux:navbar>
            <flux:spacer />
            <!-- Desktop User Menu -->
            <flux:dropdown position="top" align="end">

                <flux:button icon="arrow-right-start-on-rectangle" class="w-full" href="{{ route('app.siswa.logout') }}">
                    {{ __('Log Out') }}
                </flux:button>
            </flux:dropdown>
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar stashable sticky class="lg:hidden border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('app.dashboard') }}" class="ml-1 flex items-center space-x-2" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group heading="Platform">
                    <flux:navlist.item icon="layout-grid" :href="route('app.dashboard')" :current="request()->routeIs('app.dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="arrow-right-start-on-rectangle" href="https://laravel.com/docs/starter-kits" target="_blank">
                {{ __('Logout') }}
                </flux:navlist.item>
            </flux:navlist>
        </flux:sidebar>


        {{ $slot }}

        @fluxScripts
    </body>
</html>
