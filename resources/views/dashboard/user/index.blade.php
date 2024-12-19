@extends('dashboard.layout.app')

@section('title-page','User')

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
                    <div class="md:flex md:justify-between">
                        <div>
                            <h3 class="mb-2 text-3xl font-bold text-slate-800 dark:text-white">
                                USER
                            </h3>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span class="text-sm font-bold leading-normal text-slate-700"></span>
                                User List
                            </p>

                        {{-- @foreach ($mostOrderedMenu as $item)
                            {{ $item->menu->name }}<br>
                        @endforeach --}}

                        </div>

                        <div>
                            <div class="flex gap-5 mt-5 ms-auto">
                                <div class="inline-flex items-end relative ms-auto">
                                    {{-- <input type="hidden" name="total_price" value="{{ $total_price }}"> --}}
                                    <a href="{{ route('export-user') }}" class="w-full rounded-lg bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 shadow-md transition-all">Excel</a>
                                </div>
                                <div class="flex relative h-fit">
                                    {{-- <input type="hidden" name="total_price" value="{{ $total_price }}"> --}}
                                    <a href="{{ route('user.create') }}" class="w-full rounded-lg text-white bg-slate-800 hover:bg-slate-900 px-8 py-3 text-lg font-bold shadow-md ">New User</a>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 mb-6 mt-2 ms-auto">
                                <div class="flex text-base font-medium space-x-6">
                                    <div>
                                        <label for="role">Search by Role</label>
                                        <div class="w-34 lg:w-64">
                                            <select id="role" name="role" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="">ALL</option>
                                                {{-- @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach --}}
                                                <option value="admin">admin</option>
                                                <option value="cashier">cashier</option>
                                                <option value="service">service</option>
                                                <option value="kitchen">kitchen</option>
                                                <option value="user">user</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="">
                                        <label for="access">Search by Access</label>
                                        <div class="w-34 lg:w-64">
                                            <select id="access" name="access" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="">ALL</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex gap-5 mt-5 ms-auto">
                                    <div class="inline-flex items-end relative ms-auto">
                                        {{-- <input type="hidden" name="total_price" value="{{ $total_price }}"> --}}
                                        <button id="filter" class="w-full rounded-lg bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 shadow-md transition-all">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="max-w-7xl mx-auto">
                            
                    </div>
                    
                    <form id="bulk-action-form" action="{{ route('bulk.action.user') }}" method="POST">
                        @csrf
                        <div  id="bulk-action-buttons" class="hidden flex space-x-3 mb-2">
                            <select id="status" name="bulk_action_access" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled selected>Select Access</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
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
                                            Role
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Access
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @forelse ($users as $user)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-lg text-gray-900 whitespace-nowrap dark:text-white text-lg">
                                                {{ $user->name }}
                                            </th>
                                            <td class="px-6 py-4 text-base font-medium">
                                                {{ $user->phone }}
                                            </td>
                                            <td class="px-6 py-4 text-base font-medium">
                                                {{ $user->email ?? 'belum ada' }}
                                            </td>
                                            <td class="px-6 py-4 text-base font-medium">
                                                {{ $user->role }}
                                            </td>
                                            <td class="px-6 py-4 text-base font-medium">
                                                {{$user->created_at->format('d F Y')}}
                                            </td>
                                            
                                            <td class="px-5 text-base font-medium">
                                                <span class="px-5 py-2 rounded-lg
                                                    @if ($user->access == 'yes')
                                                        text-green-700 bg-green-100
                                                    @else
                                                        text-yellow-700 bg-yellow-100
                                                    @endif
                                                ">
                                                    {{ $user->access }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 flex gap-3">
                                                <div class="flex items-center">
                                                    <a href="{{ route('user.edit',$user->id) }}" class="z-10 rounded-2xl bg-white px-6 py-2 text-lg font-bold text-slate-800 border-8 border-green-700 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">Edit</a>
                                                    <a class="absolute z-0 bg-green-700 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-green-700">Edit</a>
                                                </div>
                                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"  onsubmit="return confirm('yakin mau hapus?');">
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
                        </div>
                        <div  id="bulk-action-buttons" class="hidden flex space-x-3 mb-2">
                            <select id="status" name="bulk_action_access" class="bg-gray-50 border-4 border-slate-800 text-gray-900 text-sm rounded-lg mt-1 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled selected>Select Access</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
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
                processing: true,
                serverSide: true,
                order: [[ 5,'desc' ]],
                ajax: {
                    url: '{!! url()->current() !!}',
                    data: function (d) {
                        d.role = $('#role').val();
                        d.access = $('#access').val();
                    }
                },

                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false, width: '5%' },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'phone', name: 'phone' },
                    { data: 'role', name: 'role' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'access', name: 'access' },
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
