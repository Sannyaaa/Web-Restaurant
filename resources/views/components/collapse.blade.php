<!-- resources/views/components/collapse.blade.php -->
@props(['id', 'title', 'active' => false])

<li class="mt-0.5 w-full px-2">
    <button 
        class="dark:text-white dark:opacity-80 text-base ease-nav-brand my-0 flex items-center whitespace-nowrap px-4 transition-colors py-2 w-full text-left focus:outline-none {{ $active ? 'bg-yellow-100 font-semibold text-slate-600 rounded-lg py-3' : 'py-2' }}" 
        type="button" 
        data-collapse-toggle="{{ $id }}" 
        aria-expanded="{{ $active ? 'true' : 'false' }}" 
        aria-controls="{{ $id }}">
        <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
            <i class="{{ $attributes->get('icon') }}"></i>
        </div>
        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">{{ $title }}</span>
        <i class="ml-auto fa fa-chevron-down transition-transform duration-200 transform {{ $active ? 'rotate-180' : '' }}" id="chevron-icon-{{ $id }}"></i>
    </button>
    <div id="{{ $id }}" class="{{ $active ? 'block bg-zinc-50' : 'hidden' }}  text-slate-600 text-sm overflow-hidden rounded-lg transition-all duration-300">
        {{ $slot }}
    </div>
</li>