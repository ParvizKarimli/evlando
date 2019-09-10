<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="/storage/images/default/avatar.jpg" class="img-circle" alt="User Image" />
        </div>
        <div class="pull-left info">
            <p>
                {{ __('dashboard_sidebar.hello') }}, {{ auth()->user()->name }}
                &nbsp;
                <span>
                    <a href="/users/{{auth()->user()->id}}/edit" title="{{ __('users.edit_user') }}">
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
                <i class="fa fa-tachometer-alt"></i> <span>{{ __('navbar.dashboard') }}</span>
            </a>
        </li>
        @if(auth()->user()->role === 'admin')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>{{ __('users.users') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/users"><i class="fa fa-angle-double-right"></i> {{ __('users.all') }}</a></li>
                    <li><a href="/users/banned"><i class="fa fa-angle-double-right"></i> {{ __('users.banned_list') }}</a></li>
                    <li><a href="/users/active"><i class="fa fa-angle-double-right"></i> {{ __('users.active') }}</a></li>
                </ul>
            </li>
        @endif
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'mod')
            <li class="treeview">
                <a href="#">
                    <i class="far fa-newspaper">&nbsp;</i>
                    <span>{{ __('posts.posts') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/posts"><i class="fa fa-angle-double-right"></i> {{ __('users.all') }}</a></li>
                    <li><a href="/posts/suspended"><i class="fa fa-angle-double-right"></i> {{ __('posts.suspended_list') }}</a></li>
                    <li><a href="/posts/active"><i class="fa fa-angle-double-right"></i> {{ __('users.active') }}</a></li>
                </ul>
            </li>
        @endif
        <li class="treeview">
            <a href="#">
                <i class="fa fa-star"></i> <span>{{ __('bookmarks.bookmarks') }}</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="/bookmarks"><i class="fa fa-angle-double-right"></i> {{ __('users.all') }}</a></li>
                <li><a href="/bookmarks/sale"><i class="fa fa-angle-double-right"></i> {{ __('posts.for_sale') }}</a></li>
                <li><a href="/bookmarks/rent"><i class="fa fa-angle-double-right"></i> {{ __('posts.for_rent') }}</a></li>
            </ul>
        </li>
    </ul>
</section>
