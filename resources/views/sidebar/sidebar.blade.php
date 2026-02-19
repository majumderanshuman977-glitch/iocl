<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ set_active(['home']) }}">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/img/icons/meter.svg') }}" alt="img">
                        <span>Dashboard</span>
                    </a>
                </li>
                {{-- <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/product.svg') }}" alt="img">
                        <span>Product</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('product/list') }}" class="{{ set_active(['product/list']) }}">Product
                                List</a></li>
                        <li><a href="{{ route('product/add') }}" class="{{ set_active(['product/add']) }}">Add
                                Product</a></li>
                        <li><a href="{{ route('product/categorylist') }}"
                                class="{{ set_active(['product/categorylist']) }}">Category List</a></li>
                        <li><a href="{{ route('product/addcategory') }}"
                                class="{{ set_active(['product/addcategory']) }}">Add Category</a></li>
                        <li><a href="{{ route('product/subcategorylist') }}"
                                class="{{ set_active(['product/subcategorylist']) }}">Sub Category List</a></li>
                        <li><a href="{{ route('product/subaddcategory') }}"
                                class="{{ set_active(['product/subaddcategory']) }}">Add Sub Category</a></li>
                        <li><a href="{{ route('product/brandlist') }}"
                                class="{{ set_active(['product/brandlist']) }}">Brand List</a></li>
                        <li><a href="{{ route('product/addbrand') }}"
                                class="{{ set_active(['product/addbrand']) }}">Add Brand</a></li>
                        <li><a href="{{ route('product/importproduct') }}"
                                class="{{ set_active(['product/importproduct']) }}">Import Products</a></li>
                        <li><a href="{{ route('product/barcode') }}"
                                class="{{ set_active(['product/barcode']) }}">Print Barcode</a></li>
                    </ul>
                </li> --}}
                {{-- <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/sales1.svg') }}" alt="img">
                        <span>Sales</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('sales/list') }}"
                                class="{{ set_active(['sales/list', 'sales/details']) }}">Sales List</a></li>
                        <li><a href="{{ route('sales/edit') }}" class="{{ set_active(['sales/edit']) }}">New Sales</a>
                        </li>
                        <li><a href="{{ route('sales/returnlist') }}"
                                class="{{ set_active(['sales/returnlist']) }}">Sales Return List</a></li>
                        <li><a href="{{ route('sales/return') }}" class="{{ set_active(['sales/return']) }}">New Sales
                                Return</a></li>
                    </ul>
                </li> --}}
                {{-- <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/expense1.svg') }}" alt="img">
                        <span>Expense</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('expenses/list') }}" class="{{ set_active(['expenses/list']) }}">Expense
                                List</a></li>
                        <li><a href="{{ route('expenses/create') }}" class="{{ set_active(['expenses/create']) }}">Add
                                Expense</a></li>
                        <li><a href="{{ route('expenses/category') }}"
                                class="{{ set_active(['expenses/category']) }}">Expense Category</a></li>
                    </ul>
                </li> --}}
                {{-- <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/transfer1.svg') }}" alt="img">
                        <span>Transfer</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('transfer/list') }}"
                                class="{{ set_active(['transfer/list']) }}">Transfer List</a></li>
                        <li><a href="{{ route('transfer/add') }}" class="{{ set_active(['transfer/add']) }}">Add
                                Transfer </a></li>
                        <li><a href="{{ route('transfer/import') }}"
                                class="{{ set_active(['transfer/import']) }}">Import Transfer </a></li>
                    </ul>
                </li> --}}
                {{-- <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/product.svg') }}" alt="img">
                        <span>Application</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('application/chat') }}"
                                class="{{ set_active(['application/chat']) }}">Chat</a></li>
                        <li><a href="{{ route('application/calendar') }}"
                                class="{{ set_active(['application/calendar']) }}">Calendar</a></li>
                        <li><a href="{{ route('application/email') }}"
                                class="{{ set_active(['application/email']) }}">Email</a></li>
                    </ul>
                </li> --}}

                @can('view_users')
                    <li class="submenu">
                        <a href="javascript:void(0);">
                            <img src="{{ asset('assets/img/icons/user_new.svg') }}" alt="img">
                            <span>Users</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul>
                            <li><a href="{{ route('user.superadmin') }}"
                                    class="{{ set_active(['user/super-admin', 'user/super-admin/create', 'user/super-admin/edit/{id}', 'user/permissions/super-admin']) }}">Super
                                    Admin</a>
                            </li>
                            <li><a href="{{ route('user.subadmin') }}"
                                    class="{{ set_active(['user/sub-admin', 'user/sub-admin/create', 'user/sub-admin/edit/{id}', 'user/permissions/sub-admin']) }}">Sub
                                    Admin</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Location  --}}
                <li>
                    <a href="{{ route('location.list') }}"
                        class="{{ set_active(['location/list', 'location/create', 'location/edit/{id}']) }}">
                        <img src="{{ asset('assets/img/icons/location.svg') }}" alt="img">
                        <span>Locations</span>
                    </a>
                </li>



                {{-- Delivery Boys --}}
                <li>
                    <a href="{{ route('delivery-boy.list') }}"
                        class="{{ set_active(['delivery-boy/list', 'delivery-boy/create', 'delivery-boy/edit/{id}']) }}">
                        <img src="{{ asset('assets/img/icons/delivery.svg') }}" alt="img">
                        <span>Delivery Boys</span>
                    </a>
                </li>

                {{-- Cylinder Categories --}}
                {{-- <li>
                    <a href="{{ route('cylinder-category.list') }}"
                        class="{{ set_active(['cylinder-category/list', 'cylinder-category/create', 'cylinder-category/edit/{id}']) }}">
                        <img src="{{ asset('assets/img/icons/users1.svg') }}" alt="img">
                        <span>Cylinder Categories</span>
                    </a>
                </li> --}}

                {{-- Products List --}}
                <li>
                    <a href="{{ route('products.list') }}"
                        class="{{ set_active(['products/list', 'products/create', 'products/edit/{id}']) }}">
                        <img src="{{ asset('assets/img/icons/products.svg') }}" alt="img">
                        <span>Products</span>
                    </a>
                </li>

                {{-- New Connection  --}}
                {{-- <li>
                    <a href="{{ route('new-connection.index') }}"
                        class="{{ set_active(['new-connection', 'new-connection/create', 'new-connection/{id}/edit']) }}">
                        <img src="{{ asset('assets/img/icons/users1.svg') }}" alt="img">
                        <span>New Connections</span>
                    </a>
                </li> --}}
                {{-- submenu  --}}
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/users1.svg') }}" alt="img">
                        <span>New Connections</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul>
                        <li><a href="{{ route('customers.index') }}"
                                class="{{ set_active(['new-connection/customers']) }}">
                                Customers</a>
                        </li>

                    </ul>
                </li>

                {{-- Roles and Permission  --}}

                {{-- <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/settings.svg') }}" alt="img">
                        <span>Roles & Permissions</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('roles.list') }}"
                                class="{{ set_active(['role/list', 'role/create', 'role/edit']) }}">
                                Roles List
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('permission.list') }}"
                                class="{{ set_active(['permission/list', 'permission/create', 'permission/edit']) }}">
                                Permissions List
                            </a>
                        </li>
                    </ul>
                </li> --}}

                {{-- <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/settings.svg') }}" alt="img">
                        <span>Settings</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>

                        <li><a href="{{ route('setting/general') }}"
                                class="{{ set_active(['setting/general']) }}">General Settings</a></li>
                        <li><a href="{{ route('setting/email') }}" class="{{ set_active(['setting/email']) }}">Email
                                Settings</a></li>
                        <li><a href="{{ route('setting/payment') }}"
                                class="{{ set_active(['setting/payment']) }}">Payment Settings</a></li>
                        <li><a href="{{ route('setting/currency') }}"
                                class="{{ set_active(['setting/currency']) }}">Currency Settings</a></li>
                        <li><a href="{{ route('setting/grouppermissions') }}"
                                class="{{ set_active(['setting/grouppermissions', 'setting/createpermission']) }}">Group
                                Permissions</a></li>
                        <li><a href="{{ route('setting/taxrates') }}"
                                class="{{ set_active(['setting/taxrates']) }}">Tax Rates</a></li>
                    </ul>
                </li> --}}


            </ul>
        </div>
    </div>
</div>
