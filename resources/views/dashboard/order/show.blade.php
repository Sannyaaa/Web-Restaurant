@extends('dashboard.layout.app')

@section('title-page','Order')

@section('content')
    <!-- row 1 -->
        <div class="flex flex-wrap -mx-3">
          <!-- card1 -->
          <div class="w-full max-w-full px-8 mb-6 sm:flex-none xl:mb-0">
            <div class="relative flex flex-col break-words border-4 border-slate-800 bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-10">
                <div class="mx-auto w-full flex-none xl:max-w-7xl space-y-6">
                    <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6">
                        <div class="mt-3 mx-3">

                            <div class="flex justify-between">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white sm:text-2xl">General Information</h2>

                                <div class="gap-3 flex items-center me-10">
                                    
                                    <div class="relative">
                                        @can('isService')
                                            <form action="{{ route('order.invoice',$order->id) }}" method="GET">
                                                <div class="flex ms-auto">
                                                    <button type="submit" class=" bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 rounded-lg">Cetak</button>
                                                </div>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Invoice</h4>
                                <h2 class="text-gray-500 font-bold text-4xl dark:text-gray-400">{{$order->invoice }}</h2>
                            </div>
                            <div class="flex w-full mt-6">
                                <div class="w-1/3 space-y-4">
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Order Status</h4>
                                        <p class="w-fit py-2 px-5 rounded-lg dark:text-gray-400
                                            @if ($order->status == 'awaiting_payment')
                                                bg-yellow-100 text-yellow-700
                                            @elseif ($order->status == 'being_prepared')
                                                bg-gray-100 text-gray-700
                                            @elseif ($order->status == 'ready_for_pickup')
                                                bg-blue-100 text-blue-700
                                            @elseif ($order->status == 'delivered')
                                                bg-green-100 text-green-700
                                            @else
                                                bg-gray-100 text-gray-700
                                            @endif
                                        ">{{$order->status }}</p>
                                    </div>
                                </div>
                                <div class="w-1/3 space-y-4">
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Pemesan</h4>
                                        <p class="text-gray-500 dark:text-gray-400">Name : {{$order->name }}</p>
                                        <p class="text-gray-500 dark:text-gray-400">Phone : {{$order->phone }}</p>
                                    </div>
                                </div>
                                <div class="space-y-4 w-1/3">
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-1 sm:text-lg">Order Status</h4>
                                        @if ($order->payment_status == 'pending')
                                            <span class="bg-yellow-100 text-yellow-700 px-5 py-2 text-md rounded-lg">
                                                {{ $order->payment_status }}
                                            </span>
                                        @elseif ($order->payment_status == 'paid')
                                            <span class="bg-green-100 text-green-700 px-5 py-2 text-md rounded-lg">
                                                {{ $order->payment_status }}
                                            </span>
                                        @else
                                            <span class="bg-rose-100 text-rose-700 px-5 py-2 text-md rounded-lg">
                                                {{ $order->payment_status }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex w-full mt-4">
                                {{-- <div class="w-1/3 space-y-4">
                                    <div class="">
                                        <h4 class="text-base font-semibold mt-2 text-gray-900 dark:text-white sm:text-lg">Resi</h4>
                                        <h2 class="text-gray-500 dark:text-gray-400">{{$order->resi }}</h2>
                                    </div>
                                </div> --}}
                                <div class="space-y-4 w-1/3">
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Order Date</h4>
                                        <p class="text-gray-500 dark:text-gray-400">{{ $order->created_at->format('d F Y') }}</p>
                                    </div>
                                    <div class="">
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Table</h4>
                                        <p class="text-gray-500 dark:text-gray-400">{{ $order->table->name }}</p>
                                    </div>
                                </div>
                                <div class="space-y-4 w-1/3">
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Waiter</h4>
                                        <p class="text-gray-500 dark:text-gray-400">Name : {{$order->waiter }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Cashier</h4>
                                        <p class="text-gray-500 dark:text-gray-400">Name : {{$order->cashier }}</p>
                                    </div>
                                </div>
                                <div class="space-y-4 w-1/3">
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Payment Method</h4>
                                        <p class="text-gray-500 dark:text-gray-400">{{$order->payment_method }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Total Price</h4>
                                        <p class="text-gray-500 dark:text-gray-400">Rp. {{ number_format($order->total_price) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8">
                            <div class="flex justify-between mb-4">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white sm:text-2xl">Order Details</h2>
                                {{-- <a href="{{ route('admin.order.edit', $order->id) }}" class="text-xl font-semibold text-gray-900 hover:underline dark:text-white">
                                    Ubah Pesanan
                                </a>
                                <a href="{{ route('admin.order.delete', $order->id) }}" class="text-xl font-semibold text-red-600 hover:text-red-700 dark:text-white" onclick="return confirm('Apakah anda yakin ingin menghapus pesanan ini?')">
                                    Hapus Pesanan
                                </a> --}}
                            </div>
                            {{-- {{ dd($orderItems) }} --}}
                            @forelse ($orderItems as $item)
                                <div class="space-y-6">
                                    <div class=" border-t p-6 border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                        @if ($errors->any())
                                            <div class="bg-rose-100 text-rose-800 px-5 py-2 mb-6 rounded-lg">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-4 md:space-y-0">
                                            <a href="#" class="shrink-0 order-1 w-36 aspect-square overflow-hidden">
                                                <img class="w-full h-full object-cover object-center dark:hidden" src="{{ Storage::url($item->menu->image) }}" alt="imac image" />
                                                <img class="hidden h-20 w-20 dark:block" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg" alt="imac image" />
                                            </a>

                                            <label for="counter-input" class="sr-only">Choose quantity:</label>
                                            <div class="md:order-3">
                                                {{-- <form action="{{ route('update-item',$item->id) }}" method="POST"> --}}
                                                    @csrf
                                                    @method('POST')
                                                <div class="flex items-center justify-between md:order-3 md:justify-end">
                                                    {{-- <div class="">
                                                        <p class="text-base font-bold text-gray-900 dark:text-white">Satuan</p>
                                                        <p class="text-base font-bold text-gray-900 dark:text-white">Banyak</p>
                                                        <p class="text-base font-bold text-gray-900 dark:text-white">Total</p>
                                                    </div> --}}
                                                    <div class="text-end md:order-4 md:w-32">
                                                        <p class="text-lg font-bold text-gray-900 dark:text-white">Rp.{{ number_format($item->menu->price) }}</p>
                                                        <p class="text-lg font-bold text-gray-900 dark:text-white">x {{ number_format($item->quantity) }}</p>
                                                        <hr class="my-2 w-4/5 ml-auto">
                                                        <p class="text-xl font-bold text-gray-900 dark:text-white">Rp.{{ number_format($item->quantity*$item->menu->price) }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                                                <div>
                                                    <a href="#" class="text-xl font-semibold text-gray-900 hover:underline dark:text-white">
                                                        {{ $item->menu->name }}
                                                    </a>

                                                    <p class="mt-2 text-base font-medium text-gray-900">
                                                        {!! Str::limit($item->menu->description, 100, '...') !!}
                                                    </p>

                                                    <p class="mt-3 text-base font-semibold text-gray-900 dark:text-white">
                                                        Category : <span class="text-slate-600">{{ $item->menu->category->name }}</span>
                                                    </p>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        {{-- {{ dd($item) }} --}}
                                        @if ($item->modifiers->isNotEmpty())
                                            <div class="flex w-full justify-between max-w-3xl ms-auto">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Modifiers:</h3>
                                                    <ul class="list-disc list-inside mt-2">
                                                        @foreach ($item->modifiers as $modifier)
                                                            <li class="text-gray-600 dark:text-gray-400">
                                                                {{ $modifier->name }} (x{{ $modifier->quantity }}) 
                                                                @if ($modifier->quantity > 1)
                                                                    <span class="text-sm text-gray-500 -mt-5">
                                                                        (Rp.{{ number_format($modifier->price) }} each)
                                                                    </span>
                                                                @endif
                                                                <span class="font-semibold">+ Rp.{{ number_format($modifier->quantity * $modifier->price) }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-base font-semibold text-gray-600 dark:text-white">
                                                        Total Modifier Price: 
                                                        <br>
                                                        <span class="font-semibold text-lg text-gray-900">Rp.{{ number_format($item->total_modifier_price ) }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($item->special_instructions)
                                            <div class="w-full text-lg font-semibold text-slate-800 -mb-3 mt-3">
                                                Instruksi khusus : <span class="font-medium text-slate-600">{{ $item->special_instructions }}</span>
                                            </div>
                                        @endif
                                        
                                        @can('restore',$order)
                                            @if ($item->review == null && $order->status == 'delivered' )
                                                <form action="{{ route('review.store') }}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <div class="lg:flex items-center w-full gap-4 mt-4">
                                                        <div class="w-full lg:w-3/4 text-base font-medium">
                                                            <label for="comment">Berikan Review</label>
                                                            <div class="w-full">
                                                                <input type="text" name="comment" id="comment" class="h-10 border-4 border-slate-900 mt-1 rounded-md py-5 px-4 w-full bg-gray-50" value="" />
                                                            </div>
                                                        </div>

                                                        <div class="flex gap-4">
                                                            <div class=" text-base font-medium">
                                                                <label for="rating">Berikan Rating</label>
                                                                <div class="w-full">
                                                                    <select id="rating" name="rating" class="h-10 bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-5 px-4 mt-1">
                                                                        <option selected>Choose Rating</option>
                                                                        <option value="1" selected>1</option>
                                                                        <option value="2" selected>2</option>
                                                                        <option value="3" selected>3</option>
                                                                        <option value="4" selected>4</option>
                                                                        <option value="5" selected>5</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="inline-flex items-end relative mt-auto ms-auto">
                                                                {{-- <input type="hidden" name="total_price" value="{{ $total_price }}"> --}}
                                                                <input type="hidden" name="menu_id" value="{{ $item->menu_id }}">
                                                                <input type="hidden" name="order_item_id" value="{{ $item->id }}">
                                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                                <button type="submit" class=" bg-slate-800 hover:bg-slate-900 px-8 py-3 text-lg font-bold text-white rounded-lg">Submit</button>    
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                </form>
                                            @endif
                                        @endcan
                                    </div>
                                </div>
                            @empty
                                <span>Tidak ada pesanan</span>
                            @endforelse
                        </div>
                        <div class="mx-auto w-full flex-1 space-y-6 lg:mt-0 lg:w-full">

                            {{-- <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
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
                                    <input type="hidden" name="total_price" value="{{ $total_price }}">
                                    <button type="submit" class="z-10 w-full rounded-2xl bg-white px-6 py-2 text-lg font-bold text-slate-800 shadow-md border-8 border-slate-800 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">Submit</button>
                                    <span class="absolute w-full z-0 bg-slate-800 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-slate-800">Submit</span>
                                </div>

                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400"> or </span>
                                    <a href="{{ route('list-menu') }}" title="" class="inline-flex items-center gap-2 text-sm font-medium text-primary-700 underline hover:no-underline dark:text-primary-500">
                                    Continue Shopping
                                    <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                                    </svg>
                                    </a>
                                </div>
                            </div> --}}

                            <div class="md:col-span-5 mt-4 flex justify-between mx-4">
                                <div class="inline-flex">
                                    <a href="{{ route('order.index') }}" class=" bg-slate-800 hover:bg-slate-900 px-8 py-3 text-lg font-bold text-white rounded-lg">Back</a>
                                </div>
                                
                                @can('restore',$order)
                                    @if ($item->review == null && $order->status == 'delivered' )
                                        <div class="inline-flex items-end">
                                            <form action="{{ route('reorder') }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <div class="w-full inline-flex items-end relative">
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <button type="submit" class=" bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 rounded-lg">Reorder</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                @endcan
                            </div>

                            {{-- <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6 mt-8">
                                <p class="text-xl font-semibold text-gray-900 dark:text-white">Reorder</p>

                                <div>
                                    <p class="text-base font-normal text-gray-500 dark:text-gray-400">Kamu ingin order lagi dengan menu yang sama?</p>
                                </div>
                                
                                <form action="{{ route('reorder') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="w-full inline-flex items-end relative">
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <button type="submit" class="z-10 w-full rounded-2xl bg-white px-6 py-2 text-lg font-bold text-slate-800 shadow-md border-8 border-slate-800 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">Reorder</button>
                                        <span class="absolute w-full z-0 bg-slate-800 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-slate-800">Reorder</span>
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
                            </div> --}}

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
              </div>
            </div>
          </div>
        </div>

@endsection
