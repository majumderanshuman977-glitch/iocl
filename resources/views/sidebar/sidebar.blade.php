<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{set_active(['home'])}}">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/img/icons/dashboard.svg') }}" alt="img">
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/product.svg') }}" alt="img">
                        <span>Product</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('product/list') }}" class="{{set_active(['product/list'])}}">Product List</a></li>
                        <li><a href="{{ route('product/add') }}" class="{{set_active(['product/add'])}}">Add Product</a></li>
                        <li><a href="{{ route('product/categorylist') }}" class="{{set_active(['product/categorylist'])}}">Category List</a></li>
                        <li><a href="{{ route('product/addcategory') }}" class="{{set_active(['product/addcategory'])}}">Add Category</a></li>
                        <li><a href="{{ route('product/subcategorylist') }}" class="{{set_active(['product/subcategorylist'])}}">Sub Category List</a></li>
                        <li><a href="{{ route('product/subaddcategory') }}" class="{{set_active(['product/subaddcategory'])}}">Add Sub Category</a></li>
                        <li><a href="{{ route('product/brandlist') }}" class="{{set_active(['product/brandlist'])}}">Brand List</a></li>
                        <li><a href="{{ route('product/addbrand') }}" class="{{set_active(['product/addbrand'])}}">Add Brand</a></li>
                        <li><a href="{{ route('product/importproduct') }}" class="{{set_active(['product/importproduct'])}}">Import Products</a></li>
                        <li><a href="{{ route('product/barcode') }}" class="{{set_active(['product/barcode'])}}">Print Barcode</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/sales1.svg') }}" alt="img">
                        <span>Sales</span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('sales/list') }}" class="{{set_active(['sales/list','sales/details'])}}">Sales List</a></li>
                        <li><a href="{{ route('sales/edit') }}" class="{{set_active(['sales/edit'])}}">New Sales</a></li>
                        <li><a href="{{ route('sales/returnlist') }}" class="{{set_active(['sales/returnlist'])}}">Sales Return List</a></li>
                        <li><a href="{{ route('sales/return') }}" class="{{set_active(['sales/return'])}}">New Sales Return</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/expense1.svg') }}" alt="img">
                        <span>Expense</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('expenses/list') }}" class="{{set_active(['expenses/list'])}}">Expense List</a></li>
                        <li><a href="{{ route('expenses/create') }}" class="{{set_active(['expenses/create'])}}">Add Expense</a></li>
                        <li><a href="{{ route('expenses/category') }}" class="{{set_active(['expenses/category'])}}">Expense Category</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/transfer1.svg') }}" alt="img">
                        <span>Transfer</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('transfer/list') }}" class="{{set_active(['transfer/list'])}}">Transfer List</a></li>
                        <li><a href="{{ route('transfer/add') }}" class="{{set_active(['transfer/add'])}}">Add Transfer </a></li>
                        <li><a href="{{ route('transfer/import') }}" class="{{set_active(['transfer/import'])}}">Import Transfer </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/product.svg') }}" alt="img">
                        <span>Application</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('application/chat') }}" class="{{set_active(['application/chat'])}}">Chat</a></li>
                        <li><a href="{{ route('application/calendar') }}" class="{{set_active(['application/calendar'])}}">Calendar</a></li>
                        <li><a href="{{ route('application/email') }}" class="{{set_active(['application/email'])}}">Email</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/users1.svg') }}" alt="img">
                        <span>Users</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('user/new') }}" class="{{set_active(['user/new'])}}">New User </a></li>
                        <li><a href="{{ route('user/list') }}" class="{{set_active(['user/list'])}}">Users List</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/img/icons/settings.svg') }}" alt="img">
                        <span>Settings</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('setting/general') }}" class="{{set_active(['setting/general'])}}">General Settings</a></li>
                        <li><a href="{{ route('setting/email') }}" class="{{set_active(['setting/email'])}}">Email Settings</a></li>
                        <li><a href="{{ route('setting/payment') }}" class="{{set_active(['setting/payment'])}}">Payment Settings</a></li>
                        <li><a href="{{ route('setting/currency') }}" class="{{set_active(['setting/currency'])}}">Currency Settings</a></li>
                        <li><a href="{{ route('setting/grouppermissions') }}" class="{{set_active(['setting/grouppermissions','setting/createpermission'])}}">Group Permissions</a></li>
                        <li><a href="{{ route('setting/taxrates') }}" class="{{set_active(['setting/taxrates'])}}">Tax Rates</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>