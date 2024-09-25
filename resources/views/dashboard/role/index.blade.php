@extends('dashboard.layout.app')

@section('title-page','Role')

@section('content')
    <!-- row 1 -->
        <div class="flex flex-wrap -mx-3">
          <!-- card1 -->
          <div class="w-full max-w-full px-8 mb-6 sm:flex-none xl:mb-0">
            <div class="relative flex flex-col min-w-0 break-words border-4 border-slate-800 bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-10">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-full max-w-full px-3">
                    <div class=" flex justify-between">
                      
                      <div>

                        {{-- <h1>Current URL</h1>
                        <p>{{ url()->current() }}</p>

                        <h1>Full URL with Query String</h1>
                        <p>{{ url()->full() }}</p>

                        <h1>Path</h1>
                        <p>{{ request()->path() }}</p>

                        <h1>First Segment</h1>
                        <p>{{ request()->segment(2) }}</p> --}}

                        <h3 class="mb-2 text-3xl font-bold text-slate-900 dark:text-white">
                            ROLE
                        </h3>
                        <p class="mb-0 dark:text-white dark:opacity-60">
                            <span class="text-sm font-bold leading-normal text-slate-700"></span>
                            All Role
                        </p>
                      </div>

                      <div class="flex space-x-4">
                        {{-- <form action="{{ route('role.index') }}" method="GET">
                            <div class="flex items-center justify-between w-full gap-4">

                                <div class="text-base font-medium">
                                    <label for="search">Search Role</label>
                                    <div class="w-64">
                                        <input type="text" name="search" id="search" class="h-10 border-4 border-slate-800 mt-1 rounded-md py-5 px-4 w-full bg-gray-50" value="" placeholder="Search" />
                                    </div>
                                </div>
                                
                                <div class="inline-flex items-end relative mt-5 ms-auto">
                                    <input type="hidden" name="total_price" value="{{ $total_price }}">
                                    <button type="submit" class="z-10 w-full rounded-2xl bg-white px-6 py-2 text-lg font-bold text-slate-800 shadow-md border-8 border-slate-800 hover:-translate-x-2 hover:-translate-y-2 transition-all focus-visible:outline focus-visible:outline-2  focus-visible:outline-offset-2 focus-visible:outline-slate-600">Search</button>
                                    <span class="absolute w-full z-0 bg-slate-800 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-slate-800">Search</span>
                                </div>
                            </div>
                        </form> --}}
                        <div class="flex items-center mt-5">
                            <a href="{{ route('role.create') }}" class="bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 rounded-lg">New Role</a>
                        </div>
                      </div>
                    </div>

                    <div class="max-w-7xl mx-auto flex justify-between items-center mb-6">
                        
                    </div>
                    
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-md text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 max-w-2xl">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3 max-w-2xl">
                                        Created at
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $role)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $role->name }}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium max-w-2xl break-all text-gray-900 whitespace-normal overflow-hidden dark:text-white">
                                            {{ $role->description }}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium max-w-2xl break-all text-gray-900 whitespace-normal overflow-hidden dark:text-white">
                                            {{ $role->created_at->format('d F Y') }}
                                        </th>
                                        <td class="px-6 py-4 flex gap-3">
                                            
                                            <div class="flex items-center">
                                                <a href="{{ route('role.edit',$role->id) }}" class="bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 rounded-lg">Edit</a>
                                            </div>
                                            <form action="{{ route('role.destroy', $role->id) }}" method="POST"  onsubmit="return confirm('yakin mau hapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <div class="flex items-center">
                                                    <button type="submit" class="w-full rounded-lg text-white bg-slate-800 hover:bg-slate-900 px-8 py-3 text-lg font-bold shadow-md ">Delete</button>
                                                </div>
                                            </form>
                                            
                                        </td>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <span>Belum ada data</span>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        {{-- {{ $roles->links() }} --}}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection
