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
                        <li class="header">
                            {{ __('dashboard_navbar.number_of_reports_text',
                                [
                                    'n' => $number_of_unseen_reports,
                                    's' => str_plural('report', $number_of_unseen_reports)
                                ]
                            ) }}
                        </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu reports-container">
                                @foreach($unseen_reports as $unseen_report)
                                    <li class="reports-item"><!-- start message -->
                                        <a href="/reports/{{$unseen_report->id}}">
                                            <h4>
                                                @if($unseen_report->category === 1)
                                                    {{ __('reports.spam') }}
                                                @elseif($unseen_report->category === 2)
                                                    {{ __('reports.nudity') }}
                                                @elseif($unseen_report->category === 3)
                                                    {{ __('reports.hate_speech') }}
                                                @elseif($unseen_report->category === 4)
                                                    {{ __('reports.other') }}
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
                        <li class="footer"><a href="/reports">{{ __('dashboard_navbar.see_all_reports') }}</a></li>
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
                            <small>{{ __('dashboard_navbar.member_since') }} {{ date('M. Y', strtotime(auth()->user()->created_at)) }}</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                        <div class="col-xs-4 text-center">
                            <a href="/bookmarks">{{ __('bookmarks.bookmarks') }}</a>
                        </div>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="/users/{{auth()->user()->id}}" class="btn btn-default btn-flat">{{ __('dashboard_navbar.profile') }}</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                            >
                                {{ __('navbar.log_out') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>
            </li>
            <!-- Language Setting Links -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ App::getLocale() }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href=""
                           onclick="event.preventDefault();
                           document.getElementById('lang-set-form-en').submit();"
                        >
                            en
                        </a>
                        {!! Form::open(['action' => ['LanguagesController@set'], 'method' => 'POST', 'id' => 'lang-set-form-en']) !!}
                            {!! Form::hidden('lang', 'en') !!}
                        {!! Form::close() !!}
                    </li>
                    <li>
                        <a href=""
                           onclick="event.preventDefault();
                           document.getElementById('lang-set-form-az').submit();"
                        >
                            az
                        </a>
                        {!! Form::open(['action' => ['LanguagesController@set'], 'method' => 'POST', 'id' => 'lang-set-form-az']) !!}
                            {!! Form::hidden('lang', 'az') !!}
                        {!! Form::close() !!}
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
