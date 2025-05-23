@extends('dashboard.layout.app')

@section('title-page','Menu')

@push('style')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
    

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
                        <h3 class="mb-2 text-3xl font-bold text-slate-800 dark:text-white">
                            MENU
                        </h3>
                        <p class="mb-0 dark:text-white dark:opacity-60">
                            <span class="text-sm font-bold leading-normal text-slate-700"></span>
                            All Menu
                        </p>

                        {{-- @foreach ($mostOrderedMenu as $item)
                            {{ $item->menu->name }}<br>
                        @endforeach --}}

                      </div>

                      <div class="flex gap-6 w-fit">
                        <div class="flex items-center mb-6 space-x-5">
                            <div class=" text-base font-medium">
                                <label for="category_id">Search by Category</label>
                                <div class="max-w-64">
                                    <select id="category_id" name="category_id" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">ALL</option>
                                        @forelse ($categories as $category)
                                            <option class="" value="{{ $category->id }}">{{ $category->name }}</option>
                                        @empty
                                            <option>category not found</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="">
                                <div class="inline-flex items-end relative mt-5 ms-auto">
                                    {{-- <input type="hidden" name="total_price" value="{{ $total_price }}"> --}}
                                    <button id="filter" class="w-full rounded-lg bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 shadow-md transition-all">Filter</button>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center relative">
                            <a href="{{ route('menu.create') }}" class="w-full rounded-lg text-white bg-slate-800 hover:bg-slate-900 px-8 py-3 text-lg font-bold shadow-md ">New Menu</a>
                        </div>
                      </div>
                    </div>

                    <div class="max-w-7xl mx-auto">
                            
                    </div>
                    
                    <form id="bulk-action-form" action="{{ route('bulk.action.menu') }}" method="POST">
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
                                            Image
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Category
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Price
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
                                    {{-- @forelse ($menus as $menu)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-lg">
                                                {{ $menu->name }}
                                            </th>
                                            <td class="px-6 py-4">
                                                <div class="">
                                                    <img src="{{ Storage::url($menu->image) }}" class="max-h-48" alt="">
                                                </div>
                                            </td>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $menu->category->name }}
                                            </th>
                                            <td class="px-6 py-4 flex gap-3">
                                                <div class="flex items-center">
                                                    <a href="{{ route('detail-menu',$menu->id) }}" class="z-10 rounded-2xl bg-white px-6 py-2 text-lg font-bold text-slate-800 border-8 border-blue-700 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">Detail</a>
                                                    <a class="absolute z-0 bg-blue-700 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-blue-700">Detail</a>
                                                </div>
                                                <div class="flex items-center">
                                                    <a href="{{ route('menu.edit',$menu->id) }}" class="z-10 rounded-2xl bg-white px-6 py-2 text-lg font-bold text-slate-800 border-8 border-green-700 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">Edit</a>
                                                    <a class="absolute z-0 bg-green-700 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-green-700">Edit</a>
                                                </div>
                                                <form action="{{ route('menu.destroy', $menu->id) }}" method="POST"  onsubmit="return confirm('yakin mau hapus?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="flex items-center">
                                                        <button type="submit" class="z-10 rounded-2xl bg-white px-6 py-2 text-lg font-bold text-slate-800 border-8 border-rose-700 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">Delete</button>
                                                        <a class="absolute z-0 bg-rose-700 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-rose-700">Delete</a>
                                                    </div>
                                                </form>
                                                
                                            </td>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <span>Belum ada data</span>
                                        </tr>
                                    @endforelse --}}
                                </tbody>
                            </table>
                            <div  id="bulk-action-buttons" class="hidden flex space-x-3 mb-2">
                                <select id="status" name="bulk_action_category" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" disabled selected>Select Category</option>
                                    @forelse ($categories as $category)
                                        <option class="" value="{{ $category->id }}">{{ $category->name }}</option>
                                    @empty
                                        <option>category not found</option>
                                    @endforelse
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
                    d.category_id = $('#category_id').val();
                }
            },
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false, width: '5%' },
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'image', name: 'image' },
                { data: 'category_id', name: 'category_id' },
                { data: 'price', name: 'price' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false, width: '15%', },
            ]
        })

        $('#filter').click(function() {
            datatable.draw();
        });

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
