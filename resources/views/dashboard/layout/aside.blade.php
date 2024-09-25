<aside  id="sidebar" class="fixed inset-y-0 flex-wrap items-center max-h-screen justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 border-4 border-slate-800 -translate-x-full bg-white shadow-xl dark:shadow-none dark:bg-slate-850 max-w-72 ease-nav-brand z-990 xl:ml-6 rounded-2xl xl:left-0 xl:translate-x-0 scrollbar-hide" aria-expanded="false">
  <div class="flex justify-center py-2">
    <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden" id="sidenavClose"></i>
    <a class="block px-8 py-6 mx-auto text-sm whitespace-nowrap dark:text-white text-slate-700" href="{{ route('index') }}" target="_blank">
      <img src="{{ asset('assets/img/connya.jpg') }}" class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-14" alt="main_logo" />
      {{-- <img src="./assets/img/logo-ct.png" class="hidden h-full max-w-full transition-all duration-200 dark:inline ease-nav-brand max-h-10 mx-auto" alt="main_logo" /> --}}
    </a>
  </div>

  <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />

  <div class="items-center block w-auto min-h-screen h-full grow basis-full scrollbar-hide">
    <ul class="flex flex-col pl-0 mb-4">
      @can('isStaf')
        <li class="mt-0.5 w-full">
          <a class= " dark:text-white dark:opacity-80 text-base ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap  px-4 transition-colors {{ request()->routeIs('dashboard') ? 'bg-yellow-100 font-semibold text-slate-600 rounded-lg py-3' : 'py-2' }}" href="{{ route('dashboard') }}">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2">
              {{-- <i class="fa-solid fa-tv"></i> --}}
              <i class="fa-solid fa-desktop"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Dashboard</span>
          </a>
        </li>
      @endcan

      {{-- @can('orderAccess') --}}
        <li class="mt-0.5 w-full">
          <a class=" dark:text-white dark:opacity-80  text-base ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors {{ request()->routeIs('order.*') ? 'bg-yellow-100 font-semibold text-slate-600 rounded-lg py-3' : 'py-2' }}" href="{{ route('order.index') }}">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Order</span>
          </a>
        </li>
      {{-- @endcan --}}

      @can('isKitchen')
        <li class="mt-0.5 w-full">
          <a class=" dark:text-white dark:opacity-80  text-base ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors {{ request()->routeIs('kitchen*') ? 'bg-yellow-100 font-semibold text-slate-600 rounded-lg py-3' : 'py-2' }}" href="{{ route('kitchen') }}">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="fa-solid fa-kitchen-set"></i>
              {{-- <i class="fa-solid fa-utensils"></i> --}}
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Kitchen</span>
          </a>
        </li>
      @endcan
      
      @can('isService')
        <x-collapse id="table-collapse" title="Table" icon="fa-solid fa-chair" :active="request()->routeIs('table.*')">
            <ul class="pl-12 my-2">
                <li class="py-2">
                    <a href="{{ route('table.index') }}" class=" dark:text-white ">All Table</a>
                </li>
                <li class="py-2">
                    <a href="{{ route('table.create') }}" class=" dark:text-white ">Create Table</a>
                </li>
            </ul>
        </x-collapse>
      @endcan

      @can('isStaf')
        <li class="w-full mt-4">
          <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60">Assets</h6>
        </li>
      @endcan


      @can('isKitchen')
        {{-- <li class="mt-0.5 w-full px-2">
            <button 
                class="dark:text-white dark:opacity-80 text-base ease-nav-brand my-0 flex items-center whitespace-nowrap px-4 transition-colors py-2 w-full text-left focus:outline-none {{ request()->routeIs('category.*') ? 'bg-yellow-100 font-semibold text-slate-600 rounded-lg py-3' : 'py-2' }}" 
                type="button" 
                data-collapse-toggle="category-collapse" 
                aria-expanded="{{ request()->routeIs('category.*') ? 'true' : 'false' }}" 
                aria-controls="category-collapse">
                <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
                    <i class="fa-solid fa-list"></i>
                </div>
                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Category</span>
                <i class="ml-auto fa fa-chevron-down transition-transform duration-200 transform {{ request()->routeIs('category.*') ? 'rotate-180' : '' }}" id="chevron-icon"></i>
            </button>
            <div id="category-collapse" class="{{ request()->routeIs('category.*') ? 'block bg-zinc-100' : 'hidden' }}  text-slate-600 text-sm overflow-hidden rounded-lg transition-all duration-300">
                <ul class="pl-12 my-2">
                    <li class="py-2">
                        <a href="{{ route('category.index') }}" class=" dark:text-white ">All Category</a>
                    </li>
                    <li class="py-2">
                        <a href="{{ route('category.create') }}" class=" dark:text-white ">Create Category</a>
                    </li>
                </ul>
            </div>
        </li> --}}

        <!-- Example usage in a Blade template -->
        <x-collapse id="category-collapse" title="Category" icon="fa-solid fa-list" :active="request()->routeIs('category.*')">
            <ul class="pl-12 my-2">
                <li class="py-2">
                    <a href="{{ route('category.index') }}" class=" dark:text-white ">All Category</a>
                </li>
                <li class="py-2">
                    <a href="{{ route('category.create') }}" class=" dark:text-white ">Create Category</a>
                </li>
            </ul>
        </x-collapse>

        <x-collapse id="modifier-collapse" title="Modifier" icon="fa-solid fa-bowl-food" :active="request()->routeIs('modifier.*')">
            <ul class="pl-12 my-2">
                <li class="py-2">
                    <a href="{{ route('modifier.index') }}" class=" dark:text-white ">All Modifier</a>
                </li>
                <li class="py-2">
                    <a href="{{ route('modifier.create') }}" class=" dark:text-white ">Create Modifier</a>
                </li>
            </ul>
        </x-collapse>

        <x-collapse id="menu-collapse" title="Menu" icon="fa-solid fa-mug-hot" :active="request()->routeIs('menu.*')">
            <ul class="pl-12 my-2">
                <li class="py-2">
                    <a href="{{ route('menu.index') }}" class=" dark:text-white ">All Menu</a>
                </li>
                <li class="py-2">
                    <a href="{{ route('menu.create') }}" class=" dark:text-white ">Create Menu</a>
                </li>
            </ul>
        </x-collapse>
      @endcan

      @can('isAdmin')
        <li class="w-full mt-4">
          <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60">User Feedback</h6>
        </li>
      
        <li class="mt-0.5 w-full">
          <a class=" dark:text-white dark:opacity-80  text-base ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors {{ request()->routeIs('feedback.*') ? 'bg-yellow-100 font-semibold text-slate-600 rounded-lg py-3' : 'py-2' }}" href="{{ route('feedback.index') }}">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
              <i class="fa-solid fa-inbox"></i>
              {{-- <i class="fa-regular fa-envelope"></i> --}}
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Feedback</span>
          </a>
        </li>

        <li class="mt-0.5 w-full">
          <a class=" dark:text-white dark:opacity-80  text-base ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors {{ request()->routeIs('review.*') ? 'bg-yellow-100 font-semibold text-slate-600 rounded-lg py-3' : 'py-2' }}" href="{{ route('review.index') }}">
            <div class="mr-2 flex h-8 w-8 items-center ite justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="fa-solid fa-comments"></i>
              {{-- <i class="fa-regular fa-comments"></i> --}}
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Review</span>
          </a>
        </li>
      
        <li class="w-full mt-4">
          <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60">User Manage</h6>
        </li>

        <li class="mt-0.5 w-full">
          <a class=" dark:text-white dark:opacity-80  text-base ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors {{ request()->routeIs('user.*') ? 'bg-yellow-100 font-semibold text-slate-600 rounded-lg py-3' : 'py-2' }}" href="{{ route('user.index') }}">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
              <i class="fa-solid fa-users"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">User</span>
          </a>
        </li>

        <x-collapse id="role-collapse" title="Role" icon="fa-solid fa-user-gear" :active="request()->routeIs('role.*')">
            <ul class="pl-12 my-2">
                <li class="py-2">
                    <a href="{{ route('role.index') }}" class=" dark:text-white ">All Role</a>
                </li>
                <li class="py-2">
                    <a href="{{ route('role.create') }}" class=" dark:text-white ">Create Role</a>
                </li>
            </ul>
        </x-collapse>
      @endcan

      <li class="w-full mt-4">
        <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60">Account pages</h6>
      </li>

      <li class="mt-0.5 w-full">
        <a class=" dark:text-white dark:opacity-80  text-base ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors {{ request()->routeIs('profile') ? 'bg-yellow-100 font-semibold text-slate-600 rounded-lg py-3' : 'py-2' }}" href="{{ route('profile') }}">
          <div class="mr-2 flex h-8 w-8 items-center ite justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
            <i class="fa-solid fa-circle-user"></i>
            {{-- <i class="fa-regular fa-circle-user"></i> --}}
          </div>
          <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Profile</span>
        </a>
      </li>

      <li class="mt-0.5 w-full">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class=" dark:text-white dark:opacity-80  text-base ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors {{ request()->routeIs('logout') ? 'bg-yellow-100 font-semibold text-slate-600 rounded-lg py-3' : 'py-2' }}" href="">
            <div class="mr-2 flex h-8 w-8 items-center ite justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              {{-- <i class="fa-solid fa-right-from-bracket"></i> --}}
              <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Logout</span>
          </button>
        </form>
      </li>

      {{-- <li class="mt-0.5 w-full">
        <a class=" dark:text-white dark:opacity-80  text-base ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="./pages/sign-in.html">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
            <i class="relative top-0 text-base leading-normal text-orange-500 ni ni-single-copy-04"></i>
          </div>
          <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Sign In</span>
        </a>
      </li>

      <li class="mt-0.5 w-full">
        <a class=" dark:text-white dark:opacity-80  text-base ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="./pages/sign-up.html">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
            <i class="relative top-0 text-base leading-normal text-cyan-500 ni ni-collection"></i>
          </div>
          <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Sign Up</span>
        </a>
      </li> --}}

    </ul>
  </div>

</aside>