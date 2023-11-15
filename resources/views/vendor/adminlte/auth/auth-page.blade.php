@extends('adminlte::master')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('adminlte_css')
    @stack('css')
    <style>
        body {
          background-image: url('/img/fondox.png');
          background-repeat: repeat;
        }
        .module {
            border-image: url('/img/logo.png') 25 25 round;
            }
            img.rounded-corners {
            border-radius: 10px;
            }
    </style>
    @yield('css')
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')            
    <div class="{{ $auth_type ?? 'login' }}-box">
        {{-- Logo --}}
        <div class="{{ $auth_type ?? 'login' }}-logo">
            <a href="{{ $dashboard_url }}">
              <img src="/img/pexx.png" width="100" height="100">
            </a>
        </div>

        {{-- Card Box --}}
        <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}">
            {{-- Card Header --}}
            @hasSection('auth_header')
                <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                    <h3 class="card-title float-none text-center">
                        @yield('auth_header')
                    </h3>
                </div>
            @endif

            {{-- Card Body --}}
            <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">                
                @yield('auth_body')
            </div>

            {{-- Card Footer --}}
            @hasSection('auth_footer')
                <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                   
                    @yield('auth_footer')
                </div>
            @endif

        </div>
<br>
           {{-- Logo --}}
           <div class="{{ $auth_type ?? 'login' }}-logo">            
              <img  src="/img/logo.png"  class="rounded-corners" width="300" height="75">            
              
            </div>


    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
