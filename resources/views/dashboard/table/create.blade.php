@extends('dashboard.layout.app')

@section('title-page','Table')

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
                      
                      <div>
                        <h3 class="text-3xl font-bold dark:text-white">
                            NEW TABLE
                        </h3>
                      </div>
                    </div>
                    
                    <div class="relative overflow-x-auto">
                        <form action="{{ route('table.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('POST')
                            <div class="lg:col-span-2">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                <div class="md:col-span-5">
                                    <label for="name">Table Name <span class="text-rose-500">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" id="name" class="h-10 border-4 border-slate-900 mt-1 rounded-md py-5 px-4 w-full bg-gray-50" value="" />
                                    @error('name')
                                        <div class="my-4 py-4 px-6 bg-rose-200 rounded-lg">
                                            <div class="alert alert-success text-md text-rose-700">
                                                {{ $message }}
                                            </div>
                                        </div>
                                    @enderror
                                </div>

                                {{-- <div class="md:col-span-5">
                                    <label for="qr_code">qr_code Address</label>
                                    <input type="file" name="qr_code" id="qr_code" class="h-12 pt-2 border-4 border-slate-900 mt-1 rounded-md px-4 w-full bg-gray-50" value="" placeholder="email@domain.com" />
                                    @error('qr_code')
                                        <div class="my-4 py-4 px-6 bg-rose-200 rounded-lg">
                                            <div class="alert alert-success text-md text-rose-700">
                                                {{ $message }}
                                            </div>
                                        </div>
                                    @enderror
                                </div> --}}

                                {{-- <div class="md:col-span-3">
                                    <label for="address">Address / Street</label>
                                    <input type="text" name="address" id="address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" placeholder="" />
                                </div>

                                <div class="md:col-span-2">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" placeholder="" />
                                </div>

                                <div class="md:col-span-2">
                                    <label for="country">Country / region</label>
                                    <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                                    <input name="country" id="country" placeholder="Country" class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent" value="" />
                                    <button tabindex="-1" class="cursor-pointer outline-none focus:outline-none transition-all text-gray-300 hover:text-red-600">
                                        <svg class="w-4 h-4 mx-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                    <button tabindex="-1" for="show_more" class="cursor-pointer outline-none focus:outline-none border-l border-gray-200 transition-all text-gray-300 hover:text-blue-600">
                                        <svg class="w-4 h-4 mx-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                                    </button>
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="state">State / province</label>
                                    <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                                    <input name="state" id="state" placeholder="State" class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent" value="" />
                                    <button tabindex="-1" class="cursor-pointer outline-none focus:outline-none transition-all text-gray-300 hover:text-red-600">
                                        <svg class="w-4 h-4 mx-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                    <button tabindex="-1" for="show_more" class="cursor-pointer outline-none focus:outline-none border-l border-gray-200 transition-all text-gray-300 hover:text-blue-600">
                                        <svg class="w-4 h-4 mx-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                                    </button>
                                    </div>
                                </div>

                                <div class="md:col-span-1">
                                    <label for="zipcode">Zipcode</label>
                                    <input type="text" name="zipcode" id="zipcode" class="transition-all flex items-center h-10 border mt-1 rounded px-4 w-full bg-gray-50" placeholder="" value="" />
                                </div>

                                <div class="md:col-span-5">
                                    <div class="inline-flex items-center">
                                    <input type="checkbox" name="billing_same" id="billing_same" class="form-checkbox" />
                                    <label for="billing_same" class="ml-2">My billing address is different than above.</label>
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="soda">How many soda pops?</label>
                                    <div class="h-10 w-28 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                                    <button tabindex="-1" for="show_more" class="cursor-pointer outline-none focus:outline-none border-r border-gray-200 transition-all text-gray-500 hover:text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <input name="soda" id="soda" placeholder="0" class="px-2 text-center appearance-none outline-none text-gray-800 w-full bg-transparent" value="0" />
                                    <button tabindex="-1" for="show_more" class="cursor-pointer outline-none focus:outline-none border-l border-gray-200 transition-all text-gray-500 hover:text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 fill-current" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    </div>
                                </div> --}}
                        
                                <div class="md:col-span-5 my-3 flex justify-between mx-4">
                                    <div class="inline-flex">
                                        <a href="{{ route('table.index') }}" class=" bg-slate-800 hover:bg-slate-900 px-8 py-3 text-lg font-bold text-white rounded-lg">Back</a>
                                    </div>
                                    <div class="inline-flex items-end">
                                        <button type="submit" class=" bg-yellow-300 hover:bg-yellow-400 px-8 py-3 text-lg font-bold text-slate-800 rounded-lg">Submit</button>
                                    </div>
                                </div>

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
