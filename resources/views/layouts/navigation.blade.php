<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link style="text-decoration: none;" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        الصفحة الرئيسية
                    </x-nav-link>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <x-nav-link style="text-decoration: none;">
                                    <div>الابقار</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </x-nav-link>
                            </x-slot>

                            <x-slot name="content">


                                @if (auth()->user()->can('create-cow') ||
                                        auth()->user()->can('edit-cow') ||
                                        auth()->user()->can('delete-cow'))
                                    <x-dropdown-link :href="route('cow.index')" style="text-decoration: none;">
                                        {{ __('الابقار') }}
                                    </x-dropdown-link>
                                @endif


                                @if (auth()->user()->can('create-medicine') ||
                                        auth()->user()->can('edit-medicine') ||
                                        auth()->user()->can('delete-medicine'))
                                    <x-dropdown-link :href="route('medicines.index')" style="text-decoration: none;">
                                        {{ __('مواعيد الدواء للبقر') }}
                                    </x-dropdown-link>
                                @endif


                                @if (auth()->user()->can('create-breed') ||
                                        auth()->user()->can('edit-breed') ||
                                        auth()->user()->can('delete-breed'))
                                    <x-dropdown-link :href="route('breeds.index')" style="text-decoration: none;">
                                        {{ __('  التلقحيات للبقر') }}
                                    </x-dropdown-link>
                                @endif
                                @if (auth()->user()->can('create-milk') ||
                                        auth()->user()->can('edit-milk') ||
                                        auth()->user()->can('delete-milk'))
                                    <x-dropdown-link :href="route('milks.index')" style="text-decoration: none;">
                                        {{ __(' كميات الحليب للبقر') }}
                                    </x-dropdown-link>
                                @endif
                                @if (auth()->user()->can('create-cowbirth') ||
                                        auth()->user()->can('edit-cowbirth') ||
                                        auth()->user()->can('delete-cowbirth'))
                                    <x-dropdown-link :href="route('cowbirth.index')" style="text-decoration: none;">
                                        {{ __(' مواليد البقر') }}
                                    </x-dropdown-link>
                                @endif
                                @if (auth()->user()->can('create-cowexpenses') ||
                                        auth()->user()->can('edit-cowexpenses') ||
                                        auth()->user()->can('delete-cowexpenses'))
                                    <x-dropdown-link :href="route('cowexpenses.index')" style="text-decoration: none;">
                                        {{ __(' مصاريف البقر') }}
                                    </x-dropdown-link>
                                @endif


                                <!-- Authentication -->

                            </x-slot>
                        </x-dropdown>
                    </div>




                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <x-nav-link style="text-decoration: none;">
                                    <div> العملاء والموردون</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </x-nav-link>
                            </x-slot>

                            <x-slot name="content">
                                @if (auth()->user()->can('create-supplier') ||
                                        auth()->user()->can('edit-supplier') ||
                                        auth()->user()->can('delete-supplier'))
                                    <x-dropdown-link :href="route('suppliers.index')" style="text-decoration: none;">
                                        {{ __(' الموردون') }}
                                    </x-dropdown-link>
                                @endif
                                @if (auth()->user()->can('create-customer') ||
                                        auth()->user()->can('edit-customer') ||
                                        auth()->user()->can('delete-customer'))
                                    <x-dropdown-link :href="route('customers.index')" style="text-decoration: none;">
                                        {{ __('العملاء') }}
                                    </x-dropdown-link>
                                @endif
                                <!-- Authentication -->


                            </x-slot>
                        </x-dropdown>
                    </div>




                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <x-nav-link style="text-decoration: none;">
                                    <div> العمليات المحاسبية والمنتجات</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </x-nav-link>
                            </x-slot>

                            <x-slot name="content">

                                @if (auth()->user()->can('create-purchases') ||
                                        auth()->user()->can('edit-purchases') ||
                                        auth()->user()->can('delete-purchases'))
                                    <x-dropdown-link :href="route('purchases.index')" style="text-decoration: none;">
                                        {{ __(' المشتريات') }}
                                    </x-dropdown-link>
                                @endif
                                @if (auth()->user()->can('create-product') ||
                                        auth()->user()->can('edit-product') ||
                                        auth()->user()->can('delete-product'))
                                    <x-dropdown-link :href="route('products.index')" style="text-decoration: none;">
                                        {{ __(' المنتجات') }}
                                    </x-dropdown-link>
                                @endif
                                @if (auth()->user()->can('create-expenses') ||
                                        auth()->user()->can('edit-expenses') ||
                                        auth()->user()->can('delete-expenses'))
                                    <x-dropdown-link :href="route('expenses.index')" style="text-decoration: none;">
                                        {{ __(' المصروفات') }}
                                    </x-dropdown-link>
                                @endif
                                @if (auth()->user()->can('create-sales') ||
                                        auth()->user()->can('edit-sales') ||
                                        auth()->user()->can('delete-sales'))
                                    <x-dropdown-link :href="route('sales.index')" style="text-decoration: none;">
                                        {{ __(' المبيعات') }}
                                    </x-dropdown-link>
                                @endif
                                <!-- Authentication -->

                            </x-slot>
                        </x-dropdown>
                    </div>
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <x-nav-link style="text-decoration: none;">
                                    <div> طرق الدفع والحسابات</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </x-nav-link>
                            </x-slot>

                            <x-slot name="content">

                                @if (auth()->user()->can('create-paymentmethod') ||
                                        auth()->user()->can('edit-paymentmethod') ||
                                        auth()->user()->can('delete-paymentmethod'))
                                    <x-dropdown-link :href="route('paymentmethods.index')" style="text-decoration: none;">
                                        {{ __(' طرق الدفع') }}
                                    </x-dropdown-link>
                                @endif
                                @if (auth()->user()->can('create-account') ||
                                        auth()->user()->can('edit-account') ||
                                        auth()->user()->can('delete-account'))
                                    <x-dropdown-link :href="route('accounts.index')" style="text-decoration: none;">
                                        {{ __(' الحسابات') }}
                                    </x-dropdown-link>
                                @endif
                                <!-- Authentication -->

                            </x-slot>
                        </x-dropdown>
                    </div>

                    {{-- <x-nav-link style="text-decoration: none;" :href="route('purchases.index')" :active="request()->routeIs('purchases.index')">
                        المشتريات
                    </x-nav-link>
                    <x-nav-link style="text-decoration: none;" :href="route('sales.index')" :active="request()->routeIs('sales.index')">
                        المبيعات
                    </x-nav-link>
                    <x-nav-link style="text-decoration: none;" :href="route('expenses.index')" :active="request()->routeIs('expenses.index')">
                        المصروفات
                    </x-nav-link> --}}


                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <x-nav-link style="text-decoration: none;">
                                    <div> الصلاحيات والمستخدمين</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </x-nav-link>
                            </x-slot>

                            <x-slot name="content">
                                @if (auth()->user()->can('create-roles') ||
                                        auth()->user()->can('edit-roles') ||
                                        auth()->user()->can('delete-roles'))
                                    <x-dropdown-link :href="route('roles.index')" style="text-decoration: none;">
                                        {{ __(' الصلاحيات') }}
                                    </x-dropdown-link>
                                @endif

                                @if (auth()->user()->can('create-users') ||
                                        auth()->user()->can('edit-users') ||
                                        auth()->user()->can('delete-users'))
                                    <x-dropdown-link :href="route('users.index')" style="text-decoration: none;">
                                        {{ __(' المستخدمين') }}
                                    </x-dropdown-link>
                                @endif



                                <!-- Authentication -->

                            </x-slot>
                        </x-dropdown>
                    </div>


                </div>
            </div>


            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" style="text-decoration: none;">
                            {{ __('الملف الشخصي') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" style="text-decoration: none;"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('تسجيل خروج') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('الصفحة الرئيسية') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cow.index')" :active="request()->routeIs('cow.index')">
                {{ __('الابقار') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('medicines.index')" :active="request()->routeIs('medicines.index')">
                {{ __('مواعيد الدواء للبقر') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('breeds.index')" :active="request()->routeIs('breeds.index')">
                {{ __('تلقحيات البقر') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('milks.index')" :active="request()->routeIs('milks.index')">
                {{ __('كميات الحليب للبقر') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cowbirth.index')" :active="request()->routeIs('cowbirth.index')">
                {{ __('مواليد البقر') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cowexpenses.index')" :active="request()->routeIs('cowexpenses.index')">
                {{ __('مصاريف البقر') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.index')">
                {{ __('العملاء') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.index')">
                {{ __('الموردين') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                {{ __('المنتجات') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.index')">
                {{ __('المشتريات') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.index')">
                {{ __('المصروفات') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')">
                {{ __('المبيعات') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('accounts.index')" :active="request()->routeIs('accounts.index')">
                {{ __('الحسابات') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.index')">
                {{ __('الصلاحيات') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                {{ __('المستخدمين') }}
            </x-responsive-nav-link>


        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('الملف الشخصي') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('تسجيل خروج ') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
