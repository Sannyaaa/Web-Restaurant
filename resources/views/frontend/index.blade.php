@extends('frontend.layout.app')

@section('title-page','Home')

@push('style')
    <style>
        
    </style>
@endpush

@section('content')
    <div class="bg-yellow-300 mt">
        <div class="relative isolate px-6 lg:px-8">
            <div class="w-full md:flex py-16 lg:py-20 px-10 md:px-14 lg:px-20 xl:px-32 space-y-10">
                <div class="w-4/5 md:w-4/5 flex justify-center items-center pe-10">
                    <div class="text-left w-full">
                        <h1 class="text-6xl font-bold text-slate-800 lg:text-8xl font-one">Welcome to <span class="text-white">Our </span>Cozy
                             <span class="text-white">Restaurant</span></h1>

                        <p class="mt-6 text-lg  text-gray-600">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua. Qui irure qui lorem cupidatat commodo.</p>

                        <div class="mt-6 inline-flex items-center gap-x-6">
                            <a href="{{ route('list-menu') }}" class="px-6 py-3 transition-all bg-slate-800 text-white hover:bg-white border-slate-800 border-4 hover:text-slate-800 rounded-xl font-bold text-lg">Explore Menu</a>
                            <a href="{{ route('contact-us') }}" class="px-6 py-3 transition-all bg-white hover:text-white hover:bg-slate-800 border-slate-800 border-4  text-slate-800 rounded-xl font-bold text-lg">Contact Us</a>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-2/4 px-0 md:px-8 mx-auto my-auto">
                    <div class="overflow-hidden">
                        <img src="{{ asset('assets/img/food-bro (1).png') }}" alt="" class=" min-w-10">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-zinc-50">
        <div class="py-24">

            <div class="mt-6">
                <div class="text-center w-3/5 md:w-2/5 mx-auto">
                    <h1 class="text-4xl font-bold  text-slate-800 md:text-5xl lg:text-6xl font-one">Our <span class="text--300">Feature</span></h1>

                    <p class="mt-6 text-lg  text-gray-600">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.</p>
                </div>
                <div class="mt-6 px-4 sm:px-16 lg:px-32">
                    <div class="w-full flex flex-wrap justify-center">
                        <div class="p-4 md:p-6 max-w-sm md:w-1/2 lg:w-1/3">
                            <div class="p-6">
                                <div class="">
                                    <img src="{{ asset('assets/img/Mobile apps-bro.png') }}" alt="" class="w-auto">
                                </div>
                                <div class="text-center">
                                    <h2 class="text-2xl font-one font-bold text-gray-800">Digital Menu</h2>
                                    <p class="mt-2 text-gray-600">Browse our digital menu with ease, featuring high-resolution images and detailed descriptions.</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 md:p-6 max-w-sm md:w-1/2 lg:w-1/3">
                            <div class="p-6">
                                <div>
                                    <img src="{{ asset('assets/img/Coffee shop-amico (2).png') }}" alt="" class="w-auto">
                                </div>
                                <div class="text-center">
                                    <h2 class="text-2xl font-one font-bold text-gray-800">Cozy Atmosphere</h2>
                                    <p class="mt-2 text-gray-600">Relax in our urban jungle-inspired interior, freshly brewed to perfection, designed to make you feel at home.</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 md:p-6 max-w-sm md:w-1/2 lg:w-1/3">
                            <div class="p-6">
                                <div>
                                    <img src="{{ asset('assets/img/healthy food-cuate.png') }}" alt="h-full">
                                </div>
                                <div class="text-center">
                                    <h2 class="text-2xl font-one font-bold text-gray-800">Nutritional Transparency</h2>
                                    <p class="mt-2 text-gray-600">All our menu items come with detailed nutritional information, so you know exactly what you're eating.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-32">
                <div class="text-center w-3/5 md:w-2/5 mx-auto">
                    <h1 class="text-4xl font-bold text-slate-800 md:text-5xl lg:text-6xl font-one">Categories <span class="text-yellow-300">Menu</span></h1>

                    <p class="mt-6 text-lg  text-gray-600">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.</p>
                </div>
                <div class="my-12 px-4 sm:px-16 lg:px-40">
                    <div class="flex justify-center px-10">
                        <div class="w-full flex flex-wrap justify-center">
                            @forelse ($categories as $category)
                                <div class="p-3 md:p-4 bg-opacity-100">
                                    <a href="{{ route('list-menu-category',$category->id) }}" class="flex flex-col justify-center items-center">
                                        <div class="rounded-full border-8 {{ isset($selectedCategory) && $selectedCategory->id == $category->id ? 'border-slate-800' : 'border-yellow-200' }}  group-hover:border-yellow-100 overflow-hidden shadow-lg hover:shadow-2xl transition-all">
                                            <img class="w-28 h-auto aspect-square" src="{{ Storage::url($category->image) }}" alt="category image" />
                                        </div>
                                        <span class="text-base font-semibold px-6 py-3 rounded-full {{ isset($selectedCategory) && $selectedCategory->id == $category->id ? 'bg-slate-800 text-white' : 'bg-white' }} -mt-8 shadow-lg hover:shadow-2xl transition-all">{{ $category->name }}</span>
                                    </a>
                                </div>
                            @empty
                                <span class="text-center">
                                    Belum ada product
                                </span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full px-4 sm:px-16 lg:px-32 space-y-10 mt-16 bg-yellow-300">
                <div class="px-10 md:flex">
                    <div class="w-full md:w-2/4 px-0 md:px-8 mx-auto my-auto">
                        <div class="overflow-hidden">
                            <img src="{{ asset('assets/img/Cooking-bro.png') }}" alt="" class="min-w-10">
                        </div>
                    </div>
                    <div class="w-4/5 md:w-3/4 flex justify-center items-center">
                        <div class="text-left w-full pb-20 md:pt-20">
                            <h1 class="text-5xl font-bold  text-slate-800 md:text-6xl lg:text-7xl font-one">With Our <span class="text-white">Professional</span> Chef</h1>

                            <p class="mt-6 text-lg  text-gray-600">With over 20 years of experience in the culinary industry, Chef Alexander Hamilton has honed his craft in some of the most prestigious kitchens around the world. His passion for combining fresh, local ingredients with innovative techniques has earned him a reputation as a leader in the culinary community.</p>
                        
                            <div class="mt-10">
                                <a href="{{ route('list-menu') }}" class="px-8 py-4 transition-all bg-slate-800 text-white hover:bg-white border-slate-800 border-4 hover:text-slate-800 rounded-xl font-bold text-lg">Explore Menu</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-32">
                <div class="text-center w-3/5 md:w-2/5 mx-auto">
                    <h1 class="text-4xl font-bold  text-slate-800 md:text-5xl lg:text-6xl font-one">Our <span class="text-yellow-300">Favorite</span> Menu</h1>

                    <p class="mt-6 text-lg  text-gray-600">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.</p>
                </div>
                <div class="mt-12 px-4 sm:px-16 lg:px-32">
                    <div class="w-full flex flex-wrap justify-center">

                        @forelse ($menus as $menu)
                            <div class="p-3 md:p-4 max-w-sm md:w-1/2 lg:w-1/3">
                                <a href="{{ route('detail-menu',$menu->id) }}">
                                    <div class="w-full max-w-sm bg-white group border-slate-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                                        <div class="relative aspect-video overflow-hidden bg-cover align-middle">
                                            <img class="object-cover object-center w-full h-full" src="{{ Storage::url($menu->image) }}" alt="menu image" />
                                            
                                            <div class="hidden group-hover:flex transition-all duration-200 absolute -bottom-1 right-1 p-5 text-center text-white font-bold text-sm">
                                                
    
                                                {{-- <span class="absolute top-0 bottom-0 left-0 right-0 text-sm font-bold text-white text-right">
                                                    15 min
                                                </span>
    
                                                <span class="absolute bottom-0 left-0 right-0 text-sm font-bold text-white text-left">
                                                    30 min
                                                </span> --}}
    
                                            </div>
                                        </div>
                                        <div class="px-5 py-5">
                                            <div>
                                                <h5 class="text-xl font-semibold hover:underline  text-gray-900 dark:text-white">{{ $menu->name }} <span class="text-sm font-normal text-slate-400 italic">({{ $menu->category->name }})</span></h5>
                                                
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    {{ Str::limit($menu->description,60) }}...
                                                </p>
                                            </div>
                                            <div class="flex items-center justify-between mt-2.5 mb-2">
                                                <div class="flex items-center space-x-1 rtl:space-x-reverse">
                                                    <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                    </svg>
                                                    <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                    </svg>
                                                    <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                    </svg>
                                                    <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                    </svg>
                                                    <svg class="w-4 h-4 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                    </svg>
                                                </div>
                                                <span class="text-2xl font-bold text-gray-900 dark:text-white">Rp.{{ number_format($menu->price) }}</span>
                                                {{-- <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ms-3">5.0</span> --}}
                                            </div>
                                            <div class="flex items-center justify-between w-full font-semibold text-base space-x-4">
                                                
                                                <div class="flex w-full">
                                                    <button class="w-full py-3 bg-yellow-300 hover:bg-yellow-400 font-semibold text-base rounded-xl text-yellow-900">See More</button>
                                                </div>
                                                <div class="bg-slate-800 hover:bg-slate-900 text-yellow-50 p-3 aspect-square text-lg flex items-center justify-center rounded-xl">
                                                    <i class="fa-solid fa-cart-shopping my-auto"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <span class="text-center">
                                Belum ada product
                            </span>
                        @endforelse

                    </div>

                </div>
            </div>

            <div class="flex px-4 sm:px-16 lg:px-32 mt-40">
                <!--
                    Heads up! 👋

                    This component comes with some `rtl` classes. Please remove them if they are not needed in your project.
                    -->

                    <link href="https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/keen-slider.min.css" rel="stylesheet" />

                    <script type="module">
                    import KeenSlider from 'https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/+esm'

                    const keenSlider = new KeenSlider(
                        '#keen-slider',
                        {
                        loop: true,
                        slides: {
                            origin: 'center',
                            perView: 1.25,
                            spacing: 16,
                        },
                        breakpoints: {
                            '(min-width: 1024px)': {
                            slides: {
                                origin: 'auto',
                                perView: 1.5,
                                spacing: 32,
                            },
                            },
                        },
                        },
                        []
                    )

                    const keenSliderPrevious = document.getElementById('keen-slider-previous')
                    const keenSliderNext = document.getElementById('keen-slider-next')

                    const keenSliderPreviousDesktop = document.getElementById('keen-slider-previous-desktop')
                    const keenSliderNextDesktop = document.getElementById('keen-slider-next-desktop')

                    keenSliderPrevious.addEventListener('click', () => keenSlider.prev())
                    keenSliderNext.addEventListener('click', () => keenSlider.next())

                    keenSliderPreviousDesktop.addEventListener('click', () => keenSlider.prev())
                    keenSliderNextDesktop.addEventListener('click', () => keenSlider.next())
                    </script>

                    <section class="bg-gray-50 mx-auto">
                        <div class="mx-auto max-w-[1340px] px-4 py-12 sm:px-6 lg:me-0 lg:py-16 xl:py-24">
                            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:items-center lg:gap-16">
                                <div class="max-w-2xl ltr:sm:text-left rtl:sm:text-right">
                                    <div class="px-12 sm:px-20 lg:px-0">
                                        <h2 class="text-4xl font-bold  text-slate-800 md:text-5xl lg:text-6xl font-one">
                                            <span class="text-yellow-300">Testimonials</span> Our Customers
                                        </h2>

                                        <p class="mt-4 text-gray-700">
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas veritatis illo placeat
                                        harum porro optio fugit a culpa sunt id!
                                        </p>
                                    </div>

                                    <div class="hidden lg:mt-8 lg:flex lg:gap-4 p-3">
                                    <button
                                        aria-label="Previous slide"
                                        id="keen-slider-previous-desktop"
                                        class="rounded-full border border-rose-600 p-3 text-rose-600 transition hover:bg-rose-600 hover:text-white"
                                    >
                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-5 rtl:rotate-180"
                                        >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.75 19.5L8.25 12l7.5-7.5"
                                        />
                                        </svg>
                                    </button>

                                    <button
                                        aria-label="Next slide"
                                        id="keen-slider-next-desktop"
                                        class="rounded-full border border-rose-600 p-3 text-rose-600 transition hover:bg-rose-600 hover:text-white"
                                    >
                                        <svg
                                        class="size-5 rtl:rotate-180"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                        >
                                        <path
                                            d="M9 5l7 7-7 7"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        />
                                        </svg>
                                    </button>
                                    </div>
                                </div>

                                <div class="-mx-6 lg:col-span-2 lg:mx-0">
                                    <div id="keen-slider" class="keen-slider p-6">

                                        @forelse ($feedbacks as $feedback)
                                            <div class="keen-slider__slide shadow-lg ">
                                                <div class="swiper-slide group hover:bg-yellow-300 bg-white shadow-xl border-solid border-4 border-slate-800 rounded-2xl p-6 transition-all duration-500 hover:shadow-xl">
                                                    <div class="flex items-center gap-5 mb-5 sm:mb-5">
                                                        @if (Auth::user()->avatar)
                                                            <img class="w-10 h-10 rounded-full" src="{{ Storage::url(Auth::user()->avatar) }}" alt="user photo">
                                                        @else
                                                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-slate-800">
                                                                <i class="fa-solid fa-user my-auto"></i>
                                                            </div>
                                                        @endif
                                                        <div class="grid gap-1">
                                                            <h5 class="text-slate-800 font-semibold transition-all duration-500  ">{{ $feedback->name }}</h5>
                                                            <span class="text-sm leading-6 text-gray-500">{{ $feedback->email }}</span>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="flex items-center mb-5 sm:mb-5 gap-2 text-slate-800 transition-all duration-500  ">
                                                        @for ($i = 0;$i < $feedback->rating;$i++)
                                                            <svg class="w-5 h-5" viewBox="0 0 18 17" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M8.10326 1.31699C8.47008 0.57374 9.52992 0.57374 9.89674 1.31699L11.7063 4.98347C11.8519 5.27862 12.1335 5.48319 12.4592 5.53051L16.5054 6.11846C17.3256 6.23765 17.6531 7.24562 17.0596 7.82416L14.1318 10.6781C13.8961 10.9079 13.7885 11.2389 13.8442 11.5632L14.5353 15.5931C14.6754 16.41 13.818 17.033 13.0844 16.6473L9.46534 14.7446C9.17402 14.5915 8.82598 14.5915 8.53466 14.7446L4.91562 16.6473C4.18199 17.033 3.32456 16.41 3.46467 15.5931L4.15585 11.5632C4.21148 11.2389 4.10393 10.9079 3.86825 10.6781L0.940384 7.82416C0.346867 7.24562 0.674378 6.23765 1.4946 6.11846L5.54081 5.53051C5.86652 5.48319 6.14808 5.27862 6.29374 4.98347L8.10326 1.31699Z"
                                                                    fill="currentColor"></path>
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                    <p
                                                        class="text-md text-gray-700 leading-6 transition-all duration-500  group-hover:text-gray-800">
                                                        {{ $feedback->message }}
                                                    </p>
                                                </div>
                                            </div>
                                        @empty
                                            <span>Testimonial Not Found</span>
                                        @endforelse
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-center gap-4 lg:hidden">
                            <button
                                aria-label="Previous slide"
                                id="keen-slider-previous"
                                class="rounded-full border-4 border-slate-800 p-4 text-slate-800 transition hover:bg-yellow-300 hover:text-slate-800"
                            >
                                <svg
                                class="size-5 -rotate-180 transform"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                                >
                                <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </button>

                            <button
                                aria-label="Next slide"
                                id="keen-slider-next"
                                class="rounded-full border-4 border-slate-800 p-4 text-slate-800 transition hover:bg-yellow-300 hover:text-slate-800"
                            >
                                <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                                >
                                <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </button>
                            </div>
                        </div>
                    </section>
            </div>
            
        </div>
    </div>
@endsection

