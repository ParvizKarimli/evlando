<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>
    <div class="navbar-right">
        <ul class="nav navbar-nav">
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'mod')
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-life-ring" title="Reports"></i>
                        <span class="label label-danger">{{ $number_of_unseen_reports }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">There are {{ $number_of_unseen_reports }} unseen {{ str_plural('report', $number_of_unseen_reports) }}</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu reports-container">
                                @foreach($unseen_reports as $unseen_report)
                                    <li class="reports-item"><!-- start message -->
                                        <a href="/reports/{{$unseen_report->id}}">
                                            <h4>
                                                @if($unseen_report->category === 1)
                                                    Spam
                                                @elseif($unseen_report->category === 2)
                                                    Nudity
                                                @elseif($unseen_report->category === 3)
                                                    Hate speech
                                                @elseif($unseen_report->category === 4)
                                                    Other
                                                @endif
                                                <small><i class="far fa-clock"></i> {{ $unseen_report->created_at }}</small>
                                            </h4>
                                            <p>{{ str_limit($unseen_report->message, $limit = 25, $end = '...') }}</p>
                                        </a>
                                    </li><!-- end message -->
                                @endforeach
                                {{ $unseen_reports->links() }}
                            </ul>
                        </li>
                        <li class="footer"><a href="/reports">See All Reports</a></li>
                    </ul>
                </li>
            @endif
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i>
                    <span>{{auth()->user()->name }} <i class="caret"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header bg-light-blue">
                        <img src="/storage/images/default/avatar.jpg" class="img-circle" alt="User Image" />
                        <p>
                            {{auth()->user()->name }} - {{auth()->user()->role }}
                            <small>Member since {{ date('M. Y', strtotime(auth()->user()->created_at)) }}</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                        <div class="col-xs-4 text-center">
                            <a href="/bookmarks">Bookmarks</a>
                        </div>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="/users/{{auth()->user()->id}}" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                            >
                                Log Out
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
