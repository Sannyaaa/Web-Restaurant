@extends('frontend.layout.app')

@section('title-page','Contact')

@section('content')
    <div class="bg-zinc-100 bg-cover h-full" style="background-image: url('{{ asset('assets/img/camille-chen.jpg') }}')">
        <div class="relative isolate">
            <div class="w-full text-center py-28 sm:py-32 lg:py-36 px-14 sm:px-24 md:px-40 text-white bg-yellow-700 bg-opacity-40">
                <h1 class="text-7xl font-bold tracking-tight sm:text-7xl font-one">Contact Us</h1>

                <p class="mt-6 text-lg leading-8 w-1/2 mx-auto">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.</p>
            </div>
        </div>
    </div>

    <div class="bg-zinc-50">
        <div class="py-24 px-20 md:px-36">
            <div class="">
                <div class=" max-w-7xl mx-auto flex-row-reverse lg:flex gap-10 rounded-xl border-slate-800">
                    <div class="w-full lg:max-w-1/5">
                        <h2 class="text-4xl font-bold tracking-tight text-slate-800 sm:text-5xl font-one text-center mb-5">Send Your <span class="text-yellow-300">Feeling</span></h2>
                        <form action="{{ route('feedback.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="mt-4 flex w-full gap-4">
                                <div class="w-full md:w-1/2 text-base font-medium">
                                    <label for="name">Your Name <span class="text-rose-500">*</span></label>
                                    <div class="w-full">
                                        <input type="text" name="name" id="name" class="h-10 border-4 border-slate-800 mt-1 rounded-md py-5 px-4 w-full bg-zinc-50" value="" placeholder="your name" />
                                    </div>
                                    @error('name')
                                        <div class="my-4 py-3 px-5 bg-rose-200 rounded-lg">
                                            <div class="alert alert-success text-sm text-rose-700">
                                                {{ $message }}
                                            </div>
                                        </div>
                                    @enderror
                                </div>
                                <div class="w-full md:w-1/2 text-base font-medium">
                                    <label for="phone">Your Phone <span class="text-rose-500">*</span></label>
                                    <div class="w-full">
                                        <input type="text" name="phone" id="phone" class="h-10 border-4 border-slate-800 mt-1 rounded-md py-5 px-4 w-full bg-zinc-50" value="" placeholder="your phone" />
                                    </div>
                                    @error('phone')
                                        <div class="my-4 py-3 px-5 bg-rose-200 rounded-lg">
                                            <div class="alert alert-success text-sm text-rose-700">
                                                {{ $message }}
                                            </div>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-4 w-full">
                                <div class="text-base font-medium">
                                    <label for="email">Email </label>
                                    <div class="w-full">
                                        <input type="email" name="email" id="email" class="h-10 border-4 border-slate-800 mt-1 rounded-md py-5 px-4 w-full bg-zinc-50" value="" placeholder="your email" />
                                    </div>
                                    @error('email')
                                        <div class="my-4 py-3 px-5 bg-rose-200 rounded-lg">
                                            <div class="alert alert-success text-sm text-rose-700">
                                                {{ $message }}
                                            </div>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-4 w-full">
                                <div class="text-base font-medium">
                                    <label for="message">Message <span class="text-rose-500">*</span></label>
                                    <div class="w-full">
                                        <textarea type="text" name="message" id="message" class="border-4 border-slate-800 mt-1 rounded-md p-4 w-full h-36 bg-zinc-50" value="" value="your email" >
                                        </textarea>
                                    </div>
                                    @error('message')
                                        <div class="my-3 py-3 px-5 bg-rose-200 rounded-lg">
                                            <div class="alert alert-success text-sm text-rose-700">
                                                {{ $message }}
                                            </div>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="my-4">
                                    <div class="mb-2">
                                        <label for="price-range" class="block text-gray-700 font-bold">Rating <span class="text-rose-500">*</span></label>
                                        <input type="range" id="price-range" name="rating" class="w-full accent-yellow-200 border-yellow-200" min="1" max="5" value="500" oninput="updatePrice(this.value)">
                                    </div>
                                    <div class="flex justify-between text-gray-500">
                                        <span id="minPrice">1</span>
                                        <span id="maxPrice">5</span>
                                    </div>
                                <script>
                                function updatePrice(value) {
                                    document.getElementById("minPrice").textContent = value ;
                                }
                                </script>
                                @error('rating')
                                    <div class="my-4 py-3 px-5 bg-rose-200 rounded-lg">
                                        <div class="alert alert-success text-sm text-rose-700">
                                            {{ $message }}
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="flex relative w-full bg-yellow-300 rounded-lg mt-4 text-center">
                                {{-- @if (Auth::user()) --}}
                                    <button type="submit" class="font-semibold text-lg inline-block w-full text-slate-800 hover:text-white bg-yellow-300 hover:bg-slate-800 transition-all rounded-lg py-3 px-6">Submit</button>
                                {{-- @else
                                    <button disabled class="font-semibold text-lg inline-block w-full text-slate-800 hover:text-white bg-yellow-300 hover:bg-slate-800 transition-all rounded-lg py-3 px-6">Login</button>
                                @endif --}}
                            </div>
                        </form>
                    </div>
                    <div class="w-full lg:max-w-4/5 py-auto">
                        <img src="{{ asset('assets/img/Contact us-bro (1).png') }}" class="my-auto" alt="">
                    </div>
                </div>
            </div>

            {{-- <div class="flex mx-40 mt-40">
                <div class="w-1/2">
                    
                </div>
                <div class="w-1/2">
                    <div class="">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Data to enrich your online business</h1>

                        <p class="mt-6 text-lg leading-8 text-gray-600">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.</p>

                    </div>
                </div>
            </div> --}}

            <div class="flex">
                
            </div>
            
        </div>
    </div>
@endsection