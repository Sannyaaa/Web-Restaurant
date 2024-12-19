

<nav class="bg-white dark:bg-slate-900 py-4 w-full z-20 top-0 start-0 border-b border-slate-200 dark:border-slate-600">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-2">
  <a href="{{ route('index') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
      <span class="self-center text-3xl font-semibold whitespace-nowrap dark:text-white font-one tracking-wider">RestoQu</span>
  </a>

  <div class=" flex">
    <ul class="flex font-semibold space-x-10 md:bg-white dark:bg-slate-800 md:dark:bg-slate-900 dark:border-slate-700">
      <li>
        <a href="{{ route('index') }}" class="{{ request()->is('/') ? 'md:text-yellow-400' : 'md:text-slate-800' }} text-transparent " aria-current="page">Home</a>
      </li>
      <li>
        <a href="{{ route('list-menu') }}" class="{{ request()->is('list-menu') || request()->is('detail-menu/*') ? 'md:text-yellow-400' : 'md:text-slate-800' }} text-transparent md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-slate-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-slate-700">Menu</a>
      </li>
      <li>
        <a href="{{ route('contact-us') }}" class="{{ request()->is('contact-us') ? 'md:text-yellow-400' : 'md:text-slate-800' }} text-transparent md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-slate-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-slate-700">Contact</a>
      </li>
      <li>
        <a href="{{ route('cart.index') }}" class="{{ request()->is('cart') ? 'md:text-yellow-400' : 'md:text-slate-800' }} text-transparent md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-slate-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-slate-700">
            <i class="fa-solid fa-cart-shopping my-auto"></i>
        </a>
      </li>
    </ul>
  </div>

  <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
        <div class="flex w-full gap-6">
            @if (Auth::check())
                <div class="">
                    <a href="{{ route('dashboard') }}" class="font-semibold text-lg inline-block w-full hover:text-white bg-yellow-300 hover:bg-slate-800 transition-all rounded-lg py-3 px-6">
                        Dashboard
                    </a>
                    {{-- <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <div class="font-semibold text-lg inline-block w-full text-white hover:text-slate-800 bg-slate-800 hover:bg-yellow-300 transition-all rounded-lg">
                            <button type="submit" class=" py-3 px-6">
                                Logout
                            </button>
                        </div>
                    </form> --}}
                </div>
                <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                  <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 ring-4 ring-zinc-50 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                      <span class="sr-only">Open user menu</span>
                      @if (Auth::user()->avatar)
                        <img class="w-10 h-10 rounded-full" src="{{ Storage::url(Auth::user()->avatar) }}" alt="user photo">
                      @else
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-slate-800">
                          <i class="fa-solid fa-user my-auto"></i>
                        </div>
                      @endif
                  </button>
                  <!-- Dropdown menu -->
                  <div class="z-50 hidden min-w-44 my-4 text-base list-none shadow-xl bg-white divide-y divide-gray-100 rounded-lg dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                      <div class="px-4 py-3">
                          <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                          <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->phone }}</span>
                      </div>
                      <ul class="py-2" aria-labelledby="user-menu-button">
                          <li>
                              <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                          </li>
                          <li>
                              <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                          </li>
                          <li>
                            <form action="{{ route('logout') }}" method="POST">
                              @csrf
                              <button type="submit" class="text-left w-full">
                                <span class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Logout</span>
                              </button>
                            </form>
                          </li>
                      </ul>
                  </div>
                  {{-- <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-user" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button> --}}
              </div>
            @else
                <a href="{{ route('login') }}" class="font-semibold text-lg inline-block w-full hover:text-white bg-yellow-300 hover:bg-slate-800 transition-all rounded-lg py-3 px-6">
                    Login
                </a>
            @endif
        </div>
        
        <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 my-auto w-10 h-10 justify-center text-sm text-slate-500 rounded-lg md:hidden hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:focus:ring-slate-600" aria-controls="navbar-sticky" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
  </div>
  <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
    <ul class="flex flex-col p-4 md:p-0 mt-4 font-semibold border text-slate-800 border-slate-100 rounded-lg space-y-3 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-slate-800 md:dark:bg-slate-900 dark:border-slate-700">
      <li>
        <a href="{{ route('index') }}" class="{{ request()->is('/') ? 'text-yellow-400' : '' }} md:text-transparent " aria-current="page">Home</a>
      </li>
      <li>
        <a href="{{ route('list-menu') }}" class="{{ request()->is('list-menu') || request()->is('detail-menu/*') ? 'text-yellow-400' : '' }} md:text-transparent  dark:text-white dark:hover:bg-slate-700 dark:hover:text-white dark:hover:bg-transparent dark:border-slate-700">Menu</a>
      </li>
      <li>
        <a href="{{ route('contact-us') }}" class="{{ request()->is('contact-us') ? 'text-yellow-400' : '' }} md:text-transparent  dark:text-white dark:hover:bg-slate-700 dark:hover:text-white dark:hover:bg-transparent dark:border-slate-700">Contact</a>
      </li>
      <li>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class=" md:text-transparent  dark:text-white dark:hover:bg-slate-700 dark:hover:text-white dark:hover:bg-transparent dark:border-slate-700">
            Logout
          </button>
        </form>
      </li>
      <li>
        <a href="{{ route('cart.index') }}" class="{{ request()->is('cart') ? 'text-yellow-400' : '' }} md:text-transparent  dark:text-white dark:hover:bg-slate-700 dark:hover:text-white dark:hover:bg-transparent dark:border-slate-700">
            <i class="fa-solid fa-cart-shopping my-auto"></i>
        </a>
      </li>
    </ul>
  </div>
  </div>
</nav>


