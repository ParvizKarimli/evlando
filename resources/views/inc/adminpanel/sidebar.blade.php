<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="/storage/images/default/avatar.jpg" class="img-circle" alt="User Image" />
        </div>
        <div class="pull-left info">
            <p>
                Hello, {{ auth()->user()->name }}
                &nbsp;
                <span>
                    <a href="/users/{{auth()->user()->id}}/edit" title="Edit User">
                        <i class="fa fa-user-edit"></i>
                    </a>
                </span>
            </p>
            <p class="text-success">{{ auth()->user()->role }}</p>
        </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="active">
            <a href="/dashboard">
                <i class="fa fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
        </li>
        @if(auth()->user()->role === 'admin')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/users"><i class="fa fa-angle-double-right"></i> All</a></li>
                    <li><a href="/users/banned"><i class="fa fa-angle-double-right"></i> Banned</a></li>
                    <li><a href="/users/active"><i class="fa fa-angle-double-right"></i> Active</a></li>
                </ul>
            </li>
        @endif
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'mod')
            <li class="treeview">
                <a href="#">
                    <i class="far fa-newspaper">&nbsp;</i>
                    <span>Posts</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/posts"><i class="fa fa-angle-double-right"></i> All</a></li>
                    <li><a href="/posts/suspended"><i class="fa fa-angle-double-right"></i> Suspended</a></li>
                    <li><a href="/posts/active"><i class="fa fa-angle-double-right"></i> Active</a></li>
                </ul>
            </li>
        @endif
        <li class="treeview">
            <a href="#">
                <i class="fa fa-star"></i> <span>Bookmarks</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="/bookmarks"><i class="fa fa-angle-double-right"></i> All</a></li>
                <li><a href="/bookmarks/sale"><i class="fa fa-angle-double-right"></i> For Sale</a></li>
                <li><a href="/bookmarks/rent"><i class="fa fa-angle-double-right"></i> For Rent</a></li>
            </ul>
        </li>
    </ul>
</section>
