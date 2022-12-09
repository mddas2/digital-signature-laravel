<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
        </button>
        </span>
    </div>
    
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboards</li>
                <li>
                    <a href="{{route('home')}}">
                        <i class="metismenu-icon pe-7s-rocket"></i>Dashboard
                    </a>
                </li>
                @if(Auth::user()->is_enrolled == '1')
                <li class="app-sidebar__heading">Accounts </li>
                <li>
                    <li>
                        <a href="{{route('add_payee')}}">
                            <i class="metismenu-icon pe-7s-add-user"></i> Add Payee
                        </a>
                    </li>
                    <li>
                        <a href="{{route('funds_transfer')}}">
                            <i class="metismenu-icon pe-7s-cash"></i> Funds Transfer
                        </a>
                    </li>
                    <li>
                        <a href="{{route('account_summary')}}">
                            <i class="metismenu-icon pe-7s-menu"></i> Account Summary
                        </a>
                    </li>
                    <li>
                        <a href="{{route('file_sign_list')}}">
                            <i class="metismenu-icon pe-7s-menu"></i> File Signing
                        </a>
                    </li>
                </li>
                @endif
                <li class="app-sidebar__heading">Settings </li>
                <li>
                    <li>
                        <a href="{{ route('enroll_dsc')}}">
                            <i class="metismenu-icon pe-7s-id"></i>Enroll DSC
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('re_enroll_dsc')}}">
                            <i class="metismenu-icon pe-7s-refresh"></i> Reenroll DSC
                        </a>
                    </li>
                    <li>
                        <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="metismenu-icon pe-7s-back"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </li>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    var currentUrl = "<?php echo url()->current();?>";
    $(document).ready(function(){
        $('a.mm-active').removeClass('mm-active');
        $('a[href="'+currentUrl+'"').addClass('mm-active');
    });
    
</script>