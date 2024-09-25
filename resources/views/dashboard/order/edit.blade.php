@extends('dashboard.layout.app')

@section('title-page','Order')

@section('content')
    <!-- row 1 -->
        <div class="flex flex-wrap -mx-3">
          <!-- card1 -->
          <div class="w-full max-w-full px-8 mb-6 sm:flex-none xl:mb-0">
            <div class="relative flex flex-col min-w-0 break-words border-4 border-slate-800 bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-10">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-full max-w-full px-3">
                    <div class="mb-4 flex justify-between">
                      
                        <div class="px-6">
                            <h3 class="text-4xl font-black text-slate-800 dark:text-white">
                                EDIT ORDER
                            </h3>
                        </div>

                        
                    </div>
                    
                    <div class="mt-3 px-6">
                        {{-- <div class="flex justify-between">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white sm:text-2xl">General Information</h2>

                            <div class="gap-3 flex items-center">
                                @if ($order->payment_status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-5 py-2 uppercase text-md font-semibold rounded-lg">
                                        {{ $order->payment_status }}
                                    </span>
                                    <a href="{{ $order->invoice }}" class="text-xl font-semibold text-gray-900 hover:underline dark:text-white me-8">
                                        Bayar
                                    </a>
                                @elseif ($order->payment_status == 'paid')
                                    <span class="bg-blue-100 text-blue-700 px-5 py-2 uppercase text-md font-semibold rounded-lg">
                                        {{ $order->payment_status }}
                                    </span>
                                    <a href="{{ $order->invoice }}" class="text-xl font-semibold text-gray-900 hover:underline dark:text-white me-8">
                                        Lihat URL
                                    </a>
                                @else
                                    <span class="bg-rose-100 text-rose-700 px-5 py-2 uppercase text-md font-semibold rounded-lg">
                                        {{ $order->payment_status }}
                                    </span>
                                    <a href="{{ $order->invoice }}" class="text-xl font-semibold text-gray-900 hover:underline dark:text-white me-8">
                                        Lihat URL
                                    </a>
                                @endif
                            </div>
                        </div> --}}
                        <form action="{{ route('order.update',$order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="flex w-full mt-6">
                                <div class="w-1/3 space-y-4">
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Invoice</h4>
                                        <h2 class="text-gray-500 font-bold text-3xl dark:text-gray-400">{{$order->invoice }}</h2>
                                        {{-- <h4 class="text-base font-semibold mt-2 text-gray-900 dark:text-white sm:text-lg">Resi</h4>
                                        <h2 class="text-gray-500 dark:text-gray-400">{{$order->resi }}</h2> --}}
                                    </div>

                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Pemesan</h4>
                                        <p class="text-gray-500 dark:text-gray-400">Name : {{$order->name }}</p>
                                        <p class="text-gray-500 dark:text-gray-400">Phone : {{$order->phone }}</p>
                                    </div>
                                </div>
                                <div class="w-1/3 space-y-4">
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Order Status</h4>
                                        <p class="text-gray-500 dark:text-gray-400">{{$order->status }}</p>
                                    </div>

                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white sm:text-lg">Payment Status</h4>
                                        <p class="text-gray-500 dark:text-gray-400">{{$order->payment_status }}</p>
                                    </div>
                                </div>
                                <div class="space-y-4 w-1/3">
                                    <div class="">
                                        <label for="status" class="text-slate-800">edit status :</label>
                                        <div class=" text-base font-medium">
                                            <div class="w-full">
                                                <select id="status" name="status" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg h-14 w-64 mt-1 focus:ring-slate-500 focus:border-slate-500 block px-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500">
                                                    <option>Choose status</option>
                                                    @if ($order->status == 'out_for_delivery')
                                                        <option value="out_for_delivery" selected>Out For Delivery</option>
                                                        <option value="delivered">delivered</option>
                                                    @elseif ($order->status == 'awaiting_payment')
                                                        <option value="awaiting_payment" selected>Awaiting Payment</option>
                                                        <option value="being_prepared">being prepared</option>
                                                    @elseif ($order->status == 'delivered')
                                                        <option selected value="delivered">Delivered</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="">
                                        <label for="status" class="text-slate-800">edit payment status :</label>
                                        <div class=" text-base font-medium">
                                            <div class="w-full">
                                                <select id="payment_status" name="payment_status" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg h-14 w-64 mt-1 focus:ring-slate-500 focus:border-slate-500 block px-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500">
                                                    <option selected>Choose status</option>
                                                    @if ($order->payment_status == 'pending')
                                                        <option value="pending" selected>Pending</option>
                                                        <option value="paid">paid</option>
                                                    @elseif ($order->payment_status == 'paid')
                                                        <option selected>Paid</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="md:col-span-5 mt-4 flex justify-between mx-4">
                                <div class="inline-flex">
                                    <a href="{{ route('order.index') }}" class=" bg-slate-800 hover:bg-slate-900 px-8 py-3 text-lg font-bold text-white rounded-lg">Back</a>
                                </div>
                                <div class="inline-flex items-end me-32">
                                    <button type="submit" class=" bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 rounded-lg">Submit</button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection
