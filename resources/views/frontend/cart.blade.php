@extends('frontend.layout.app')

@section('title-page','Cart')

@push('style')
    {{-- <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css"  rel="stylesheet" /> --}}
@endpush

@section('content')
    <section class="bg-zinc-50 antialiased dark:bg-gray-900  py-16">
        <div class="mx-auto max-w-screen-xl px-10 2xl:px-0">
            <h2 class="font-semibold text-gray-900 dark:text-white text-5xl font-one">Shopping Cart</h2>

            <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl space-y-6">
                    {{-- {{ dd(session('cart')) }} --}}
                    @if (session('cart') != null)
                        @foreach (session('cart') as $id => $cart)
                            {{-- {{ dd($cart) }} --}}
                            <div class="space-y-6 relative">
                                <div class="absolute -top-5 -right-5 shadow-lg inline-flex items-center font-medium text-slate-800 bg-yellow-300 rounded-full hover:bg-yellow-400 aspect-square hover:underline ">
                                    <form action="{{ route('cart.destroy', $cart['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-14 h-14 aspect-square">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-xl dark:border-gray-700 dark:bg-gray-800 md:p-6">
                                    <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                                        <!-- Item Image and Details -->
                                        <a href="{{ route('detail-menu', $cart['id']) }}" class="shrink-0 md:order-1">
                                            <div class=" h-32 w-40 overflow-hidden">
                                                <img class="w-full h-full object-cover object-center dark:hidden" src="{{ Storage::url($cart['image']) }}" alt="menu image" />
                                            </div>
                                            <img class="hidden dark:block" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg" alt="menu image" />
                                        </a>

                                        <!-- Quantity Form -->
                                        <label for="counter-input-{{ $id }}" class="sr-only">Choose quantity:</label>
                                        <div class="md:order-3">
                                            <form action="{{ route('cart-update') }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <div class="flex items-center justify-between md:order-3 md:justify-end">
                                                    <div class="flex items-center">
                                                        <button type="button" id="decrement-button-{{ $id }}" data-input-counter-decrement="counter-input-{{ $id }}" class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                                            <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                            </svg>
                                                        </button>
                                                        <input type="text" id="counter-input-{{ $id }}" data-input-counter class="w-10 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 dark:text-white" placeholder="" value="{{ $cart['quantity'] }}" name="cart[{{ $id }}][quantity]" required />
                                                        <button type="button" id="increment-button-{{ $id }}" data-input-counter-increment="counter-input-{{ $id }}" class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                                            <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="text-end md:order-4 md:w-32">
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $cart['quantity'] ." X Rp.". number_format($cart['price']) }}</p>
                                                        <p class="text-lg font-bold text-gray-900 dark:text-white">Rp.{{ number_format($cart['quantity'] * $cart['price']) }}</p>
                                                    </div>
                                                </div>
                                                <!-- Button to update quantity -->
                                                {{-- <div class="mt-2">
                                                    <button type="submit" class="inline-flex items-center font-medium text-green-600 hover:underline dark:text-green-500">
                                                        Update
                                                    </button>
                                                </div>
                                            </form> --}}
                                        </div>

                                        <!-- Item Details -->
                                        <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                                            <div>
                                                <a href="{{ route('detail-menu', $cart['id']) }}" class="text-xl font-semibold text-gray-900 hover:underline dark:text-white">
                                                    {{ $cart['name'] }}
                                                </a>
                                                <p class="mt-3 text-base font-semibold text-gray-900 dark:text-white">
                                                    Category : <span class="text-slate-600">{{ $cart['category'] }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center md:-mt-6">
                                        
                                        @if ($cart['modifiers'] != null)
                                            <div class="flex w-full justify-between md:ms-48">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Modifiers:</h3>
                                                    <ul class="list-disc list-inside mt-2">
                                                        @foreach ($cart['selected_modifiers'] as $modifier)
                                                            <li class="text-gray-600 dark:text-gray-400">
                                                                {{ $modifier->name }} (x{{ $modifier->quantity }}) 
                                                                @if ($modifier->quantity > 1)
                                                                    <span class="text-sm text-gray-500 -mt-5">
                                                                        (Rp.{{ number_format($modifier->price) }} each)
                                                                    </span>
                                                                @endif
                                                                <span class="font-semibold">+ Rp.{{ number_format($modifier->total_price) }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-base font-semibold text-gray-600 dark:text-white">
                                                        Total Modifier Price: 
                                                        <br>
                                                        <span class="font-semibold text-lg text-gray-900">Rp.{{ number_format($cart['total_modifier_price']) }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Instructions Form -->
                                    <div class="md:flex items-center gap-4 w-full mt-6">
                                        <div class="w-1/5 text-base font-medium">
                                            Add Instruction :
                                        </div>
                                        <div class="w-full">
                                            <input type="text" name="cart[{{ $id }}][instructions]" id="instructions-{{ $id }}" class="h-10  border-slate-300 mt-1 rounded-md py-5 px-4 w-full bg-gray-50" value="{{ $cart['instructions'] }}" />
                                        </div>
                                        
                                    </div>

                                    <!-- Modifier Button and Modal -->
                                    <div class="mt-4 sm:flex items-center justify-between">
                                        <div class="w-1/5 flex text-medium font-medium">
                                            <div class="flex justify-end items-center gap-5 px-3">
                                                {{-- <form action="{{ route('cart-update') }}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="cart[{{ $id }}][quantity]" value="{{ $cart['quantity'] }}">
                                                    <input type="hidden" name="cart[{{ $id }}][instructions]" value="{{ $cart['instructions'] }}"> --}}
                                                    <button type="submit" class="inline-flex">
                                                        <div class="font-semibold inline-block w-full text-white bg-slate-800 hover:text-slate-800 hover:bg-yellow-300 transition-all rounded-lg py-3 px-6">
                                                            Update
                                                        </div>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            <div class="w-auto">
                                                <button data-modal-target="modifier-modal-{{ $id }}" data-modal-toggle="modifier-modal-{{ $id }}" class="w-full" type="button">
                                                    <div class="font-semibold inline-block w-full hover:text-white bg-yellow-300 hover:bg-slate-800 transition-all rounded-lg py-3 px-6">
                                                        Modifier
                                                    </div>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="text-right mt-4 sm:mt-0">
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                                Total Item Price: Rp.{{ number_format($cart['total_item_price']) }}
                                            </p>
                                        </div>

                                        <!-- Modal -->
                                        <div id="modifier-modal-{{ $id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-y-auto h-modal md:h-full" aria-hidden="true">
                                            <div class="relative w-full h-full max-w-2xl md:h-auto">
                                                <!-- Modal content -->
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <!-- Modal header -->
                                                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                            Modifiers for {{ $cart['name'] }}
                                                        </h3>
                                                        <button type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:text-gray-500 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modifier-modal-{{ $id }}">
                                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l12 12M13 1L1 13" />
                                                            </svg>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="px-6 py-4 space-y-6">
                                                        <form action="{{ route('cart-update-modifier') }}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            @foreach ($modifiers as $modifier)
                                                                <div class="flex items-center justify-between">
                                                                    <div class="flex items-center my-4">
                                                                        <!-- Checkbox untuk memilih modifier -->
                                                                        <input type="checkbox" name="modifiers[]" id="modifier-{{ $modifier->id }}" value="{{ $modifier->id }}"
                                                                            class="mr-2"
                                                                            @if(in_array($modifier->id, $cart['modifiers'])) checked @endif
                                                                            onchange="toggleModifierQuantity({{ $modifier->id }}, {{ $id }})">
                                                                        <label for="modifier-{{ $modifier->id }}" class="text-gray-900 dark:text-gray-300">
                                                                            {{ $modifier->name }} (+Rp.{{ number_format($modifier->price) }}) <span class="text-sm text-slate-500">// {{ $modifier->category }}</span>
                                                                        </label>
                                                                    </div>

                                                                    <!-- Input untuk quantity, akan terlihat jika checkbox dipilih -->
                                                                    <div id="quantity-wrapper-{{ $modifier->id }}-{{ $id }}" class="ml-4" 
                                                                        @if(!in_array($modifier->id, $cart['modifiers'])) style="display:none;" @endif>
                                                                        <input type="number" name="modifier_quantities[{{ $modifier->id }}]" id="quantity-{{ $modifier->id }}-{{ $id }}" 
                                                                            value="{{ $cart['modifier_quantities'][$modifier->id] ?? 1 }}" min="1"
                                                                            class="w-16 text-center border-gray-300 rounded-md">
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                            @endforeach
                                                            <input type="hidden" name="cart_id" value="{{ $id }}">
                                                            <button type="submit" class="inline-flex items-center mt-5 font-medium dark:text-blue-500">
                                                                <div class="font-semibold inline-block w-full hover:text-white bg-yellow-300 hover:bg-slate-800 transition-all rounded-lg py-3 px-6">
                                                                    Save Modifier
                                                                </div>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <span>Belum ada menu di keranjangmu. <a class="hover:underline text-yellow-400" href="{{ route('list-menu') }}">Explore Our Menu</a></span>    
                    @endif


                    {{-- <div class="xl:mt-16 xl:block">
                        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">People also bought</h3>
                        <div class="grid grid-cols-3 gap-4 sm:mt-8">
                            @forelse ($recommendations as $recom)
                                <div class="space-y-4 overflow-hidden rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                                    <a href="{{ route('detail-menu',$recom->id) }}" class="overflow-hidden rounded">
                                        <img class="mx-auto w-full dark:hidden" src="{{ Storage::url($recom->image) }}" alt="imac image" />
                                        <img class="mx-auto hidden h-44 w-44 dark:block" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg" alt="imac image" />
                                    </a>
                                    <div class="">
                                        <a href="{{ route('detail-menu',$recom->id) }}" class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white">{{ $recom->name }}</a>
                                        <p class="mt-2 text-base font-normal text-gray-500 dark:text-gray-400">{{ Str::limit($recom->description, 60, '...') }}</p>
                                        <p class="mt-2 text-lg font-bold leading-tight text-red-600 dark:text-red-500">Rp.{{ number_format($recom->price) }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('detail-menu',$recom->id) }}" class="mt-4">
                                            <div class="flex relative">
                                                <button type="submit" class="z-10 w-full rounded-2xl bg-white px-6 py-2 text-lg font-bold text-slate-800 shadow-md border-8 border-slate-800 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">See More</button>
                                                <span class="absolute w-full z-0 bg-slate-800 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-slate-800">See More</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="mt-6 flex items-center gap-2.5">
                                        <button data-tooltip-target="favourites-tooltip-1" type="button" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white p-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6C6.5 1 1 8 5.8 13l6.2 7 6.2-7C23 8 17.5 1 12 6Z"></path>
                                            </svg>
                                        </button>
                                        <div id="favourites-tooltip-1" role="tooltip" class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700">
                                            Add to favourites
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <button type="button" class="inline-flex w-full items-center justify-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium  text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7h-1M8 7h-.688M13 5v4m-2-2h4" />
                                            </svg>
                                            Add to cart
                                        </button>
                                    </div>
                                </div>
                            @empty
                            <span> ... </span>
                            @endforelse
                        </div>
                    </div> --}}
                </div>

                <div class="mx-auto max-w-4xl flex-1 space-y-6 mt-6 lg:w-full">
                    <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-xl dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">Order Form</p>
                        <form class="space-y-4" action="{{ route('checkout') }}" method="POST">
                            @csrf
                            @method('POST')

                            <div>
                                <div>
                                    <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Your Name <span class="text-rose-500">*</span></label>
                                    <input type="text" id="name" name="name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="your name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required />
                                </div>
                                @error('name')
                                    <div class="my-2 py-2 px-6 bg-rose-200 rounded-lg">
                                        <div class="alert alert-success text-sm text-rose-700">
                                            {{ $message }}
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <div>
                                    <label for="phone" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Your Phone <span class="text-rose-500">*</span></label>
                                    <input type="number" id="phone" name="phone" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" value="{{ Auth::check() ? Auth::user()->phone : '' }}" placeholder="your phone" required />
                                </div>
                                @error('phone')
                                    <div class="my-2 py-2 px-6 bg-rose-200 rounded-lg">
                                        <div class="alert alert-success text-sm text-rose-700">
                                            {{ $message }}
                                        </div>
                                    </div>
                                @enderror
                            </div>

                            <div class="">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select table <span class="text-rose-500">*</span></label>
                                <select id="countries" name="table_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option selected>Choose Table</option>
                                    @forelse ($tables as $table)
                                        <option value="{{ $table->id }}" {{ request()->cookie('table_id') == $table->id ? 'selected' : '' }}>{{ $table->name }}</option>
                                    @empty
                                        <option value="">Belum ada meja</option>
                                    @endforelse
                                </select>
                                @error('table_id')
                                    <div class="my-2 py-2 px-6 bg-rose-200 rounded-lg">
                                        <div class="alert alert-success text-sm text-rose-700">
                                            {{ $message }}
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Payment Method <span class="text-rose-500">*</span></label>
                                <ul class="grid w-full gap-4 md:grid-cols-2">
                                    <li>
                                        <input type="radio" id="cash" name="payment_method" value="cash" class="hidden peer" required />
                                        <label for="cash" class="inline-flex items-center justify-between w-full px-5 py-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:font-semibold peer-checked:border-slate-800 peer-checked:border-2 peer-checked:text-slate-800 peer-checked:bg-yellow-300 hover:text-slate-800 hover:bg-yellow-200 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                            <div class="block">
                                                Cash
                                            </div>
                                        </label>
                                    </li>
                                    
                                    {{-- <li>
                                        <input type="radio" id="midtrans" name="payment_method" value="midtrans" class="hidden peer">
                                        <label for="midtrans" class="inline-flex items-center justify-between w-full px-5 py-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:font-semibold peer-checked:border-slate-800 peer-checked:border-2 peer-checked:text-slate-800 peer-checked:bg-yellow-300 hover:text-slate-800 hover:bg-yellow-200 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <div class="block">
                                                Midtrans
                                            </div>
                                        </label>
                                    </li> --}}

                                    <li>
                                        <input type="radio" id="ipaymu" name="payment_method" value="ipaymu" class="hidden peer" required>
                                        <label for="ipaymu" class="inline-flex items-center justify-between w-full px-5 py-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:font-semibold peer-checked:border-slate-800 peer-checked:border-2 peer-checked:text-slate-800 peer-checked:bg-yellow-300 hover:text-slate-800 hover:bg-yellow-200 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <div class="block">
                                                Ipaymu
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                                @error('payment_method')
                                    <div class="my-2 py-2 px-6 bg-rose-200 rounded-lg">
                                        <div class="alert alert-success text-sm text-rose-700">
                                            {{ $message }}
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            

                        
                    </div>
                    <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-xl dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">Order summary</p>

                        <div class="space-y-4">
                            <div class="space-y-2">
                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Original price</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">Rp.{{ number_format($total_price) }}</dd>
                            </dl>

                            {{-- <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Savings</dt>
                                <dd class="text-base font-medium text-green-600">-$299.00</dd>
                            </dl> --}}

                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Tax</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">Rp.0</dd>
                            </dl>
                            </div>

                            <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                                <dd class="text-base font-bold text-gray-900 dark:text-white">Rp.{{ number_format($total_price) }}</dd>
                            </dl>
                        </div>

                        <div class="w-full inline-flex items-end relative text-lg">
                            <input type="hidden" name="total_price" value="{{ $total_price }}">
                            @if (session('cart') != null)
                                <button type="submit" class="w-full">
                                    <div class="font-semibold inline-block w-full hover:text-white bg-yellow-300 hover:bg-slate-800 transition-all rounded-lg py-3 px-5">
                                        submit
                                    </div>
                                </button>
                                {{-- <span class="absolute w-full z-0 bg-slate-800 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-slate-800">Submit</span> --}}
                            @else
                                <button disabled class="w-full">
                                    <div class="font-semibold inline-block w-full hover:text-white bg-yellow-300 hover:bg-slate-800 transition-all rounded-lg py-3 px-5">
                                        choose menu
                                    </div>
                                </button>
                                {{-- <span class="absolute w-full z-0 bg-slate-800 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-slate-800">Choose Menu</span> --}}
                            @endif
                            
                        </div>
                    </form>

                        <div class="flex items-center justify-center gap-2">
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400"> or </span>
                            <a href="{{ route('list-menu') }}" title="" class="inline-flex items-center gap-2 text-sm font-medium text-primary-700 underline hover:no-underline dark:text-primary-500">
                            Continue Shopping
                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                            </svg>
                            </a>
                        </div>
                    </div>

                    {{-- <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                        <form class="space-y-4">
                            <div>
                            <label for="voucher" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Do you have a voucher or gift card? </label>
                            <input type="text" id="voucher" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="" required />
                            </div>
                            <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Apply Code</button>
                        </form>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    {{-- <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script> --}}
    <script>
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const target = document.getElementById(button.getAttribute('data-modal-target'));
                if (target) {
                    target.classList.toggle('hidden');
                }
            });
        });

        document.querySelectorAll('[data-modal-hide]').forEach(button => {
            button.addEventListener('click', () => {
                const target = document.getElementById(button.getAttribute('data-modal-hide'));
                if (target) {
                    target.classList.add('hidden');
                }
            });
        });
    </script>
    {{-- @if (!empty($cart['selected_modifiers']))
        @foreach ($cart['selected_modifiers'] as $modifier)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var checkbox = document.getElementById('modifier-{{ $modifier->id }}-{{ $id }}');
                    if (checkbox) {
                        checkbox.addEventListener('change', function() {
                            var qtyInput = document.getElementById('modifier-qty-{{ $modifier->id }}-{{ $id }}');
                            if (this.checked) {
                                qtyInput.style.display = 'block'; // Atau 'inline-block'
                            } else {
                                qtyInput.style.display = 'none';
                                qtyInput.value = 1;
                            }
                        });
                    }
                });
            </script>
        @endforeach
    @endif --}}
    @if (!empty($cart['selected_modifiers']))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkboxes = document.querySelectorAll('.modifier-checkbox');
                
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const modifierId = this.dataset.modifierId;
                        const quantityInput = document.querySelector(`#quantity-${modifierId}-{{ $id }}`);

                        if (this.checked) {
                            quantityInput.classList.remove('hidden');
                            quantityInput.value = quantityInput.value || 1; // Set default value to 1 if empty
                        } else {
                            quantityInput.classList.add('hidden');
                            quantityInput.value = ''; // Clear value if unchecked
                        }
                    });
                });

                // Set initial state of quantity inputs based on checkbox status
                checkboxes.forEach(checkbox => {
                    const modifierId = checkbox.dataset.modifierId;
                    const quantityInput = document.querySelector(`#quantity-${modifierId}-{{ $id }}`);

                    if (checkbox.checked) {
                        quantityInput.classList.remove('hidden');
                    } else {
                        quantityInput.classList.add('hidden');
                    }
                });
            });

        </script>
    @endif

    <script>
        function toggleModifierQuantity(modifierId, itemId) {
            const checkbox = document.getElementById('modifier-' + modifierId);
            const quantityWrapper = document.getElementById('quantity-wrapper-' + modifierId + '-' + itemId);
            
            if (checkbox.checked) {
                quantityWrapper.style.display = 'block';
                document.getElementById('quantity-' + modifierId + '-' + itemId).value = 1; // Set default value to 1
            } else {
                quantityWrapper.style.display = 'none';
                document.getElementById('quantity-' + modifierId + '-' + itemId).value = ''; // Clear value
            }
        }
    </script>

@endpush