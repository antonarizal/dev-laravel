@php
    $menus = [
        'Dashboard' => [
            'icon' => 'home',
            'route' => 'dashboard',
            'current' => request()->routeIs('dashboard'),
        ],
        'Master' => [
            'icon' => 'users',
            'expandable' => true,
            'route' => 'admin.users',
            'current' => request()->routeIs('admin.merk') || request()->routeIs('admin.model') || request()->routeIs('admin.types') || request()->routeIs('admin.type_refrigrant') || request()->routeIs('admin.pipa_refrigrant'),
            'items' => [
                [
                    'title' => 'Merk',
                    'route' => 'admin.merk',
                    'current' => request()->routeIs('admin.merk'),
                ],
                [
                    'title' => 'Model',
                    'route' => 'admin.model',
                    'current' => request()->routeIs('admin.model'),
                ],
                [
                    'title' => 'Tipe',
                    'route' => 'admin.types',
                    'current' => request()->routeIs('admin.types'),
                ],
                [
                    'title' => 'Tipe Refrigrant',
                    'route' => 'admin.type_refrigrant',
                    'current' => request()->routeIs('admin.type_refrigrant'),
                ],
                [
                    'title' => 'Pipa Refrigrant',
                    'route' => 'admin.pipa_refrigrant',
                    'current' => request()->routeIs('admin.pipa_refrigrant'),
                ],
            ],
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        button {
            cursor: pointer;
        }
    </style>
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable
        class="border-r border-zinc-200 bg-zinc-50  dark:border-zinc-700 dark:bg-zinc-900 ">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2 text-" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group heading="Platform" class="grid ">
                @foreach ($menus as $title => $menu)
                    @if (isset($menu['expandable']) && $menu['expandable'] == true)
                        <flux:navlist.group expandable :expanded="$menu['current']" heading="{{ $title }}"
                            icon="{{ $menu['icon'] }}" :current="$menu['current']">
                            @foreach ($menu['items'] as $item)
                                <flux:navlist.item wire:navigate href="{{ route($item['route']) }}"
                                    :current="$item['current']" class="text-zinc-100">
                                    {{ $item['title'] }}
                                </flux:navlist.item>
                            @endforeach

                        </flux:navlist.group>
                    @else
                        <flux:navlist.item wire:navigate href="{{ route($menu['route']) }}" icon="{{ $menu['icon'] }}"
                            :current="$menu['current']" class="text-zinc-100" style="text-transform: capitalize;">
                            {{ $title }}
                        </flux:navlist.item>
                    @endif
                @endforeach
            </flux:navlist.group>


        </flux:navlist>

        <flux:spacer />
    </flux:sidebar>

    <!-- Mobile User Menu -->

    <flux:header
        class="hidden lg:block bg-white lg:bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">

        <flux:navbar scrollable class="block">
            {{-- <flux:navbar.item href="#" current>Dashboard</flux:navbar.item>
            <flux:navbar.item badge="32" href="#">Orders</flux:navbar.item>
            <flux:navbar.item href="#">Catalog</flux:navbar.item>
            <flux:navbar.item href="#">Configuration</flux:navbar.item> --}}
        </flux:navbar>
    </flux:header>

    <flux:header>

        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item href="/admin/settings/profile" icon="cog" wire:navigate>Settings
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>

</html>
