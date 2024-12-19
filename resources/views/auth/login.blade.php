@extends('auth.app')

@section('content')
  <section>
    <div class="relative flex items-center min-h-screen p-0 overflow-hidden bg-center bg-cover">
      <div class="container z-1">
        <div class="flex flex-wrap -mx-3">
          <div class="absolute top-0 right-0 flex-col justify-center hidden w-6/12 h-full max-w-full px-3 pr-0 my-auto text-center flex-0 lg:flex">
              <div class="relative flex flex-col justify-center h-full bg-cover px-24 m-4 overflow-hidden bg-[{{  asset('assets/img/food-bro (1).png') }}] rounded-xl ">
                  <div class="px-auto w-full">
                    <span class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-yellow-400 to-yellow-200 opacity-100"></span>
                    <img src="{{ asset('assets/img/Coffee shop-amico (2).png') }}" alt="" class="max-w-lg mx-auto opacity-95">
                    <div class="z-20 text-slate-800">
                        <h4 class="text-2xl font-bold text-slate-800 opacity-95">"Cozy Atmosphere"</h4>
                        <p class=" opacity-95 ">Relax in our urban jungle-inspired interior, freshly brewed to perfection, designed to make you feel at home.</p>
                    </div>
                  </div>
              </div>
          </div>
          <div class="flex flex-col w-full px-16 mx-auto lg:mx-0 shrink-0 md:flex-0 md:w-7/12 lg:w-5/12 xl:w-5/12">
            <div class="relative flex align-middle flex-col min-w-0 break-words bg-transparent border-0 shadow-none lg:py4 dark:bg-gray-950 rounded-2xl bg-clip-border">
              <div class="p-6 pb-0 mb-0">
                <h4 class="font-bold text-4xl mb-2 text-slate-800">Login</h4>
                <p class="mb-0">Enter your phone and password to sign in</p>
              </div>
              <div class="flex-auto p-6">
                <form role="form" action="{{ route('login.process') }}" method="POST">
                  @csrf
                  @method('POST')
                  <div class="mb-4">
                    <input type="number" placeholder="Phone" name="phone" value="{{ old('phone') ?? '089123456789' }}" class="focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block w-full appearance-none rounded-lg border-4 border-solid border-slate-800 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-slate-900 focus:outline-none" />
                    @error('phone')
                        <div class="my-2 py-2 px-6 bg-rose-200 rounded-lg">
                            <div class="alert alert-success text-sm text-rose-700">
                                {{ $message }}
                            </div>
                        </div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <input type="password" placeholder="Password" name="password" value="{{ old('password') ?? 'password' }}" class="focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block w-full appearance-none rounded-lg border-4 border-solid border-slate-800 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-slate-900 focus:outline-none" />
                    @error('password')
                        <div class="my-2 py-2 px-6 bg-rose-200 rounded-lg">
                            <div class="alert alert-success text-sm text-rose-700">
                                {{ $message }}
                            </div>
                        </div>
                    @enderror
                  </div>
                  <div class="flex items-center pl-12 mb-0.5 text-left min-h-6">
                    <input id="rememberMe" class="mt-0.5 rounded-10 duration-250 ease-in-out after:rounded-circle after:shadow-2xl after:duration-250 checked:after:translate-x-5.3 h-5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-zinc-700/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-blue-500/95 checked:bg-blue-500/95 checked:bg-none checked:bg-right" type="checkbox" />
                    <label class="ml-2 font-normal cursor-pointer select-none text-sm text-slate-700" for="rememberMe">Remember me</label>
                  </div>
                  <div class="text-center">
                    <div class="inline-flex w-full items-end relative mt-5 ms-auto">
                        {{-- <input type="hidden" name="total_price" value="{{ $total_price }}"> --}}
                        <button type="submit" class="font-semibold text-lg inline-block w-full text-slate-800 hover:text-white bg-yellow-300 hover:bg-slate-800 transition-all rounded-lg py-3 px-6">Login</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="border-black/12.5 rounded-b-2xl border-t-0 border-solid p-6 text-center pt-0 px-1 sm:px-6">
                {{-- <form action="{{ route('login.process') }}" method="POST">
                  @csrf
                  @method('POST')
                  <input type="hidden" name="phone" value="08987964511">
                  <input type="hidden" name="password" value="123123123">
                  <button class="font-semibold text-slate-800 hover:underline">
                    Login as Admin
                  </button>
                </form> --}}
                <br>
                <span class="mx-auto mb-6 leading-normal text-sm">Don't have an account? <a href="{{ route('register') }}" class="font-semibold text-transparent bg-clip-text bg-gradient-to-tl from-blue-500 to-violet-500 hover:underline">Sign up</a></span>
                <br>
                <a href="{{ route('index') }}" class="text-slate-500 hover:underline text-sm">Back Home</a>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </section>
@endsection