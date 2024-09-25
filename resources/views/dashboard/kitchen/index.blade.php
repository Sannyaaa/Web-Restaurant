@extends('dashboard.layout.app')

@section('title-page','Kitchen')

@section('content')
    <!-- row 1 -->
        <div class="flex flex-wrap -mx-3">
          <!-- card1 -->
          <div class="w-full max-w-full px-8 mb-6 sm:flex-none xl:mb-0">
            <div class="relative flex flex-col min-w-0 break-words border-4 border-slate-800 bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-10">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-full max-w-full px-3">
                    <div class="mb-8 flex justify-between">
                      
                      <div>
                        <h3 class="mb-2 text-3xl font-bold text-slate-800 dark:text-white">
                            ORDER ITEMS
                        </h3>
                        <p class="mb-0 dark:text-white text-slate-800 dark:opacity-60">
                            <span class="text-sm font-bold leading-normal text-slate-700"></span>
                            All Order
                        </p>
                      </div>

                      <div>
                        @if ($orders->isEmpty())
                            <div id="alert" class="flex items-center justify-between py-4 px-6 mb-4 text-base font-semibold  bg-yellow-100 text-slate-700 rounded-lg" role="alert">
                                <span class="mr-3">Tidak ada pesanan yang harus kamu buat</span>
                                <button type="button" class="text-slate-500 hover:text-slate-900 focus:outline-none" onclick="dismissAlert()">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                        {{-- <div class="flex items-center gap-x-6">
                            <a href="{{ route('menu.create') }}" class="z-10 rounded-2xl bg-white px-6 py-3 text-lg font-bold text-slate-800 shadow-md border-8 border-slate-800 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">New Menu</a>
                            <a class="absolute z-0 bg-slate-800 rounded-2xl px-6 py-3 text-lg font-semibold text-slate-800 shadow-md border-8 border-slate-800">New Menu</a>
                        </div> --}}
                      </div>

                    </div>
                    
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-md text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-5">
                                        Order Date
                                    </th>
                                    <th scope="col" class="px-6 py-5">
                                        Invoice
                                    </th>
                                    <th scope="col" class="px-6 py-5">
                                        Total Price
                                    </th>
                                    <th scope="col" class="px-6 py-5">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-5">
                                        Total Items
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
                                            {{ $order->invoice }}
                                        </td>
                                        <td class="px-6 py-4">
                                            Rp.{{ number_format($order->total_price) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="py-2 px-4 rounded-lg w-fit
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
                                            ">
                                                {{ $order->status == 'being_prepared' ? 'Sedang Dibuat' : '' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $total_items = 0;

                                                foreach ($order->items as $key => $value) {
                                                    $total_items += $value->quantity;
                                                }
                                            @endphp
                                            {{ $total_items }} Items
                                        </td>
                                        <td class="px-6 py-4 space-x-2">
                                            {{-- @if ($order->payment_status == 'pending')
                                                <a href="{{ $order->payment_url }}" class="font-lg text-blue-600 dark:text-blue-500 hover:underline">Bayar</a>
                                            @endif --}}
                                            <a href="{{ route('print.kitchen', $order->id ) }}" target="_blank" class="font-lg text-slate-600 dark:text-slate-500 hover:underline">Cetak</a>
                                            <a href="{{ route('kitchen-edit', ['order_item' => $order->items,'order' => $order] ) }}" class="font-lg text-blue-600 dark:text-blue-500 hover:underline">Show</a>    
                                        </td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection

@push('script')
    <script>
        function dismissAlert() {
            document.getElementById('alert').style.display = 'none';
        }
    </script>
@endpush
