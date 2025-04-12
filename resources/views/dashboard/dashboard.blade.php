@extends('dashboard.layout.app')

@section('title-page','Dashboard')

@section('content')
  <!-- row 1 -->
        <div class="flex flex-wrap -mx-3">
          <!-- card1 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-lg dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border border-4 border-slate-800">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Today's Sales</p>
                      <h5 class="mb-2 font-bold dark:text-white">{{ $totalSalesToday }} sales</h5>
                      <p class="mb-0 dark:text-white dark:opacity-60">
                        <span class="text-sm font-bold leading-normal {{ $salesDifference > 0 ? 'text-green-500' : ($salesDifference < 0 ? 'text-red-500' : 'text-gray-500') }}">{{ $salesDifference > 0 ? '+' : ''}}{{ $salesDifference }}</span>
                        than yesterday
                      </p>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="flex justify-center items-center ms-auto w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-slate-700 to-slate-900">
                      <i class="fa-solid fa-money-bill-transfer text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- card2 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-lg dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border border-4 border-slate-800">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Today's Income</p>
                      <h5 class="mb-2 font-bold dark:text-white">Rp.{{ number_format($totalRevenueToday, 0, ',', '.') }}</h5>
                      <p class="mb-0 dark:text-white dark:opacity-60">
                        <span class="text-sm font-bold leading-normal {{ $revenueDifference > 0 ? 'text-green-500' : ($revenueDifference < 0 ? 'text-red-500' : 'text-gray-500') }}">{{ $revenueDifference > 0 ? '+' : ''}}{{ number_format($revenueDifference) }}</span>
                        than yesterday
                      </p>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="flex justify-center items-center ms-auto w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-slate-700 to-slate-900">
                      <i class="fa-solid fa-money-bill-1-wave text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- card3 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-lg dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border border-4 border-slate-800">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Sales This Month</p>
                      <h5 class="mb-2 font-bold dark:text-white">{{ $totalSalesMonth }}</h5>
                      <p class="mb-0 dark:text-white dark:opacity-60">
                        <span class="text-sm font-bold leading-normal {{ $salesMonthDifference > 0 ? 'text-green-500' : ($salesMonthDifference < 0 ? 'text-red-500' : 'text-gray-500') }}">{{ $salesMonthDifference > 0 ? '+' : ''}}{{ number_format($salesMonthDifference) }}</span>
                        than last month
                      </p>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="flex justify-center items-center ms-auto w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-slate-700 to-slate-900">
                      <i class="fa-solid fa-file-invoice text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- card4 -->
          <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-lg dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border border-4 border-slate-800">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Income This Month </p>
                      <h5 class="mb-2 font-bold dark:text-white">Rp.{{ number_format($totalRevenueMonth, 0, ',', '.') }}</h5>
                      <p class="mb-0 dark:text-white dark:opacity-60">
                        <span class="text-sm font-bold leading-normal {{ $revenueMonthDifference > 0 ? 'text-green-500' : ($revenueMonthDifference < 0 ? 'text-red-500' : 'text-gray-500') }}">{{ $revenueMonthDifference > 0 ? '+' : ''}}{{ number_format($revenueMonthDifference) }}</span>
                        than last month
                      </p>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="flex justify-center items-center ms-auto w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-slate-700 to-slate-900">
                      <i class="fa-solid fa-sack-dollar text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- cards row 2 -->
        <div class="flex flex-wrap mt-6 -mx-3">
          <div class="w-full max-w-full px-3 mt-0 mb-6 lg:w-7/12 lg:flex-none">
            <div class="border-black/12.5 dark:bg-slate-850 dark:shadow-dark-xl shadow-lg relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-solid bg-white bg-clip-border py-4 border-4 border-slate-800">
              <div class="flex justify-between p-6 pt-2 pb-0">
                <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid">
                  <h6 class="mb-0 font-sans text-base font-semibold leading-normal uppercase dark:text-white">Sales overview</h6>
                  <p class="mb-0 text-sm leading-normal dark:text-white dark:opacity-60">
                    <i class="fa fa-arrow-up text-emerald-500"></i>
                    <span class="font-semibold">4% more</span> in 2021
                  </p>
                </div>
                <!-- Select Option untuk Tahun -->
                <form method="GET" action="{{ route('dashboard') }}" class="mb-4 min-w-44">
                    <label for="year" class="block text-sm font-medium text-gray-700 w-full">Select Year:</label>
                    <select name="year" id="year" class="form-select mt-1 block w-full" onchange="this.form.submit()">
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </form>
              </div>
              <div class="flex-auto px-4 ">
                <div>
                  <!-- Chart Navigation -->
                    <div x-data="{ tab: 'sales' }">
                        <!-- Navbar -->
                        <ul class="flex border-b">
                            <li class="-mb-px mr-1">
                                <a href="#" @click.prevent="tab = 'sales'" :class="tab === 'sales' ? 'bg-yellow-100 rounded-t-lg border-b border-yellow-400 text-slate-700' : 'border-transparent text-gray-400 hover:text-gray-600 hover:bg-yellow-100 hover:rounded-t-lg hover:border-b hover:border-yellow-400'" class="inline-block py-2 px-4 font-semibold border-b-2">Penjualan</a>
                            </li>
                            <li class="-mb-px mr-1">
                                <a href="#" @click.prevent="tab = 'revenue'" :class="tab === 'revenue' ? 'bg-yellow-100 rounded-t-lg border-b border-yellow-400 text-slate-700' : 'border-transparent text-gray-400 hover:text-gray-600 hover:bg-yellow-100 hover:rounded-t-lg hover:border-b hover:border-yellow-400'" class="inline-block py-2 px-4 font-semibold border-b-2">Pendapatan</a>
                            </li>
                        </ul>

                        <!-- Chart Containers -->
                        <div class="mt-4">
                            <!-- Sales Chart -->
                            <div x-show="tab === 'sales'">
                                <canvas id="salesChart"></canvas>
                            </div>
                            <!-- Revenue Chart -->
                            <div x-show="tab === 'revenue'">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>

          <div class="w-full max-w-full px-3 lg:w-5/12 lg:flex-none">
            <div class="border-black/12.5 shadow-lg dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-solid bg-white bg-clip-border border-4 border-slate-800">
              <div class="px-8 py-6 text-base font-semibold pb-0 rounded-t-4">
                <h6 class="mb-0 dark:text-white uppercase">Feedback and Reviews</h6>
              </div>
              <div class="flex-auto p-4">
                <!-- Navbar untuk Tabel -->
                <div x-data="{ tab: 'feedback' }">
                    <!-- Navbar -->
                    <ul class="flex border-b">
                        <li class="-mb-px mr-1">
                            <a href="#" @click.prevent="tab = 'feedback'" :class="tab === 'feedback' ? 'bg-slate-100 rounded-t-xl border-b border-slate-400' : 'border-transparent text-gray-400 hover:text-gray-600 hover:bg-slate-100 hover:rounded-t-xl hover:border-b hover:border-slate-400'" class="inline-block py-2 px-4 font-semibold border-b-2">Feedback</a>
                        </li>
                        <li class="-mb-px mr-1">
                            <a href="#" @click.prevent="tab = 'review'" :class="tab === 'review' ? 'bg-slate-100 rounded-t-xl border-b border-slate-400' : 'border-transparent text-gray-400 hover:text-gray-600 hover:bg-slate-100 hover:rounded-t-xl hover:border-b hover:border-slate-400'" class="inline-block py-2 px-4 font-semibold border-b-2">Review</a>
                        </li>
                    </ul>

                    <!-- Tabel Containers -->
                    <div class="mt-6 overflow-x-auto">
                        <!-- Tabel Feedback -->
                        <div x-show="tab === 'feedback'">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="">
                                        <th class="py-2 px-4 bg-slate-100 font-bold text-start text-sm text-gray-600 border-b border-gray-300">User</th>
                                        <th class="py-2 px-4 bg-slate-100 font-bold text-start text-sm text-gray-600 border-b border-gray-300">Feedback</th>
                                        <th class="py-2 px-4 bg-slate-100 font-bold text-start text-sm text-gray-600 border-b border-gray-300">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($feedbacks as $feedback)
                                    <tr class="text-sm">
                                        <td class="py-3 px-3 border-b border-gray-300">{{ $feedback->user->name }}</td>
                                        <td class="py-3 px-3 border-b border-gray-300">{{ $feedback->message }}</td>
                                        <td class="py-3 px-3 border-b border-gray-300">{{ $feedback->created_at->format('d M Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Tabel Review -->
                        <div x-show="tab === 'review'">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-3 bg-slate-100 text-start font-bold text-sm text-gray-600 border-b border-gray-300">Product</th>
                                        <th class="py-2 px-3 bg-slate-100 text-start font-bold text-sm text-gray-600 border-b border-gray-300">User</th>
                                        <th class="py-2 px-3 bg-slate-100 text-start font-bold text-sm text-gray-600 border-b border-gray-300">Rating</th>
                                        <th class="py-2 px-3 bg-slate-100 text-start font-bold text-sm text-gray-600 border-b border-gray-300">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reviews as $review)
                                    <tr class="text-sm">
                                        <td class="py-3 px-3 border-b border-gray-300">{{ $review->menu->name }}</td>
                                        <td class="py-3 px-3 border-b border-gray-300">{{ $review->user->name }}</td>
                                        <td class="py-3 px-3 border-b border-gray-300">{{ $review->rating }}</td>
                                        <td class="py-3 px-3 border-b border-gray-300">{{ $review->created_at->format('d M Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            {{-- <div slider class="relative w-full h-full overflow-hidden rounded-2xl">
              <!-- slide 1 -->
              <div slide class="absolute w-full h-full transition-all duration-500">
                <img class="object-cover h-full" src="./assets/img/carousel-1.jpg" alt="carousel image" />
                <div class="block text-start ml-12 left-0 bottom-0 absolute right-[15%] pt-5 pb-5 text-white">
                  <div class="inline-block w-8 h-8 mb-4 text-center text-black bg-white bg-center rounded-lg fill-current stroke-none">
                    <i class="top-0.75 text-xxs relative text-slate-700 ni ni-camera-compact"></i>
                  </div>
                  <h5 class="mb-1 text-white">Get started with Argon</h5>
                  <p class="dark:opacity-80">There’s nothing I really wanted to do in life that I wasn’t able to get good at.</p>
                </div>
              </div>

              <!-- slide 2 -->
              <div slide class="absolute w-full h-full transition-all duration-500">
                <img class="object-cover h-full" src="./assets/img/carousel-2.jpg" alt="carousel image" />
                <div class="block text-start ml-12 left-0 bottom-0 absolute right-[15%] pt-5 pb-5 text-white">
                  <div class="inline-block w-8 h-8 mb-4 text-center text-black bg-white bg-center rounded-lg fill-current stroke-none">
                    <i class="top-0.75 text-xxs relative text-slate-700 ni ni-bulb-61"></i>
                  </div>
                  <h5 class="mb-1 text-white">Faster way to create web pages</h5>
                  <p class="dark:opacity-80">That’s my skill. I’m not really specifically talented at anything except for the ability to learn.</p>
                </div>
              </div>

              <!-- slide 3 -->
              <div slide class="absolute w-full h-full transition-all duration-500">
                <img class="object-cover h-full" src="./assets/img/carousel-3.jpg" alt="carousel image" />
                <div class="block text-start ml-12 left-0 bottom-0 absolute right-[15%] pt-5 pb-5 text-white">
                  <div class="inline-block w-8 h-8 mb-4 text-center text-black bg-white bg-center rounded-lg fill-current stroke-none">
                    <i class="top-0.75 text-xxs relative text-slate-700 ni ni-trophy"></i>
                  </div>
                  <h5 class="mb-1 text-white">Share with us your design tips!</h5>
                  <p class="dark:opacity-80">Don’t be afraid to be wrong because you can’t learn anything from a compliment.</p>
                </div>
              </div>

              <!-- Control buttons -->
              <button btn-next class="absolute z-10 w-10 h-10 p-2 text-lg text-white border-none opacity-50 cursor-pointer hover:opacity-100 far fa-chevron-right active:scale-110 top-6 right-4"></button>
              <button btn-prev class="absolute z-10 w-10 h-10 p-2 text-lg text-white border-none opacity-50 cursor-pointer hover:opacity-100 far fa-chevron-left active:scale-110 top-6 right-16"></button>
            </div> --}}
          </div>
        </div>

        <!-- cards row 3 -->

        <div class="flex flex-wrap mt-6 -mx-3">
          <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-solid shadow-lg dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border border-4 border-slate-800">
              <div class="py-6 px-10 pb-0 mb-0 rounded-t-4">
                <div class="flex justify-between font-bold">
                  <h6 class="mb-0 dark:text-white uppercase">Latest Order</h6>
                </div>
              </div>
              <div class="overflow-x-auto px-8">
                <table class="items-center w-full mb-4 align-top border-collapse border-gray-200 dark:border-white/40">
                  <tbody>
                    @forelse ($orders as $id => $order)
                    <tr>
                        <a href="{{ route('order.show',$order->id) }}">
                          <td class="p-2 align-middle bg-transparent border-b w-3/10 whitespace-nowrap dark:border-white/40">
                            <div class="flex items-center px-2 py-1">
                              <div class="">
                                <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Invoice:</p>
                                <h6 class="mb-0 text-sm leading-normal dark:text-white">{{ $order->invoice }}</h6>
                              </div>
                            </div>
                          </td>
                          <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                            <div class="text-center">
                              <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Date:</p>
                              <h6 class="mb-0 text-sm leading-normal dark:text-white">{{ $order->created_at }}</h6>
                            </div>
                          </td>
                          <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                            <div class="text-center">
                              <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Total Price:</p>
                              <h6 class="mb-0 text-sm leading-normal dark:text-white">Rp.{{ number_format($order->total_price) }}</h6>
                            </div>
                          </td>
                          <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                            <div class="flex-1 text-center">
                              <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Status:</p>
                              <h6 class="mb-0 text-sm leading-normal dark:text-white py-1 rounded-lg 
                                    @if ($order->status == 'awaiting_payment')
                                        bg-yellow-100 text-yellow-700
                                    @elseif ($order->status == 'being_prepared')
                                        bg-gray-100 text-gray-700
                                    @elseif ($order->status == 'ready_for_pickup')
                                        bg-blue-100 text-blue-700
                                    @elseif ($order->status == 'delivered')
                                        bg-green-100 text-green-700
                                    @else
                                        bg-gray-100 text-gray-700
                                    @endif
                                ">{{ $order->status }}</h6>
                            </div>
                          </td>
                        </a>
                      </tr>
                    @empty
                      <span> Belum ada order </span>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="w-full max-w-full px-3 mt-0 lg:w-5/12 lg:flex-none">
            <div class="border-black/12.5 shadow-lg dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-solid bg-white bg-clip-border border-4 border-slate-800">
              <div class="px-8 py-6 pb-0 rounded-t-4">
                <h6 class="mb-0 dark:text-white uppercase font-semibold">Most Favorite Menus</h6>
              </div>
              <div class="flex-auto p-4">
                <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                  @forelse ($mostOrderedMenu as $item)
                    <a href="{{ route('detail-menu',$item->menu->id) }}">
                      <li class="relative flex justify-between py-2 px-4 mb-2 border-0 rounded-t-lg rounded-xl text-inherit hover:bg-slate-50">
                        <div class="flex items-center">
                          <div class="max-w-16 aspect-video mr-4 text-center text-black bg-center shadow-sm fill-current stroke-none bg-cover align-middle rounded-lg overflow-hidden">
                            <img src="{{ Storage::url($item->menu->image) }}" class="object-cover object-center w-full h-full" alt="">
                          </div>
                          <div class="flex flex-col">
                            <h6 class="mb-1 text-base leading-normal text-slate-700 dark:text-white hover:underline">{{ $item->menu->name }}</h6>
                            <span class="text-xs leading-tight dark:text-white/80">Avalilable in stock, <span class="font-semibold">{{ $item->total_quantity }} sold</span></span>
                          </div>
                        </div>
                        <div class="flex">
                          <button class="group ease-in leading-pro text-xs rounded-3.5xl p-1.2 h-6.5 w-6.5 mx-0 my-auto inline-block cursor-pointer border-0 bg-transparent text-center align-middle font-bold text-slate-700 shadow-none transition-all dark:text-white"><i class="ni ease-bounce text-2xs group-hover:translate-x-1.25 ni-bold-right transition-all duration-200" aria-hidden="true"></i></button>
                        </div>
                      </li>
                    </a>
                  @empty
                    <span class="w-full">Belum ada menu</span>
                  @endforelse
                </ul>
              </div>
            </div>
          </div>
        </div>
@endsection

@push('script')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
  <script>
      // Sales Chart
      var ctxSales = document.getElementById('salesChart').getContext('2d');
      var salesChart = new Chart(ctxSales, {
          type: 'line',
          data: {
              labels: @json($months),
              datasets: [{
                  label: 'Total Penjualan',
                  data: @json($salesChartData),
                  borderColor: 'rgba(75, 192, 192, 1)',
                  backgroundColor: 'rgba(75, 192, 192, 0.2)',
                  fill: true,
              }]
          },
          options: {
              responsive: true,
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });

      // Revenue Chart
      var ctxRevenue = document.getElementById('revenueChart').getContext('2d');
      var revenueChart = new Chart(ctxRevenue, {
          type: 'line',
          data: {
              labels: @json($months),
              datasets: [{
                  label: 'Total Pendapatan (Rp)',
                  data: @json($revenueChartData),
                  borderColor: 'rgba(153, 102, 255, 1)',
                  backgroundColor: 'rgba(153, 102, 255, 0.2)',
                  fill: true,
              }]
          },
          options: {
              responsive: true,
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });
  </script>
@endpush

