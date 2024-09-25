@extends('dashboard.layout.app')

@section('title-page','Kitchen')

@section('content')
    <!-- row 1 -->
        <div class="flex flex-wrap -mx-3">
          <!-- card1 -->
          <div class="w-full max-w-full px-8 mb-6 sm:flex-none xl:mb-0">
            <div class="relative flex flex-col min-w-0 break-words border-4 border-slate-800 bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-10">
                <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-7xl space-y-6">
                    <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6">
                        <div class="mt-3 px-6">

                            <div class="flex justify-between">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white sm:text-2xl">General Information</h2>

                                <div class="gap-3 flex items-center">
                                    @if ($order->payment_status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-5 py-2 uppercase text-md font-semibold rounded-lg">
                                            {{ $order->payment_status }}
                                        </span>
                                    @elseif ($order->payment_status == 'paid')
                                        <span class="bg-blue-100 text-blue-700 px-5 py-2 uppercase text-md font-semibold rounded-lg">
                                            {{ $order->payment_status }}
                                        </span>
                                    @else
                                        <span class="bg-rose-100 text-rose-700 px-5 py-2 uppercase text-md font-semibold rounded-lg">
                                            {{ $order->payment_status }}
                                        </span>
                                    @endif
                                    <div class="relative">
                                        @can('isService')
                                            <form action="{{ route('kitchen.invoice',$order->id) }}" method="GET">
                                                <div class="flex ms-auto">
                                                     <button type="submit" class="bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 rounded-lg">
                                                        Cetak
                                                     </button>
                                                </div>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                            <div class="flex w-full mt-6">
                                <div class="w-1/3 space-y-4">
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Invoice</h4>
                                        <h2 class="text-gray-500 font-bold text-4xl dark:text-gray-400">{{$order->invoice }}</h2>
                                        {{-- <h4 class="text-base font-semibold mt-2 text-gray-900 dark:text-white sm:text-lg">Resi</h4>
                                        <h2 class="text-gray-500 dark:text-gray-400">{{$order->resi }}</h2> --}}
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
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Table Name</h4>
                                        <p class="text-gray-500 dark:text-gray-400">{{$order->table->name }}</p>
                                        
                                        <h4 class="text-base font-semibold mt-3 text-gray-900 dark:text-white sm:text-lg">Tanggal Pesan</h4>
                                        <p class="text-gray-500 dark:text-gray-400">{{ $order->created_at->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex w-full mt-4">
                                <div class="w-1/3 space-y-4">
                                    <div class="">
                                    </div>
                                </div>
                                <div class="w-1/3 space-y-4">
                                    <div class="">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="mt-8 px-6">
                            <div class="flex justify-between mb-4">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white sm:text-2xl">Order Items</h2>
                                {{-- <a href="{{ route('admin.order.edit', $order->id) }}" class="text-xl font-semibold text-gray-900 hover:underline dark:text-white">
                                    Ubah Pesanan
                                </a>
                                <a href="{{ route('admin.order.delete', $order->id) }}" class="text-xl font-semibold text-red-600 hover:text-red-700 dark:text-white" onclick="return confirm('Apakah anda yakin ingin menghapus pesanan ini?')">
                                    Hapus Pesanan
                                </a> --}}
                            </div>

                            <form action="{{ route('kitchen-update',$order) }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="grid grid-cols-1 md:grid-cols-2 w-full border-t pt-6 gap-3">
                                    @forelse ($orderItems as $id => $item)

                                        <div class="flex border items-center ps-6 border-gray-200 rounded dark:border-gray-700">
                                            <input id="bordered-checkbox-{{ $id }}" type="checkbox" value="" name="bordered-checkbox" class="order-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="bordered-checkbox-{{ $id }}" class="w-full ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                <div class="space-y-6">
                                                    <div class=" p-6 border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                                        @if ($errors->any())
                                                            <div class="bg-rose-100 text-rose-800 px-5 py-2 mb-6 rounded-lg">
                                                                <ul>
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                        <div class="w-full">
                                                            @if (session('success'))
                                                                <div class="w-1/2 mx-auto py-2 rounded-md -mt-6 mb-4 text-center bg-green-100 text-green-900 text-base border-green-900 border-2">
                                                                    {{ session('success') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                                                            <div class="text-end md:order-4 md:w-32">
                                                                <p class="text-lg font-bold text-gray-900 dark:text-white">x {{ number_format($item->quantity) }}</p>
                                                            </div>

                                                            <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                                                                <div>
                                                                    <a href="#" class="text-xl font-semibold text-gray-900 hover:underline dark:text-white">
                                                                        {{ $item->menu->name }}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if ($item->modifiers->isNotEmpty())
                                                            <div class="flex">
                                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Modifiers:</h3>
                                                                <ul class="list-disc list-inside ms-2 mt-1">
                                                                    @foreach ($item->modifiers as $modifier)
                                                                        <li class="text-gray-600 dark:text-gray-400">
                                                                            {{ $modifier->name }} (x{{ $modifier->quantity }})
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                        @if ($item->special_instructions != null)
                                                            <div class="w-full text-base font-semibold -mb-2 mt-2">
                                                                Instruksi khusus : <span class="font-medium text-slate-600">{{ $item->special_instructions }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    
                                        
                                    @empty
                                        <span>Tidak ada pesanan</span>
                                    @endforelse
                                    
                                </div>
                                <div class="flex items-center justify-end w-full my-6">
                                    <div class="flex">
                                        <button id="submit-btn" disabled class="bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 rounded-lg">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- <div class="mx-auto max-w-lg flex-1 space-y-6 lg:mt-6 lg:w-full">

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
                            </div>

                            <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
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
              </div>
            </div>
          </div>
        </div>

@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.order-checkbox');
            const submitBtn = document.getElementById('submit-btn');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    checkAllChecked();
                });
            });

            function checkAllChecked() {
                const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
                submitBtn.disabled = !allChecked;
            }
        });
    </script>
@endpush
