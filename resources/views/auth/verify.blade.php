@extends('auth.app')

@section('content')
  <section class="min-h-screen">
    <div class="bg-top relative flex items-start pt-12 pb-56 m-4 overflow-hidden bg-cover min-h-50-screen rounded-xl bg-[url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg')]">
      <span class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-zinc-800 to-zinc-700 opacity-60"></span>
      <div class="container z-10">
        <div class="flex flex-wrap justify-center -mx-3">
          <div class="w-full max-w-full px-3 mx-auto mt-0 text-center lg:flex-0 shrink-0 lg:w-5/12">
            <h1 class="mt-12 mb-2 text-white">Hallo {{ $user->name }}!!</h1>
            <p class="text-white">Kami baru saja mengirim code otp kamu melalui whatsapp, kamu bisa masukkan di kolom si bawah ini.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="flex flex-wrap -mx-3 -mt-48 md:-mt-56 lg:-mt-48">
        <div class="w-full max-w-full px-3 mx-auto mt-0 md:flex-0 shrink-0 md:w-7/12 lg:w-5/12 xl:w-4/12">
          <div class="relative z-0 flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
            <div class="p-6 mb-0 text-center bg-white border-b-0 rounded-t-2xl">
              <h5 class="text-slate-800 text-2xl font-bold">Masukkan Code OTP</h5>
            </div>
            <div class="flex-auto px-6 py-4">
              <form role="form" action="{{ route('verify.process') }}" method="POST">
                @csrf
                @method('POST')
                <div class="mb-4">
                    <input type="number" placeholder="otp code" name="otp" class="focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block w-full appearance-none rounded-lg border-4 border-solid border-slate-800 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-slate-900 focus:outline-none" />
                    @error('otp')
                        <div class="bg-rose-200">
                              <span class="text-rose-700">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
                <div class="text-center relative">
                  <div class="inline-flex w-full items-end relative mt-5 ms-auto">
                      <button type="submit" class="z-10 w-full rounded-lg bg-yellow-300 hover:bg-slate-800 hover:text-white transition-all px-6 py-2 text-lg font-bold text-slate-800 shadow-md border-4 border-yellow-300 hover:border-slate-800">Send</button>
                      {{-- <span class="absolute w-full z-0 bg-slate-800 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-slate-800">Send</span> --}}
                  </div>
                </div>
              </form>
              <div class="text-center relative">
                <form action="{{ route('resend') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="phone" value="{{ $user->phone }}">
                    <div class="inline-flex w-full items-end relative mt-5 ms-auto">
                        <button type="submit" class="z-10 w-full rounded-lg bg-slate-800 hover:bg-slate-900 px-6 py-2 text-lg font-bold text-white shadow-md border-4 border-slate-800 ">Resend</button>
                        {{-- <span class="absolute w-full z-0 bg-slate-800 rounded-2xl px-6 py-2 text-lg font-semibold text-slate-800 shadow-md border-8 border-slate-800">Resend</span> --}}
                    </div>
                </form>
              </div>
              <p class="my-4 mb-0 leading-normal text-sm text-center">Already have an account? <a href="{{ route('login') }}" class="font-bold text-slate-700">Sign in</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection