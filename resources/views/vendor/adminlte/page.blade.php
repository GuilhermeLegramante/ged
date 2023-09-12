@extends('adminlte::master')

@section('adminlte_css_pre')
<link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<link rel="icon" sizes="192x192" href="https://hardsoft.s3.sa-east-1.amazonaws.com/_cantina-store/icone-cantina-store.jpg">
@stop

@section('adminlte_css')
@stack('css')
@yield('css')
@stop

@section('classes_body',
(config('adminlte.sidebar_mini', true) === true ?
'sidebar-mini ' :
(config('adminlte.sidebar_mini', true) == 'md' ?
'sidebar-mini sidebar-mini-md ' : '')
) .
(config('adminlte.layout_topnav') || View::getSection('layout_topnav') ? 'layout-top-nav ' : '') .
(config('adminlte.layout_boxed') ? 'layout-boxed ' : '') .
(!config('adminlte.layout_topnav') && !View::getSection('layout_topnav') ?
(config('adminlte.layout_fixed_sidebar') ? 'layout-fixed ' : '') .
(config('adminlte.layout_fixed_navbar') === true ?
'layout-navbar-fixed ' :
(isset(config('adminlte.layout_fixed_navbar')['xs']) ? (config('adminlte.layout_fixed_navbar')['xs'] == true ?
'layout-navbar-fixed ' : 'layout-navbar-not-fixed ') : '') .
(isset(config('adminlte.layout_fixed_navbar')['sm']) ? (config('adminlte.layout_fixed_navbar')['sm'] == true ?
'layout-sm-navbar-fixed ' : 'layout-sm-navbar-not-fixed ') : '') .
(isset(config('adminlte.layout_fixed_navbar')['md']) ? (config('adminlte.layout_fixed_navbar')['md'] == true ?
'layout-md-navbar-fixed ' : 'layout-md-navbar-not-fixed ') : '') .
(isset(config('adminlte.layout_fixed_navbar')['lg']) ? (config('adminlte.layout_fixed_navbar')['lg'] == true ?
'layout-lg-navbar-fixed ' : 'layout-lg-navbar-not-fixed ') : '') .
(isset(config('adminlte.layout_fixed_navbar')['xl']) ? (config('adminlte.layout_fixed_navbar')['xl'] == true ?
'layout-xl-navbar-fixed ' : 'layout-xl-navbar-not-fixed ') : '')
) .
(config('adminlte.layout_fixed_footer') === true ?
'layout-footer-fixed ' :
(isset(config('adminlte.layout_fixed_footer')['xs']) ? (config('adminlte.layout_fixed_footer')['xs'] == true ?
'layout-footer-fixed ' : 'layout-footer-not-fixed ') : '') .
(isset(config('adminlte.layout_fixed_footer')['sm']) ? (config('adminlte.layout_fixed_footer')['sm'] == true ?
'layout-sm-footer-fixed ' : 'layout-sm-footer-not-fixed ') : '') .
(isset(config('adminlte.layout_fixed_footer')['md']) ? (config('adminlte.layout_fixed_footer')['md'] == true ?
'layout-md-footer-fixed ' : 'layout-md-footer-not-fixed ') : '') .
(isset(config('adminlte.layout_fixed_footer')['lg']) ? (config('adminlte.layout_fixed_footer')['lg'] == true ?
'layout-lg-footer-fixed ' : 'layout-lg-footer-not-fixed ') : '') .
(isset(config('adminlte.layout_fixed_footer')['xl']) ? (config('adminlte.layout_fixed_footer')['xl'] == true ?
'layout-xl-footer-fixed ' : 'layout-xl-footer-not-fixed ') : '')
)
: ''
) .
(config('adminlte.sidebar_collapse') || View::getSection('sidebar_collapse') ? 'sidebar-collapse ' : '') .
(config('adminlte.right_sidebar') && config('adminlte.right_sidebar_push') ? 'control-sidebar-push ' : '') .
config('adminlte.classes_body')
)

@section('body_data',
(config('adminlte.sidebar_scrollbar_theme', 'os-theme-light') != 'os-theme-light' ? 'data-scrollbar-theme=' .
config('adminlte.sidebar_scrollbar_theme') : '') . ' ' . (config('adminlte.sidebar_scrollbar_auto_hide', 'l') != 'l' ?
'data-scrollbar-auto-hide=' . config('adminlte.sidebar_scrollbar_auto_hide') : ''))

@php( $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout') )
@php( $profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout') )
@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
@php( $logout_url = $logout_url ? route($logout_url) : '' )
@php( $profile_url = $profile_url ? route($profile_url) : '' )
@php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
@php( $logout_url = $logout_url ? url($logout_url) : '' )
@php( $profile_url = $profile_url ? url($profile_url) : '' )
@php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('body')

<div class="wrapper">
    @if(config('adminlte.layout_topnav') || View::getSection('layout_topnav'))
    <nav class="main-header navbar {{config('adminlte.classes_topnav_nav', 'navbar-expand-md')}} {{config('adminlte.classes_topnav', 'navbar-white navbar-light')}}">
        <div class="{{config('adminlte.classes_topnav_container', 'container')}}">
            @if(config('adminlte.logo_img_xl'))
            <a href="{{ $dashboard_url }}" class="navbar-brand logo-switch">
                <img src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}" alt="{{config('adminlte.logo_img_alt', 'AdminLTE')}}" class="{{config('adminlte.logo_img_class', 'brand-image-xl')}} logo-xs">
                <img src="{{ asset(config('adminlte.logo_img_xl')) }}" alt="{{config('adminlte.logo_img_alt', 'AdminLTE')}}" class="{{config('adminlte.logo_img_xl_class', 'brand-image-xs')}} logo-xl">
            </a>
            @else
            <a href="{{ $dashboard_url }}" class="navbar-brand {{ config('adminlte.classes_brand') }}">
                <img src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}" alt="{{config('adminlte.logo_img_alt', 'AdminLTE')}}" class="{{ config('adminlte.logo_img_class', 'brand-image img-circle elevation-3') }}" style="opacity: .8">
                <span class="brand-text font-weight-light {{ config('adminlte.classes_brand_text') }}">
                    {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                </span>
            </a>
            @endif

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <ul class="nav navbar-nav">
                    @each('adminlte::partials.menu-item-top-nav-left', $adminlte->menu(), 'item')
                </ul>
            </div>
            @else
            <nav class="main-header navbar {{config('adminlte.classes_topnav_nav', 'navbar-expand-md')}} {{config('adminlte.classes_topnav', 'navbar-white navbar-light')}}">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" @if(config('adminlte.sidebar_collapse_remember')) data-enable-remember="true" @endif @if(!config('adminlte.sidebar_collapse_remember_no_transition')) data-no-transition-after-reload="false" @endif @if(config('adminlte.sidebar_collapse_auto_size')) data-auto-collapse-size="{{config('adminlte.sidebar_collapse_auto_size')}}" @endif>
                            <i class="fas fa-bars"></i>
                            <span class="sr-only">{{ __('adminlte::adminlte.toggle_navigation') }}</span>
                        </a>
                    </li>
                    @each('adminlte::partials.menu-item-top-nav-left', $adminlte->menu(), 'item')
                    @yield('content_top_nav_left')
                </ul>
                @endif
                <ul class="navbar-nav ml-auto @if(config('adminlte.layout_topnav') || View::getSection('layout_topnav'))order-1 order-md-3 navbar-no-expand @endif">
                    @yield('content_top_nav_right')
                    @each('adminlte::partials.menu-item-top-nav-right', $adminlte->menu(), 'item')

                    @if(config('adminlte.usermenu_enabled'))
                    <li style="margin-top: 5px;">
                        <p style="color: gray"><i class="fas fa-user"></i>
                            <strong>{{ isset($_SESSION['username']) ? $_SESSION['username'] : session()->get('username') }}</strong> &nbsp;
                            @if(Session::has('operationDate')) <i class="fas fa-calendar-alt"></i>
                            <a href="{{route('setOperationDate')}}"><strong>{{date('d/m/Y', strtotime(Session::get('operationDate')))}}</a>
                            @endif</strong>
                        </p>
                    </li>

                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            @if(config('adminlte.usermenu_image'))
                            <img src="" class="user-image img-circle elevation-2" alt="">
                            @endif
                            {{-- <span @if(config('adminlte.usermenu_image'))class="d-none d-md-inline"
                                @endif>{{$_SESSION['username']}}</span> --}}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            @if(!View::hasSection('usermenu_header') && config('adminlte.usermenu_header'))
                            <li class="user-header {{ config('adminlte.usermenu_header_class', 'bg-primary') }} @if(!config('adminlte.usermenu_image'))h-auto @endif">
                                @if(config('adminlte.usermenu_image'))
                                <img src="{{ url('/') }}/img/brasao.png" class="img-circle elevation-2" alt="">
                                @endif
                                {{-- <p class="@if(!config('adminlte.usermenu_image'))mt-0 @endif">
                                    {{$_SESSION['username']}}
                                @if(config('adminlte.usermenu_desc'))
                                <small>Função do Servidor</small>
                                @endif
                                </p> --}}
                            </li>
                            @else
                            @yield('usermenu_header')
                            @endif
                            @each('adminlte::partials.menu-item-top-nav-user', $adminlte->menu(), 'item')
                            @hasSection('usermenu_body')
                            <li class="user-body">
                                @yield('usermenu_body')
                            </li>
                            @endif
                            <li class="user-footer">
                                <div style="text-align: center;">
                                    <a href="" class="btn btn-default btn-sm">Perfil do Usuário</a>

                                </div>

                                <!-- BOTÃO DE SAIR DESATIVADO
                                <a class="btn btn-default btn-flat float-right "
                                    href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-fw fa-power-off"></i> {{ __('adminlte::adminlte.log_out') }}
                                </a>
                                -->
                            </li>
                        </ul>
                    </li>

                    @endif
                    @if(config('adminlte.right_sidebar'))
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-widget="control-sidebar" @if(!config('adminlte.right_sidebar_slide')) data-controlsidebar-slide="false" @endif @if(config('adminlte.right_sidebar_scrollbar_theme', 'os-theme-light' ) !='os-theme-light' ) data-scrollbar-theme="{{config('adminlte.right_sidebar_scrollbar_theme')}}" @endif @if(config('adminlte.right_sidebar_scrollbar_auto_hide', 'l' ) !='l' ) data-scrollbar-auto-hide="{{config('adminlte.right_sidebar_scrollbar_auto_hide')}}" @endif>
                            <i class="{{config('adminlte.right_sidebar_icon')}}"></i>
                        </a>
                    </li>
                    @endif
                </ul>
                @if(config('adminlte.layout_topnav') || View::getSection('layout_topnav'))
            </nav>
            @endif
    </nav>
    @if(!config('adminlte.layout_topnav') && !View::getSection('layout_topnav'))
    <aside style="background-color: rgba(19, 95, 158, 0.685)" class="main-sidebar {{config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4')}}">
        @if(config('adminlte.logo_img_xl'))
        <a href="{{ route('dashboard') }}" class="brand-link logo-switch">
            <img src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}" alt="{{config('adminlte.logo_img_alt', 'AdminLTE')}}" class="{{config('adminlte.logo_img_class', 'brand-image-xl')}} logo-xs">
            <img src="{{ asset(config('adminlte.logo_img_xl')) }}" alt="{{config('adminlte.logo_img_alt', 'AdminLTE')}}" class="{{config('adminlte.logo_img_xl_class', 'brand-image-xs')}} logo-xl">
        </a>
        @else
        <a href="{{ route('dashboard') }}" class="brand-link {{ config('adminlte.classes_brand') }}">
            <img src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}" alt="{{config('adminlte.logo_img_alt', 'AdminLTE')}}" class="{{ config('adminlte.logo_img_class', 'brand-image img-circle elevation-3') }}" style="opacity: .8">
            <span class="brand-text font-weight-light {{ config('adminlte.classes_brand_text') }}">
                {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
            </span>
        </a>
        @endif
        <div class="sidebar">

            <nav class="mt-2">
                {{-- SEARCH MENU --}}
                {{-- <form class="form-inline">
                    <div class="input-group">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Pesquisar..."
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form> --}}
                <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column {{config('adminlte.classes_sidebar_nav', '')}}" data-widget="treeview" role="menu" @if(config('adminlte.sidebar_nav_animation_speed') !=300) data-animation-speed="{{config('adminlte.sidebar_nav_animation_speed')}}" @endif @if(!config('adminlte.sidebar_nav_accordion')) data-accordion="false" @endif>
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                </ul>
            </nav>
        </div>
    </aside>
    @endif

    <div class="content-wrapper">
        @if(config('adminlte.layout_topnav') || View::getSection('layout_topnav'))
        <div class="container">
            @endif

            <div class="content-header">
                <div class="{{config('adminlte.classes_content_header', 'container-fluid')}}">
                    @yield('content_header')
                </div>
            </div>

            <div class="content">
                <div class="{{config('adminlte.classes_content', 'container-fluid')}}">
                    @yield('content')
                </div>
            </div>
            @if(config('adminlte.layout_topnav') || View::getSection('layout_topnav'))
        </div>
        @endif
    </div>

    @hasSection('footer')
    <footer class="main-footer">

        @yield('footer')
    </footer>
    @endif

    @if(config('adminlte.right_sidebar'))
    <aside class="control-sidebar control-sidebar-{{config('adminlte.right_sidebar_theme')}}">
        @yield('right-sidebar')
    </aside>
    @endif

</div>
</div>
@stop

<style>
    aside {
        /* background: linear-gradient(-45deg, #ee7752, #e73c7e, #34236e, #8fc42d); */
        background: linear-gradient(-45deg, #2701fc, #0484fc, #201542, #99ad73);
        background-size: 400% 400%;
        animation: gradient 10s ease infinite;
        /* background-image: url('vendor/adminlte/dist/img/fundo.jpg') !important; */
    }

    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

</style>




@section('adminlte_js')
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
@stack('js')
@yield('js')
@stop
