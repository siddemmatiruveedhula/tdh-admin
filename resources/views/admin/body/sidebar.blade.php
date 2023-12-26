<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- User details -->


        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ url('/dashboard') }}" class="waves-effect">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if (Auth::user()->role->name == 'Admin' ||
                        Auth::user()->role->name == 'Director' ||
                        Auth::user()->role->name == 'General Manager')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-settings-4-fill"></i>
                            <span>Configuration</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('country.all') }}"> Countries</a></li>
                            <li><a href="{{ route('state.all') }}"> States</a></li>
                            <li><a href="{{ route('district.all') }}"> Districts</a></li>
                            <li><a href="{{ route('city.all') }}"> Cities</a></li>
                            <li><a href="{{ route('area.all') }}"> Areas</a></li>
                            <li><a href="{{ route('supplier.all') }}"> Organizations</a></li>
                            {{-- <li><a href="{{ route('customer-type.all') }}"> Customer Types</a></li> --}}
                            <li><a href="{{ route('customer-category-type.all') }}"> Customer Category Types</a></li>
                            

                           
                            <li><a href="{{ route('variant.all') }}">Variants</a></li>
                            
                            <li><a href="{{ route('storage.all') }}"> Storages</a></li>
                            <li><a href="{{ route('storage-type.all') }}">Storage Types</a></li>
                            <li><a href="{{ route('vehicle.all') }}">Vehicle Types</a></li>
                            <li><a href="{{ route('transportation.all') }}">Transportation</a></li>

                        </ul>
                    </li>


                    <!-- My MEnu -->
                    {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-database"></i>
                        <span>Storages</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('storage.all') }}"> Storages</a></li>

                    </ul>
                </li> --}}

                    {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-hotel-fill"></i>
                        <span>Organizations</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('supplier.all') }}"> Organizations</a></li>

                    </ul>
                </li> --}}

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-users"></i>
                            <span>Employees</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            
                            <li><a href="{{ route('department.index') }}">Departments</a></li>
                            <li><a href="{{ route('division.index') }}">Divisions</a></li>
                            <li><a href="{{ route('role.all') }}"> Roles</a></li>
                            <li><a href="{{ route('employee.all') }}">Employees List</a>
                            <li><a href="{{ route('employee.import-employees') }}">Import Employees</a>

                            </li>
                            <li>
                                <a href="{{ route('target.index') }}"> Targets</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('vehicles.all') }}" class="waves-effect">
                            <i class="fa fa-truck"></i>
                            <span>Vehicles</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('visitor.all') }}" class="waves-effect">
                            <i class="fa fa-user"></i>
                            <span>Visitors</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->name == 'Admin' ||
                        Auth::user()->role->name == 'Director' ||
                        Auth::user()->role->name == 'General Manager' ||
                        Auth::user()->role->name == 'Regional Sales Manager' ||
                        Auth::user()->role->name == 'Area Sales Manager')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-edit"></i>
                            <span>PJP</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('beat.index') }}"> Beats </a></li>
                            <li><a href="{{ route('assign_pjp.index') }}"> Assign Pjp </a></li>
                            <li><a href="{{ route('beat.report') }}"> PJP Reports </a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-shield-user-fill"></i>
                            <span>Customers</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('customer.all') }}">Customer Lists</a></li>
                            <li><a href="{{ route('customer.import-customers') }}">Import Customers</a></li>
                            {{-- <li><a href="{{ route('credit.customer') }}">Credit Customers</a></li>
                        <li><a href="{{ route('paid.customer') }}">Paid Customers</a></li>
                        <li><a href="{{ route('customer.wise.report') }}">Customer Wise Report</a></li> --}}

                        </ul>
                    </li>
                @endif



                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-delete-back-fill"></i>
                        <span>Units</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('unit.all') }}"> Units</a></li>

                    </ul>
                </li> --}}

                <!-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-apps-2-fill"></i>
                        <span>Category</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        

                    </ul>
                </li> -->

                @if (Auth::user()->role->name == 'Admin' ||
                        Auth::user()->role->name == 'Director' ||
                        Auth::user()->role->name == 'General Manager')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-reddit-fill"></i>
                            <span>Product</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">

                            <li><a href="{{ route('brand.all') }}">Brands</a></li>
                            <li><a href="{{ route('category.all') }}"> Categories</a></li>
                            <li><a href="{{ route('unit.all') }}"> Units</a></li>
                            <li><a href="{{ route('product.all') }}"> Products</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-oil-fill"></i>
                            <span>Store</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('purchase.all') }}"> Store</a></li>
                            <li><a href="{{ route('purchase.pending') }}">Approval Store</a></li>
                            <li><a href="{{ route('daily.purchase.report') }}">Daily Store Report</a></li>

                        </ul>
                    </li>


                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-compass-2-fill"></i>
                            <span>Order</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <!-- <li><a href="{{ route('order.all') }}"> Orders</a></li> -->
                            <li><a href="{{ route('order.add') }}">Create Order</a></li>
                            <li><a href="{{ route('order.pending.list') }}">Pending Orders</a></li>
                            <li><a href="{{ route('print.order.list') }}">Approved Orders</a></li>
                            <li><a href="{{ route('daily.order.report') }}">Daily Order Report</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('invoice.list') }}" class="waves-effect">
                            <i class="fa fa-file-text-o"></i>
                            <span>Invoices</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fa fa-inr"></i>
                            <span>Payments</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('payment.index') }}"> Payments List </a></li>
                            <li><a href="{{ route('payment.partial-adjust') }}"> Partial Adjusted </a></li>
                            <li><a href="{{ route('payment.fully-adjust') }}"> Fully Adjusted </a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('outstanding.index') }}" class="waves-effect">
                            <i class="fa fa-file-text-o"></i>
                            <span>Outstandings</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ledger.list') }}" class="waves-effect">
                            <i class="fa fa-file-text-o"></i>
                            <span>Ledger</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('saleorder.index') }}" class="waves-effect">
                            <i class="fa fa-file-text-o"></i>
                            <span>Factory Sale</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->name == 'Admin' ||
                        Auth::user()->role->name == 'Director' ||
                        Auth::user()->role->name == 'General Manager' ||
                        Auth::user()->role->name == 'Regional Sales Manager' ||
                        Auth::user()->role->name == 'Area Sales Manager')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="dripicons-to-do"></i>
                            <span>Attendances</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('holiday.index') }}">Holidays</a></li>
                            <li><a href="{{ route('leavetype.all') }}">Leave Types</a></li>
                            <li><a href="{{ route('leave.index') }}">Leaves</a></li>
                            <li><a href="{{ route('sheet-report') }}">Month Wise Report</a></li>
                            <li><a href="{{ route('attendance') }}">Date Wise Report</a></li>

                        </ul>
                    </li>
                @endif



                {{-- <li class="menu-title">Stock</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-gift-fill"></i>
                        <span>Manage Stock</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('stock.report') }}">Stock Report</a></li>
                        <li><a href="{{ route('stock.supplier.wise') }}">Company / Product Wise </a></li>

                    </ul>
                </li> --}}

                <!-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>Support</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-starter.html">Starter Page</a></li>
                        <li><a href="pages-timeline.html">Timeline</a></li>
                        <li><a href="pages-directory.html">Directory</a></li>
                        <li><a href="pages-order.html">Order</a></li>
                        <li><a href="pages-404.html">Error 404</a></li>
                        <li><a href="pages-500.html">Error 500</a></li>
                    </ul>
                </li> -->






            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
