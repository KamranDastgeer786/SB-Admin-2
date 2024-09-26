@extends('layouts.app')
@section('page-title', 'Update Password')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
        <div class="col-lg-7">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">{{ __('Update Password') }}</h1>
                </div>
                <form class="user" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="current_password" id="update_password_current_password" autocomplete="current-password" placeholder=" Current Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" id="update_password_password" autocomplete="new-password" placeholder="New Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password_confirmation" id="update_password_password_confirmation" autocomplete="new-password" placeholder=" Confirm Password">
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">{{ __('Save') }}</button>
                    @if (session('status') === 'password-updated')
                       <p
                          x-data="{ show: true }"
                          x-show="show"
                          x-transition
                          x-init="setTimeout(() => show = false, 2000)"
                          class="text-sm text-gray-600">{{ __('Saved.') }}
                        </p>
                    @endif
                </form>
                
            </div>
        </div>
    </div>
    <!-- Content Row -->
</div>
<!-- /.container-fluid -->
@endsection



