@extends('frontend.layout.app')

@section('title-page','List-Menu')

@section('content')
    <div class="bg-zinc-200 bg-cover h-full" style="background-image: url('https://images.unsplash.com/photo-1661775085411-7ad692c9a436?q=80&w=1474&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')">
        <div class="relative isolate px-6 pt-14 lg:px-8 bg-opacity-40 bg-yellow-700">
            <div class="w-full flex py-24 sm:py-28 lg:py-32 px-0 md:px-32">
                <div class="w-full">
                    <div class="flex flex-col text-center items-center justify-center">
                        <h1 class="text-6xl font-bold tracking-tight text-slate-50 md:text-7xl font-one">Explore Our Menu</h1>
                        <div class=" lg:w-1/2 mt-5">
                            <form action="{{ route('list-menu') }}" method="GET" class="mx-auto flex gap-4">
                                <!-- component -->
                                <div class="flex flex-col p-2 py-6 m-h-screen w-full">
                                    <div class="bg-white items-center justify-between w-full flex rounded-full shadow-lg p-2 mb-5 sticky" style="top: 5px">

                                        <input name="search" class="font-bold uppercase rounded-full w-full py-4 pl-4 text-gray-700 bg-slate-50 leading-tight focus:outline-none focus:border-yellow-300 focus:ring-yellow-300 focus:ring-2 focus:shadow-outline lg:text-sm text-xs" type="text" placeholder="Search">

                                        <button type="submit" class="">
                                            <div class="bg-slate-800 p-3 hover:bg-yellow-400 group cursor-pointer border-slate-800 transition-all duration-200 ms-3 rounded-full">

                                                <svg class="w-7 h-7 text-white group-hover:text-slate-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-zinc-50">
        <div class="py-20">
            <div class="flex flex-col justify-center px-10 md:px-32 xl:px-64">
                {{-- <h1 class="text-5xl font-bold tracking-tight text-slate-800 mb-4 md:text-6xl font-one">Explore Our Menu</h1> --}}
                <div class="w-full flex flex-wrap justify-center">
                    <!-- Menampilkan Kategori -->
                    <div class="p-3 md:p-4 max-w-sm bg-opacity-100">
                        <a href="{{ route('list-menu') }}" class="flex flex-col justify-center items-center">
                            <div class="rounded-full border-8 {{ empty($selectedCategory) ? 'border-slate-800' : 'border-yellow-200' }}  group-hover:border-yellow-100 overflow-hidden shadow-lg hover:shadow-2xl">
                                <div class="h-28 w-28 flex items-center bg-slate-100 justify-center font-semibold">ALL</div>
                            </div>
                            <span class="text-base font-semibold px-6 py-3  rounded-full {{ empty($selectedCategory) ? 'bg-slate-800 text-white' : 'bg-white' }} -mt-8 shadow-lg hover:shadow-2xl transition-all">All</span>
                        </a>
                    </div>
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
                            Category not Found
                        </span>
                    @endforelse
                </div>
            </div>

            <div class="mt-8 px-0 md:px-16 lg:px-32">
                <div class="w-full flex flex-wrap justify-center">
                    <!-- Menampilkan Menu -->
                    @forelse ($menus as $menu)
                        <div class="p-3 md:p-4 max-w-sm sm:max-w-xs lg:max-w-sm">
                            <a href="{{ route('detail-menu',$menu->id) }}">
                                <div class="w-full bg-white group border-slate-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                                    <div class="relative aspect-video overflow-hidden bg-cover align-middle p-2">
                                        <img class="object-cover object-center w-full h-full rounded-md" src="{{ Storage::url($menu->image) }}" alt="menu image" />
                                    </div>
                                    <div class="px-5 py-5">
                                        <div>
                                            <h5 class="text-xl font-semibold hover:underline text-gray-900 dark:text-white">{{ $menu->name }} </h5>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">{!! Str::limit($menu->description,60) !!}...</div>
                                        </div>
                                        <div class="flex items-center justify-between mt-2.5 mb-2">
                                            {{-- <div class="flex items-center space-x-1 rtl:space-x-reverse">
                                                <svg class="w-5 h-5 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                </svg>
                                                <svg class="w-5 h-5 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                </svg>
                                                <svg class="w-5 h-5 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                </svg>
                                                <svg class="w-5 h-5 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                </svg>
                                                <svg class="w-5 h-5 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                </svg>
                                                <!-- Rating lainnya -->
                                            </div> --}}
                                            <span class="text-sm font-normal text-slate-400 italic">Category : {{ $menu->category->name }}</span>
                                            <span class="text-2xl font-bold text-gray-900 dark:text-white">Rp.{{ number_format($menu->price) }}</span>
                                        </div>
                                        <div class="flex items-center justify-between w-full font-semibold text-base space-x-4">
                                            <div class="flex w-full">
                                                <button class="w-full py-3 bg-yellow-300 hover:bg-yellow-400 font-semibold text-base rounded-xl text-yellow-900">See More</button>
                                            </div>
                                            <form id="addToCartForm-{{ $menu->id }}" data-menu-id="{{ $menu->id }}"> 
                                                @csrf 
                                                <input type="hidden" name="menu_id" value="{{ $menu->id }}"> 
                                                <input type="hidden" name="quantity" value="1"> 
                                                <button type="submit" class="add-to-cart-btn"> 
                                                    <div class="bg-slate-800 hover:bg-slate-900 text-yellow-50 p-4 text-base flex items-center justify-center rounded-xl"> 
                                                        <i class="fa-solid fa-cart-shopping my-auto"></i> 
                                                    </div> 
                                                </button> 
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <span class="text-center">
                            Menu Not Found
                        </span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

            {{-- <div class="flex mx-40 mt-40">
                <div class="w-1/2">
                    
                </div>
                <div class="w-1/2">
                    <div class="">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Data to enrich your online business</h1>

                        <p class="mt-6 text-lg leading-8 text-gray-600">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.</p>

                    </div>
                </div>
            </div> --}}

            <div class="mt-32">
                <div class="text-center w-2/5 mx-auto">
                    <h1 class="text-4xl font-bold font-one tracking-tight text-gray-900 sm:text-6xl">Recomended <span class="text-yellow-300">Menus</span></h1>

                    <p class="mt-6 text-lg leading-8 text-gray-600">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.</p>
                </div>
                <div class="mt-12 px-12 md:px-32">
                    <div class="w-full flex flex-wrap justify-center">
                        
                        @forelse ($recommendations as $rec)
                            <div class="p-3 md:p-4 min-w-xs w-auto">
                                <a href="{{ route('detail-menu',$rec->id) }}">
                                    <div class="w-full max-w-sm bg-white group border-slate-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                                        <div class="relative aspect-video overflow-hidden bg-cover align-middle">
                                            <img class="object-cover object-center w-full h-full" src="{{ Storage::url($rec->image) }}" alt="rec image" />
                                        </div>
                                        <div class="px-5 py-5">
                                            <div>
                                                <h5 class="text-xl font-semibold hover:underline text-gray-900 dark:text-white">{{ $rec->name }} </h5>
                                                <div class="text-sm text-gray-600 dark:text-gray-400">{!! Str::limit($rec->description,60) !!}...</div>
                                            </div>
                                            <div class="flex items-center justify-between mt-2.5 mb-2">
                                                {{-- <div class="flex items-center space-x-1 rtl:space-x-reverse">
                                                    <svg class="w-5 h-5 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                    </svg>
                                                    <svg class="w-5 h-5 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                    </svg>
                                                    <svg class="w-5 h-5 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                    </svg>
                                                    <svg class="w-5 h-5 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                    </svg>
                                                    <svg class="w-5 h-5 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                    </svg>
                                                    <!-- Rating lainnya -->
                                                </div> --}}
                                                <span class="text-sm font-normal text-slate-400 italic">Category : {{ $rec->category->name }}</span>
                                                <span class="text-2xl font-bold text-gray-900 dark:text-white">Rp.{{ number_format($rec->price) }}</span>
                                            </div>
                                            <div class="flex items-center justify-between w-full font-semibold text-base space-x-4">
                                                <div class="flex w-full">
                                                    <button class="w-full py-3 bg-yellow-300 hover:bg-yellow-400 font-semibold text-base rounded-xl text-yellow-900">See More</button>
                                                </div>
                                                <form action="{{ route('cart.store') }}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="menu_id" value="{{ $rec->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button class="">
                                                        <div class="bg-slate-800 hover:bg-slate-900 text-yellow-50 p-4 text-base flex items-center justify-center rounded-xl">
                                                            <i class="fa-solid fa-cart-shopping my-auto"></i>
                                                        </div>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <span class="text-center">
                                Menu Not Found
                            </span>
                        @endforelse

                    </div>

                </div>
            </div>

            <div class="flex mx-40 mt-40">
                
            </div>

            <div class="flex">
                
            </div>
            
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.add-to-cart-btn').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                var menuId = form.data('menu-id');
                
                $.ajax({
                    url: "{{ route('cart.store') }}",
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        // Tampilkan pesan sukses
                        alert('Menu berhasil ditambahkan ke keranjang!');
                        // Anda bisa menambahkan logika lain di sini, seperti memperbarui ikon keranjang, dll.
                    },
                    error: function(xhr) {
                        // Tampilkan pesan error
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            });
        });
        </script>
@endpush