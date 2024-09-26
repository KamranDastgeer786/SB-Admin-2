<!-- Page Heading -->
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@yield('page-title')</h1>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right" style="background-color: ghostwhite;">
               <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
               <li class="breadcrumb-item active">@yield('page-title')</li>

               @if(View::hasSection('sub-page-title'))
                    <li class="breadcrumb-item active">@yield('sub-page-title')</li>
                @endif

                @if(View::hasSection('sub-sub-page-title'))
                    <li class="breadcrumb-item active">@yield('sub-sub-page-title')</li>
                @endif
            </ol>
        </div>
    </div>
</div>