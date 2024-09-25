@extends('frontend.layout.app')

@push('style')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css"  rel="stylesheet" />
@endpush

@section('content')
    <section class="bg-white my-24 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">My Orders</h2>

            <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                <div class="mx-auto w-full flex-none lg:max-w-4xl xl:max-w-7xl space-y-6">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-lg text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-5">
                                        Order Date
                                    </th>
                                    <th scope="col" class="px-6 py-5">
                                        Total Price
                                    </th>
                                    <th scope="col" class="px-6 py-5">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-5">
                                        Payment
                                    </th>
                                    <th scope="col" class="px-6 py-5">
                                        Payment Status
                                    </th>
                                    <th scope="col" class="px-6 py-5">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr class="bg-white border-b text-base dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-lg text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$order->created_at->format('d F Y')}}
                                        </th>
                                        <td class="px-6 py-4">
                                            Rp.{{ number_format($order->total_price) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="py-2 px-4 rounded-lg w-fit
                                                @if ($order->status == 'in_process')
                                                    bg-yellow-100 text-yellow-700
                                                @elseif ($order->status == 'being_prepared')
                                                    bg-blue-100 text-blue-700
                                                @elseif ($order->status == 'ready_for_pickup')
                                                    bg-green-100 text-green-700
                                                @else
                                                    bg-gray-100 text-gray-700
                                                @endif
                                            ">
                                                {{ $order->status }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $order->payment_method }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="py-2 px-4 rounded-lg w-fit
                                                @if ($order->payment_status == 'pending')
                                                    bg-yellow-100 text-yellow-700
                                                @elseif ($order->payment_status == 'paid')
                                                    bg-blue-100 text-blue-700
                                                @elseif ($order->payment_status == 'cancelled')
                                                    bg-rose-100 text-rose-700
                                                @else
                                                    bg-gray-100 text-gray-700
                                                @endif
                                            ">
                                                {{ $order->payment_status }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 space-x-2">
                                            @if ($order->payment_status == 'pending')
                                                <a href="{{ $order->payment_url }}" class="font-lg text-blue-600 dark:text-blue-500 hover:underline">Bayar</a>
                                            @endif
                                                <a href="{{ route('order.show', $order->id ) }}" class="font-lg text-blue-600 dark:text-blue-500 hover:underline">Show</a>
                                        </td>
                                    </tr>
                                @empty
                                    <span>Belum ada menu di keranjangmu</span>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="xl:mt-16 xl:block">
                        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">People also bought</h3>
                        <div class="grid grid-cols-3 gap-4 sm:mt-8">
                            <div class="space-y-6 overflow-hidden rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                                <a href="#" class="overflow-hidden rounded">
                                    <img class="mx-auto h-44 w-44 dark:hidden" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front.svg" alt="imac image" />
                                    <img class="mx-auto hidden h-44 w-44 dark:block" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg" alt="imac image" />
                                </a>
                                <div>
                                    <a href="#" class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white">iMac 27”</a>
                                    <p class="mt-2 text-base font-normal text-gray-500 dark:text-gray-400">This generation has some improvements, including a longer continuous battery life.</p>
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">
                                    <span class="line-through"> $399,99 </span>
                                    </p>
                                    <p class="text-lg font-bold leading-tight text-red-600 dark:text-red-500">$299</p>
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
                                    <button type="button" class="inline-flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium  text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                    <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7h-1M8 7h-.688M13 5v4m-2-2h4" />
                                    </svg>
                                    Add to cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="mx-auto max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
                    <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                        <form class="space-y-4" action="{{ route('checkout') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="max-w-sm mx-auto">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select table</label>
                                <select id="countries" name="table_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Choose Table</option>
                                    
                                </select>
                            </div>
                            <div class="max-w-sm mx-auto">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Payment Method</label>
                                <ul class="grid w-full gap-4 md:grid-cols-2">
                                    <li>
                                        <input type="radio" id="cash" name="payment_method" value="cash" class="hidden peer" required />
                                        <label for="cash" class="inline-flex items-center justify-between w-full px-5 py-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                            <div class="block">
                                                Cash
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="midtrans" name="payment_method" value="midtrans" class="hidden peer">
                                        <label for="midtrans" class="inline-flex items-center justify-between w-full px-5 py-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <div class="block">
                                                Midtrans
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="ipaymu" name="payment_method" value="ipaymu" class="hidden peer">
                                        <label for="ipaymu" class="inline-flex items-center justify-between w-full px-5 py-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <div class="block">
                                                Ipaymu
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        
                    </div>
                    <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">Order summary</p>

                        <div class="space-y-4">
                            <div class="space-y-2">
                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Original price</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">Rp.{{ number_format($total_price) }}</dd>
                            </dl>

                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Savings</dt>
                                <dd class="text-base font-medium text-green-600">-$299.00</dd>
                            </dl>

                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Tax</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">Rp.5,000</dd>
                            </dl>
                            </div>

                            <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                            <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                            <dd class="text-base font-bold text-gray-900 dark:text-white">Rp.{{ number_format($total_price+5000) }}</dd>
                            </dl>
                        </div>

                        <div class="w-full inline-flex items-end relative">
                            <button type="submit" class="z-10 w-full rounded-2xl bg-white px-6 py-2 text-lg font-bold text-slate-800 shadow-md border-8 border-slate-800 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">Submit</button>
                            <span class="absolute w-full z-0 bg-slate-800 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-slate-800">Submit</span>
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

                    <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                        <form class="space-y-4">
                            <div>
                            <label for="voucher" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Do you have a voucher or gift card? </label>
                            <input type="text" id="voucher" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="" required />
                            </div>
                            <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Apply Code</button>
                        </form>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
@endpush