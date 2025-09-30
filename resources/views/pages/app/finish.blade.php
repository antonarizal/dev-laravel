<?php
use function Laravel\Folio\name;
use function Laravel\Folio\{middleware};
name('app.finish');
?>
<x-layouts.app.login>
    @volt
        <div>
            <div class="h-14 bg-linear-to-r from-sky-800 to-blue-400 h-50 bg-[url({{ asset('header-bg.jpg') }})]">
                <div class="grid justify-center pt-10">
                    <h3 class="text-white text-3xl font-semibold">UJIAN ONLINE</h3>
                </div>
            </div>
            <div class="bg-muted flex flex-col items-center justify-center gap-6 p-6 md:p-10">
                <div class="flex -mt-50 w-full max-w-md flex-col gap-6">
                    <div class="flex flex-col gap-6">
                        <div
                            class="rounded-xl border bg-white dark:bg-stone-950 dark:border-stone-800 text-stone-800 shadow-xs  mt-15">
                            <div class="mt-10 mx-10 ">
                                <h3 class="font-bold text-4xl">Selesai,</h3>
                                <h4>Anda telah menyelesaikan ujian.</h4>
                            </div>
                            <div class="p-10">

                                <flux:button href="{{ route('app.siswa.logout') }}" class="w-full" variant="primary" icon-trailing="arrow-right">
                                    Logout
                                </flux:button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endvolt
</x-layouts.app.login>
