@props(['id' => null]) <!-- Terima prop `id` dan berikan nilai default null -->

<tr class="bg-white border-b dark:bg-zinc-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-zinc-900" {{ $attributes }}>

    {{ $slot }}
</tr>
