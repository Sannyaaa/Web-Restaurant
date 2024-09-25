@extends('dashboard.layout.app')

@section('title-page','Feedback')

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
            <div class="relative flex flex-col min-w-0 break-words border-4 border-slate-800 bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-10">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-full max-w-full px-3">
                    <div class="flex justify-between">
                      
                      <div>
                        <h3 class="mb-2 text-3xl font-bold text-slate-700 dark:text-white">
                            FEEDBACK
                        </h3>
                        <p class="mb-0 dark:text-white dark:opacity-60">
                            <span class="text-sm font-bold leading-normal text-slate-700"></span>
                            Feedback List
                        </p>

                        {{-- @foreach ($mostOrderedMenu as $item)
                            {{ $item->menu->name }}<br>
                        @endforeach --}}

                      </div>
                      <div class="flex items-center gap-4 mb-6 mt-2">

                        <div class="text-base font-medium">
                            <label for="rating">Search by rating</label>
                            <div class="w-64">
                                <select id="rating" name="rating" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">ALL</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex gap-8">
                            {{-- <div class="text-base font-medium">
                                <label for="search">Search feedback</label>
                                <div class="w-64">
                                    <input type="text" name="search" id="search" class="h-10 border-4 border-slate-800 mt-1 rounded-md py-5 px-4 w-full bg-gray-50" value="" placeholder="Search Menu" />
                                </div>
                            </div> --}}
                            
                            <div class="inline-flex items-end relative mt-5 ms-auto">
                                {{-- <input type="hidden" name="total_price" value="{{ $total_price }}"> --}}
                                <button id="filter" class="w-full rounded-lg bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 shadow-md transition-all">Filter</button>
                            </div>
                        </div>
                        
                    </div>
                    </div>

                    <div class="max-w-7xl mx-auto">
                            
                    </div>
                    
                    <form id="bulk-action-form" action="{{ route('bulk.action.feedback') }}" method="POST">
                        @csrf
                        <div class="relative overflow-x-auto">
                            <table id="dataTables" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-md text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-2">
                                            <div class="flex">
                                                <input type="checkbox" id="select-all">
                                                {{-- <button type="submit" class=" rounded-lg text-white bg-slate-800 hover:bg-slate-900 ms-3 px-4 py-2 text-base font-bold shadow-md"><i class="fa-solid fa-trash"></i></button> --}}
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            No
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Phone
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Rating
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            feedback
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Created at
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @forelse ($feedbacks as $feedback)
                                        @can('view',$feedback)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <th scope="row" class="px-6 py-4 font-lg text-gray-900 whitespace-nowrap dark:text-white text-lg">
                                                    {{ $feedback->name }}
                                                </th>
                                                <td class="px-6 py-4 text-base font-medium">
                                                    {{ $feedback->phone }}
                                                </td>
                                                <td class="px-6 py-4">
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
                                                </td>
                                                <td class="px-6 py-4 text-base font-medium">
                                                    {{ $feedback->message }}
                                                </td>
                                                <td class="px-6 py-4 flex gap-3">
                                                    @can('update',$feedback)
                                                        <div class="flex items-center">
                                                            <a href="{{ route('feedback.edit',$feedback->id) }}" class="z-10 rounded-2xl bg-white px-6 py-2 text-lg font-bold text-slate-800 border-8 border-green-700 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">Edit</a>
                                                            <a class="absolute z-0 bg-green-700 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-green-700">Edit</a>
                                                        </div>
                                                    @endcan
                                                    @can('delete',$feedback)
                                                        <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST"  onsubmit="return confirm('yakin mau hapus?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="flex items-center">
                                                                <button type="submit" class="z-10 rounded-2xl bg-white px-6 py-2 text-lg font-bold text-slate-800 border-8 border-rose-700 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">Delete</button>
                                                                <a class="absolute z-0 bg-rose-700 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-rose-700">Delete</a>
                                                            </div>
                                                        </form>
                                                    @endcan
                                                    
                                                </td>
                                                </td>
                                            </tr>
                                        @endcan
                                    @empty
                                        <tr>
                                            <span>Belum ada data</span>
                                        </tr>
                                    @endforelse --}}
                                    
                                </tbody>
                            </table>
                            <div  id="bulk-action-buttons" class="hidden flex space-x-3 mb-2">
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

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            var datatable = $('#dataTables').DataTable({
                order: [[ 6, 'desc' ]],
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! url()->current() !!}',
                    data: function (d) {
                        d.rating = $('#rating').val();
                    }
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false, width: '5%' },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'phone', name: 'phone' },
                    { data: 'rating', name: 'rating' },
                    { data: 'message', name: 'message' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '15%', },
                ]
            })

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
                    $('#bulk-action-buttons').removeClass('hidden');
                } else {
                    $('#bulk-action-buttons').addClass('hidden');
                }
            }

            toggleBulkActionButtons(); // Initialize visibility on page load
        });
    </script>
@endpush
