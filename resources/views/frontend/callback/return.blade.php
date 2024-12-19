@extends('frontend.layout.app')

@section('title-page','Return')

@section('content')
    <div class="bg-zinc-50">
        <div class="relative isolate">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                {{-- <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div> --}}
            </div>
            <div class="w-full flex justify-between min-h-screen py-24 lg:py-10 px-12 sm:px-20 md:px-12 lg:px-32">
                <div class="w-full md:flex justify-center items-center">
                    @if (session('success'))
                        <div class="w-1/2 mx-auto py-2 rounded-md -mt-6 mb-4 text-center bg-green-100 text-green-900 text-base border-green-900 border-2">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="w-full md:w-1/2 mx-auto">
                        <img src="{{ asset('assets/img/Eating together-amico.png') }}" class="w-full" alt="">
                    </div>
                    <div class="w-full md:w-1/2">
                        <h1 class="text-5xl font-bold font-one tracking-normal text-slate-800 sm:text-7xl">
                        Thank you for order!
                        </h1>

                        <p class="mt-6 text-lg leading-8 text-gray-600">Your order is being processed, and we are working hard to ensure everything is perfect. Please bear with us for a moment.
                            <br>
                        If you have any questions or need further assistance, feel free to contact our customer support team.</p>

                        <div class="my-6 flex items-center gap-x-6">
                            <a href="{{ route('index') }}" class="px-6 py-3 transition-all bg-slate-800 text-white hover:bg-white border-slate-800 border-4 hover:text-slate-800 rounded-xl font-bold text-lg">Back Home</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
                {{-- <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div> --}}
            </div>
        </div>
    </div>


@endsection