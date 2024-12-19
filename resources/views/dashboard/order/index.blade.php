@extends('dashboard.layout.app')

@section('title-page','Order')

@push('style')
    <style>
        /* Contoh CSS untuk mengubah tampilan tabel DataTables */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5em 1em;
            margin: 0.2em;
            border-radius: 0.25em;
            border: 2px solid #ddd;
            background-color: #f9f9f9;
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #007bff;
            color: white;
            border-radius: 0.5em;
            border: 2px solid #1e293b;
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 0.5em;
            padding: 0.4em;
            border: 4px solid #1e293b;
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_info {
            margin-top: 1em;
        }

        .dataTables_wrapper .dataTables_length select {
            border-radius: 0.5em;
            padding: 0.5em;
            width: 5rem;
            border: 4px solid #1e293b;
        }
    </style>
@endpush

@section('content')
    <!-- row 1 -->
        <div class="flex flex-wrap -mx-3">
          <!-- card1 -->
          <div class="w-full max-w-full px-8 mb-6 sm:flex-none xl:mb-0">
            <div class="relative flex flex-col min-w-0 break-words border-4 border-slate-800 bg-white shadow-md dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-10">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-full max-w-full px-3">
                    <div class="inline-block sm:flex justify-between">
                      
                    <div>
                        <h3 class="mb-2 text-3xl font-bold text-slate-900 dark:text-white">
                            ORDER
                        </h3>
                        <p class="mb-0 dark:text-white text-slate-900 dark:opacity-60">
                            <span class="text-sm font-bold leading-normal text-slate-700"></span>
                            Order List
                        </p>
                    </div>

                      <div class="flex gap-5">
                        <div class="md:flex items-center justify-between w-full gap-4 mb-4">
                            <div class="flex justify-end gap-5 ms-auto">
                                @can('orderAccess')
                                    <div class="flex relative h-auto">
                                        {{-- <input type="hidden" name="total_price" value="{{ $total_price }}"> --}}
                                        <!-- Trigger Button -->
                                        <button type="button" class="w-full h-fit mt-auto rounded-lg bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 shadow-md transition-all" onclick="toggleModal('myModal')">
                                            Export
                                        </button>
                                        {{-- <a href="{{ route('export-order') }}" class="w-full rounded-lg text-white bg-slate-800 hover:bg-slate-900 px-8 py-3 text-lg font-bold shadow-md ">Excel</a> --}}
                                    </div>
                                @endcan
                            </div>
                        </div>
                        @can('isAdmin')
                            <div>
                                <form action="{{ route('import-order') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <button type="button" id="chooseFileButton" class="w-full whitespace-nowrap rounded-lg text-white bg-slate-800 hover:bg-slate-900 px-8 py-3 text-lg font-bold shadow-md transition-all">
                                            Import
                                        </button>
                                        <input type="file" name="file" id="file" class="hidden" required onchange="this.form.submit()">
                                    </div>
                                </form>
                            </div>
                        @endcan
                      </div>
                    </div>

                    <div class="w-full flex justify-end">
                        <div class="flex gap-5">
                            <div class=" text-sm font-medium">
                                <label for="status">Filter by status</label>
                                <div class="max-w-64">
                                    <select id="status" name="status" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">ALL</option>
                                        <option value="awaiting_payment">Awaiting Payment</option>
                                        <option value="being_prepared">Being Prepared</option>
                                        <option value="out_for_delivery">Out For Delivery</option>
                                        <option value="delivered">Delivered</option>
                                    </select>
                                </div>
                            </div>

                            <div class=" text-sm font-medium">
                                <label for="payment_method">Filter by Payment Method</label>
                                <div class="max-w-64">
                                    <select id="payment_method" name="payment_method" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">ALL</option>
                                        <option value="ipaymu">Ipaymu</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>
                            </div>

                            <div class=" text-sm font-medium">
                                <label for="payment_status">Filter by Payment Status</label>
                                <div class="max-w-64">
                                    <select id="payment_status" name="payment_status" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">ALL</option>
                                        <option value="pending">Pending</option>
                                        <option value="paid">Paid</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex relative">
                                {{-- <input type="hidden" name="total_price" value="{{ $total_price }}"> --}}
                                <button id="filter" class="w-full h-fit mt-auto rounded-lg bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 shadow-md transition-all">Filter</button>
                            </div>
                        </div>
                    </div>
                    
                    <form id="bulk-action-form" action="{{ route('bulk.action') }}" method="POST">
                        @csrf
                        <div class="relative overflow-x-auto mt-5">
                            <div  id="bulk-action-buttons-1" class="hidden flex space-x-3 mb-2">
                                <select id="status" name="bulk_action_status" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="awaiting_payment">Awaiting Payment</option>
                                    <option value="being_prepared">Being Prepared</option>
                                    <option value="out_for_delivery">Out For Delivery</option>
                                    <option value="delivered">Delivered</option>
                                </select>
                                <select id="payment_status" name="bulk_action_payment_status" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" disabled selected>Select Payment</option>
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                <button type="submit" name="bulk_action" value="edit" class="rounded-lg text-slate-800 bg-yellow-300 hover:bg-yellow-400 px-4 py-2 text-base font-bold shadow-md">
                                    <i class="fa-solid fa-edit"></i>
                                    <span>Update Selected</span>
                                </button>
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" name="bulk_action" value="delete" class="rounded-lg text-white bg-slate-800 hover:bg-slate-900 ms-3 px-4 py-2 text-base font-bold shadow-md">
                                    <i class="fa-solid fa-trash"></i>
                                    <span>Delete Selected</span>
                                </button>
                            </div>
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="dataTables">
                                <thead class="text-md text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                    <tr class=" whitespace-nowrap">
                                        <th scope="col" class="px-6 py-2">
                                            @can('orderAccess')
                                                <div class="flex">
                                                    <input type="checkbox" id="select-all">
                                                    {{-- <button type="submit" class=" rounded-lg text-white bg-slate-800 hover:bg-slate-900 ms-3 px-4 py-2 text-base font-bold shadow-md"><i class="fa-solid fa-trash"></i></button> --}}
                                                </div>
                                            @endcan
                                        </th>
                                        <th scope="col" class="px-6 py-2">
                                            No
                                        </th>
                                        <th scope="col" class="px-6 py-2">
                                            Order Date
                                        </th>
                                        <th scope="col" class="px-6 py-2">
                                            Invoice
                                        </th>
                                        <th scope="col" class="px-6 py-2">
                                            Total Price
                                        </th>
                                        <th scope="col" class="px-6 py-2">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-2">
                                            Payment
                                        </th>
                                        <th scope="col" class="px-6 py-2">
                                            Payment Status
                                        </th>
                                        <th scope="col" class="px-6 py-2">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="whitespace-nowrap">
                                    {{-- @forelse ($orders as $order)
                                        @can('view',$order)
                                            <tr class="bg-white border-b text-base dark:bg-gray-800 dark:border-gray-700">
                                                <th scope="row" class="px-4 py-4 font-lg text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{$order->created_at->format('d F Y')}}
                                                </th>
                                                <td class="px-4 py-4">
                                                    {{ $order->invoice }}
                                                </td>
                                                <td class="px-4 py-4">
                                                    Rp.{{ number_format($order->total_price) }}
                                                </td>
                                                <td class="px-4 py-4">
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
                                                        {{ $order->status }}
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4">
                                                    {{ $order->payment_method }}
                                                </td>
                                                <td class="px-4 py-4">
                                                    <div class="py-2 px-4 rounded-lg w-fit
                                                        @if ($order->payment_status == 'pending')
                                                            bg-yellow-100 text-yellow-700
                                                        @elseif ($order->payment_status == 'paid')
                                                            bg-green-100 text-green-700
                                                        @elseif ($order->payment_status == 'cancelled')
                                                            bg-rose-100 text-rose-700
                                                        @else
                                                            bg-gray-100 text-gray-700
                                                        @endif
                                                    ">
                                                        {{ $order->payment_status }}
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 flex gap-3">
                                                    <div class="flex items-center">
                                                        <a href="{{ route('order.edit', $order->id ) }}" class="z-10 rounded-2xl bg-white px-6 py-2 text-lg font-bold text-slate-800 border-8 border-blue-700 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">Detail</a>
                                                        <a class="absolute z-0 bg-blue-700 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-blue-700">Detail</a>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <a href="{{ route('order.show', $order->id ) }}" class="z-10 rounded-2xl bg-white px-6 py-2 text-lg font-bold text-slate-800 border-8 border-green-700 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">Edit</a>
                                                        <a class="absolute z-0 bg-green-700 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-green-700">Edit</a>
                                                    </div>
                                                    <form action="{{ route('order.destroy', $order->id ) }}" method="POST"  onsubmit="return confirm('yakin mau hapus?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="flex items-center">
                                                            <button type="submit" class="z-10 rounded-2xl bg-white px-6 py-2 text-lg font-bold text-slate-800 border-8 border-rose-700 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">Delete</button>
                                                            <a class="absolute z-0 bg-rose-700 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-rose-700">Delete</a>
                                                        </div>
                                                    </form>
                                                        @can('update',$order)
                                                            <a href="{{ route('order.edit', $order->id ) }}" class="font-lg text-green-600 dark:text-green-500 hover:underline">Edit</a>
                                                        @endcan
                                                        <a href="{{ route('order.show', $order->id ) }}" class="font-lg text-blue-600 dark:text-blue-500 hover:underline">Show</a>
                                                        @can('delete',$order)
                                                            <form action="{{ route('order.destroy', $order->id ) }}" method="POST">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button type="submit" class="font-lg text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                                            </form>
                                                        @endcan
                                                </td>
                                            </tr>
                                        @endcan
                                    @empty
                                        <span>Belum ada menu di keranjangmu</span>
                                    @endforelse --}}
                                </tbody>
                            </table>
                            <div  id="bulk-action-buttons-2" class="hidden flex space-x-3 mb-2">
                                <select id="status" name="bulk_action_status" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="awaiting_payment">Awaiting Payment</option>
                                    <option value="being_prepared">Being Prepared</option>
                                    <option value="out_for_delivery">Out For Delivery</option>
                                    <option value="delivered">Delivered</option>
                                </select>
                                <select id="payment_status" name="bulk_action_payment_status" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" disabled selected>Select Payment</option>
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                <button type="submit" name="bulk_action" value="edit" class="rounded-lg text-slate-800 bg-yellow-300 hover:bg-yellow-400 px-4 py-2 text-base font-bold shadow-md">
                                    <i class="fa-solid fa-edit"></i>
                                    <span>Update Selected</span>
                                </button>
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" name="bulk_action" value="delete" class="rounded-lg text-white bg-slate-800 hover:bg-slate-900 ms-3 px-4 py-2 text-base font-bold shadow-md">
                                    <i class="fa-solid fa-trash"></i>
                                    <span>Delete Selected</span>
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

        <!-- Main modal -->
        <!-- Modal Background -->
        <div id="myModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center h-screen justify-center z-50 hidden">
            <!-- Modal Container -->
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md md:max-w-lg lg:max-w-2xl mx-4 md:mx-auto modal-transition">
                <!-- Modal Header -->
                <div class="flex justify-between items-center border-b px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-800">Filter Export Excel</h3>
                    <button class="text-gray-400 hover:text-gray-600 focus:outline-none" onclick="toggleModal('myModal')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('export-order') }}" method="POST">
                    @csrf
                    @method('POST')
                    <!-- Modal Body -->
                    <div class="p-6 grid grid-cols-2 gap-4 w-full">
                        <div class=" text-sm font-medium">
                            <label for="status">Search by status</label>
                            <div class="">
                                <select id="status" name="status" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">ALL</option>
                                    <option value="awaiting_payment">Awaiting Payment</option>
                                    <option value="out_for_delivery">Out For Delivery</option>
                                    <option value="delivered">Delivered</option>
                                </select>
                            </div>
                        </div>

                        <div class=" text-sm font-medium">
                            <label for="payment_method">Search by Payment Method</label>
                            <div class="">
                                <select id="payment_method" name="payment_method" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">ALL</option>
                                    <option value="ipaymu">Ipaymu</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>
                        </div>

                        <div class=" text-sm font-medium">
                            <label for="payment_status">Search by Payment Status</label>
                            <div class="">
                                <select id="payment_status" name="payment_status" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">ALL</option>
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>

                        {{-- <div class=" text-sm font-medium">
                            <label for="month" class="block text-sm font-medium text-gray-700">Select Month</label>
                            <select id="month" name="month" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value=""></option>
                                @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                    </div>
                    <!-- Modal Footer -->
                    <div class="flex justify-between items-center border-t px-6 py-4 space-x-2">
                        <button type="button" class="rounded-lg text-white bg-slate-800 hover:bg-slate-900 px-8 py-3 text-lg font-bold shadow-md" onclick="toggleModal('myModal')">
                            Cancel
                        </button>
                        <button type="submit" class=" rounded-lg bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 shadow-md transition-all">
                            Export
                        </button>
                    </div>
                </form>
            </div>
        </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            var datatable = $('#dataTables').DataTable({
                order: [[ 2, 'desc' ]], // Menggunakan kolom 'created_at' sebagai urutan default
                processing: true,
                serverSide: true,
                ordering: true,
                ajax: {
                    url: '{!! url()->current() !!}',
                    // url: 'https://cfe4-139-192-144-244.ngrok-free.app/dashboard/order',
                    data: function (d) {
                        d.status = $('#status').val();
                        d.payment_method = $('#payment_method').val();
                        d.payment_status = $('#payment_status').val();
                    }
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false, width: '5%' },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'created_at', name: 'created_at' }, // Pastikan ini diurutkan
                    { data: 'invoice', name: 'invoice' },
                    { data: 'total_price', name: 'total_price' },
                    { data:'status', name:'status' },
                    { data:'payment_method', name:'payment_method' },
                    { data:'payment_status', name:'payment_status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '15%' },
                ]
            });
            
            $('#filter').click(function() {
                datatable.draw();
            });

            // Handle "Select All" checkbox
            $('#select-all').on('click', function() {
                var rows = datatable.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
                toggleBulkActionButtons();
            });

            // Handle single checkbox click
            $('#dataTables tbody').on('change', 'input[type="checkbox"]', function() {
                var el = $('#select-all').get(0);
                if (!this.checked && el && el.checked && ('indeterminate' in el)) {
                    el.indeterminate = true;
                }
                toggleBulkActionButtons();
            });

            // Toggle visibility of bulk action buttons
            function toggleBulkActionButtons() {
                var selectedCheckboxes = $('#dataTables tbody input[type="checkbox"]:checked').length;
                if (selectedCheckboxes > 0) {
                    $('#bulk-action-buttons-1').removeClass('hidden');
                    $('#bulk-action-buttons-2').removeClass('hidden');
                } else {
                    $('#bulk-action-buttons-1').addClass('hidden');
                    $('#bulk-action-buttons-2').addClass('hidden');
                }
            }

            toggleBulkActionButtons(); // Initialize visibility on page load

            // Menggunakan event delegation untuk menangani perubahan dropdown status
            $('#dataTables').on('change', '.status-dropdown', function() {
                var orderId = $(this).data('id');
                var newStatus = $(this).val();

                console.log('Order ID:', orderId, 'New Status:', newStatus);

                $.ajax({
                    url: '/dashboard/order-update', // URL untuk route update status
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Token CSRF
                        id: orderId,
                        status: newStatus
                    },
                    success: function(response) {
                        if(response.success) {
                            datatable.draw(false); // Menggunakan datatable instance untuk refresh data tanpa reload page
                            alert('Status updated successfully!');
                        } else {
                            alert('Failed to update status.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('An error occurred while updating status.');
                    }
                });
            });

            // Menggunakan event delegation untuk menangani perubahan dropdown payment status
            $('#dataTables').on('change', '.payment-status-dropdown', function() {
                var orderId = $(this).data('id');
                var newPaymentStatus = $(this).val();

                console.log('Order ID:', orderId, 'New Status:', newPaymentStatus);

                $.ajax({
                    url: '/dashboard/order-update', // URL untuk route update payment status
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Token CSRF
                        id: orderId,
                        paymentStatus: newPaymentStatus
                    },
                    success: function(response) {
                        if(response.success) {
                            datatable.draw(false); // Menggunakan datatable instance untuk refresh data tanpa reload page
                            alert('Status updated successfully!');
                        } else {
                            alert('Failed to update status.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('An error occurred while updating status.');
                    }
                });
            });
        });
    </script>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }
    </script>

    <script>
        document.getElementById('chooseFileButton').addEventListener('click', function() {
            document.getElementById('file').click();
        });
    </script>
@endpush
