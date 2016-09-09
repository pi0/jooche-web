@extends('layouts.app')

@push('nav')
<li><a href="{{ route('dashboard.overview') }}">Overview</a></li>
<li><a href="{{ route('dashboard.topics') }}">Topics</a></li>
<li><a href="{{ route('dashboard.categories') }}">Categories</a></li>
@endpush

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">@yield('title')</div>
                    <div class="panel-body">
                        @yield('body')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection