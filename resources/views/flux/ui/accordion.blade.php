{{-- resources/views/components/accordion.blade.php --}}

<div id="accordion-collapse" data-accordion="collapse">
    @foreach($items as $index => $item)
        <h2 id="accordion-collapse-heading-{{ $index }}">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border {{ $index === array_key_last($items) ? '' : 'border-b-0' }}  border-gray-200 {{ $index === 0 ? 'rounded-t-xl' : '' }} focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-{{ $index }}" aria-expanded="true" aria-controls="accordion-collapse-body-{{ $index }}">
                <span>{{ $item['title'] }}</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                </svg>
            </button>
        </h2>
        <div id="accordion-collapse-body-{{ $index }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $index }}">
            <div class="p-5 border {{ $index === array_key_last($items) ? '' : 'border-b-0' }}  border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                <p class="mb-2 text-gray-500 dark:text-gray-400">{!! $item['content'] !!}</p>
            </div>
        </div>
    @endforeach
</div>
