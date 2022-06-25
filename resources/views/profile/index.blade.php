@extends('layouts.main')

@section('title', 'Profile')
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Profile') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"> {{ __('Profile') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#useradd-1" class="list-group-item list-group-item-action">{{ __('Profile') }}
                                <div class="float-end"></div>
                            </a>
                            <a href="#useradd-2" class="list-group-item list-group-item-action">{{ __('Basic Info') }}
                                <div class="float-end"></div>
                            </a>
                            <a href="#useradd-3" class="list-group-item list-group-item-action">{{ __('Login Details') }}
                                <div class="float-end"></div>
                            </a>
                            @if (setting('2fa') == '1')
                                <a href="#useradd-4" class="list-group-item list-group-item-action">{{ __('2FA') }}
                                    <div class="float-end"></div>
                                </a>
                            @endif
                            <a href="#useradd-7" class="list-group-item list-group-item-action">{{ __('Delete Account') }}
                                <div class="float-end"></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div id="useradd-1" class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('uploads/avatar/avatar.png') }}"
                                        alt="kal" class="img-user wid-80 rounded-circle">
                                </div>
                                <div class="d-block d-sm-flex align-items-center justify-content-between w-100">
                                    <div class="mb-3 mb-sm-0">
                                        <h4 class="mb-1 text-white">{{ $user->name }}</h4>
                                        <p class="mb-0 text-sm">{{ $role ? $role->name : 'Role Not Set' }}</p>
                                        @if (\Auth::user()->social_type != null)
                                            <p class="mb-0 text-sm"><b>{{ __('Login with:') }}</b>
                                                {{ ucfirst($user->social_type) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="useradd-2" class="card">
                        <div class="card-header">
                            <h5>{{ __('Basic info') }}</h5>
                            <small class="text-muted">{{ __('Mandatory informations') }}</small>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" method="POST"
                                action="{{ route('profile.update', $user->id) }}">
                                @csrf
                                <div class=" row mt-3 container-fluid">
                           
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('Full Name') }}</label>
                                            <input type="text" name="name" value="{{ $user->name }}"
                                                class="form-control" placeholder={{ __('Name') }}>
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('Role') }}</label>
                                            <input type="text" name="role"
                                                value="{{ $role ? $role->name : __('Role Not Set') }}"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="btn btn-primary btn-lg d-block mx-auto col-sm-12 mb-0"
                                                for="avatarCrop">
                                                {{ __('Update Avatar') }}
                                                <input type="file" class="d-none" id="avatarCrop">
                                            </label>
                                        </div>

                                        <div id="avatar-updater" class="col-xs-12 d-none">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="image-preview"></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <input type="text" name="avatar-url" class="d-none"
                                                        value="{{ route('update-avatar', Auth::user()->id) }}">
                                                    <button type="button" id="rotate-image"
                                                        class="btn btn-gradient-info col-sm-12 mb-1">{{ __('Rotate Image') }}</button>
                                                    <button type="button" id="crop_image"
                                                        class="btn btn-gradient-primary col-sm-12">{{ __('Crop Image') }}</button>
                                                    <button type="button" id="avatar-cancel-btn" name="button"
                                                        class="btn btn-gradient-primary col-sm-12 mt-1">{{ __('Cancel') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="col-md-12s">
                                <button type="submit"
                                    class="btn btn-primary col-sm-2 float-end mb-3">{{ __('Update Account') }}</button>
                            </div>
                        </div>

                    </div>

                    <div id="useradd-3" class="card">
                        <div class="card-header">
                            <h5>{{ __('Login Details') }}</h5>
                            <small class="text-muted">{{ __('Login informations') }}</small>
                        </div>
                        <form class="form-horizontal" method="POST" action="{{ route('update-login', $user->id) }}">
                            @csrf
                            <div class="card-body">
                                <div class=" row mt-3 container-fluid">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('Email') }}</label>
                                            <input type="text" name="email" value="{{ $user->email }}"
                                                class="form-control">
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('Password') }}</label>
                                            <input type="password" name="password" value=""
                                                placeholder="{{ __('Leave blank if you dont want to change') }}"
                                                class="form-control" autocomplete="off">
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('Confirm Password') }}</label>
                                            <input type="password" name="password_confirmation" value=""
                                                placeholder="{{ __('Leave blank if you dont want to change') }}"
                                                class="form-control" autocomplete="off">
                                            @if ($errors->has('password_confirmation'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="col-md-12 text-left">
                                    <button type="submit"
                                        class="btn btn-primary col-sm-2 float-end mb-3">{{ __('Update Login') }}</button>
                                </div>
                            </div>
                        </form>


                    </div>
                    @if (setting('2fa') == '1')
                        <div id="useradd-4" class="card">
                            <div class="card-header">
                                <div class="float-end">
                                    {{-- @if (setting('2fa') == '1')
                                            <div class="badge bg-success p-2 px-3 rounded">ENABLED</div>
                                        @else
                                            <div class="badge bg-danger p-2 px-3 rounded">DISSABLE</div>
                                        @endif --}}
                                </div>
                                <h5>{{ __('Two-factor authentication') }}</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush mt-2">
                                    @if (extension_loaded('imagick') && setting('2fa'))
                                        <div class="tab-pane" id="tfa-settings" role="tabpanel"
                                            aria-labelledby="tfa-settings-tab">
                                            <!--Google Two Factor Authentication card-->
                                            <div class="col-md-12">
                                                @include('layouts.includes.alerts')
                                                {{-- {{ dd(auth()->user()->google2fa) }} --}}
                                                @if (empty(auth()->user()->loginSecurity))
                                                    <!--=============Generate QRCode for Google 2FA Authentication=============-->
                                                    <div class="row p-0">
                                                        <div class="col-md-12">
                                                            <p>{{ __('To activate Two factor Authentication Generate QRCode') }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <form class=""
                                                                action="{{ route('generate2faSecret') }}" method="post">
                                                                @csrf
                                                                <button
                                                                    class="btn btn-primary col-md-6">{{ __('Activate 2FA') }}</button>
                                                                <a class="btn btn-secondary col-md-5"
                                                                    data-toggle="collapse" href="#collapseExample"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">{{ __('Setup Instruction') }}</a>
                                                            </form>
                                                        </div>
                                                        <div class="col-md-12 mt-3 collapse" id="collapseExample">
                                                            <hr>
                                                            <h3 class="">
                                                                {{ __('Two Factor Authentication(2FA) Setup Instruction') }}
                                                            </h3>
                                                            <hr>
                                                            <div
                                                                class="
                                                                mt-4">
                                                                <h4>{{ __('Below is a step by step instruction on setting up Two Factor Authentication') }}
                                                                </h4>
                                                                <p><label>{{ __('Step 1') }}:</label>
                                                                    {{ __('Download') }}
                                                                    <strong>{{ __('Google Authenticator App') }}</strong>
                                                                    {{ __('Application for Andriod or iOS') }}
                                                                </p>
                                                                <p class="text-center">
                                                                    <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"
                                                                        target="_blank"
                                                                        class="btn btn-success">{{ __('Download for Andriod') }}<i
                                                                            class="fa fa-android fa-2x ms-1"></i></a>
                                                                    <a href="https://apps.apple.com/us/app/google-authenticator/id388497605"
                                                                        target="_blank"
                                                                        class="btn btn-dark ms-1">{{ __('Download for iPhones') }}<i
                                                                            class="fa fa-apple fa-2x ms-1"></i></a>
                                                                </p>
                                                                <p><label>{{ __('Step 2') }}:</label>
                                                                    {{ __('Click on Generate Secret Key on the platform to generate a QRCode') }}
                                                                </p>
                                                                <p><label>{{ __('Step 3') }}:</label>
                                                                    {{ __('Open the') }}
                                                                    <strong>{{ __('Google Authenticator App') }}</strong>
                                                                    {{ __('and clcik on') }}
                                                                    <strong>{{ __('Begin') }}</strong>
                                                                    {{ __('on the mobile app') }}
                                                                </p>
                                                                <p><label>{{ __('Step 4') }}:</label>
                                                                    {{ __('After which click on') }}
                                                                    <strong>{{ __('Scan a QRcode') }}</strong>
                                                                </p>
                                                                <p><label>{{ __('Step 5') }}:</label>
                                                                    {{ __('Then scan the barcode on the platform') }}
                                                                </p>
                                                                <p><label>{{ __('Step 6') }}:</label>
                                                                    {{ __('Enter the verification code generated on the platform and Enable 2FA') }}
                                                                </p>
                                                                <hr>
                                                                <p><label>{{ __('Note') }}:</label>
                                                                    {{ __('To disable 2FA enter code from the Google Authenticator App and account password to disable 2FA') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--=============Generate QRCode for Google 2FA Authentication=============-->
                                                @elseif(!auth()->user()->loginSecurity->google2fa_enable)
                                                    <!--=============Enable Google 2FA Authentication=============-->
                                                    <form class="form-horizontal" method="POST"
                                                        action="{{ route('enable2fa') }}">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <p><strong>{{ __('Scan the QRCode with') }}
                                                                        <dfn>{{ __('Google Authenticator App') }}</dfn>
                                                                        {{ __('Enter the generated code below') }}</strong>
                                                                </p>
                                                            </div>
                                                            <div class="col-md-12"><img
                                                                    src="{{ $google2fa_url }}" />
                                                            </div>
                                                            <div class="col-md-12">
                                                                <p>{{ __('To enable 2-Factor Authentication verify QRCode') }}
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <label for="address"
                                                                    class="control-label">{{ __('Verification code') }}</label>
                                                                <input type="password" name="secret" class="form-control"
                                                                    id="code"
                                                                    placeholder="{{ __('Verification code') }}">
                                                                @if ($errors->has('verify-code'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('verify-code') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 text-left mt-2">
                                                            <button type="submit"
                                                                class="btn btn-primary col-sm-2">{{ __('Enable 2FA') }}</button>
                                                        </div>
                                                    </form>
                                                    <!--=============Enable Google 2FA Authentication=============-->
                                                @elseif(auth()->user()->loginSecurity->google2fa_enable)
                                                    <!--=============Disable Google 2FA Authentication=============-->
                                                    <form class="form-horizontal" method="POST"
                                                        action="{{ route('disable2fa') }}">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-12"><img
                                                                    src="{{ $google2fa_url }}" />
                                                            </div>
                                                            <div class="col-md-12">
                                                                <p>{{ __('To disable 2-Factor Authentication verify QRCode') }}
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <label for="address"
                                                                    class="control-label">{{ __('Current Password') }}</label>
                                                                <input id="password" type="password"
                                                                    placeholder="{{ __('Current Password') }}"
                                                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                                    name="current-password" required>
                                                                @error('password')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $error('password') }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 text-left">
                                                            <button type="submit"
                                                                class="btn btn-danger col-sm-2">{{ __('Disable 2FA') }}</button>
                                                        </div>
                                                    </form>
                                                    <!--=============Disable Google 2FA Authentication=============-->
                                                @endif
                                            </div>
                                        </div>
                                    @endif


                                </ul>
                            </div>
                            {{-- <div class="card-footer">

                            </div> --}}
                        </div>
                    @endif
                    {{--  --}}
                    <div id="useradd-7" class="card">
                        <div class="card-header">
                            <h5>{{ __('Delete Account') }}</h5>
                            <small
                                class="text-muted">{{ __('Once you delete your account, there is no going back. Please be certain.') }}</small>
                        </div>

                        <div class="card-footer">
                            <div class="col-sm-auto text-sm-end d-flex float-end mb-3">
                                @if ($user->active_status == 1)
                                    <a href="profile-status" class="btn btn-outline-secondary  d-flex me-3 float-end">
                                        {{ __('Deactivate') }}
                                    </a>
                                @endif


                                {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'id' => 'delete-form-' . $user->id]) !!}
                                <a class="btn btn-danger show_confirm d-flex" data-toggle="tooltip"
                                    href="#!">{{ __('Delete Account') }}<i
                                        class="ti ti-chevron-right ms-1 ms-sm-2"></i></a>
                                {!! Form::close() !!}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
        {{--  --}}

        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
    </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('vendor/js/plugins/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/js/plugins/croppie/js/croppie.min.js') }}"></script>
    <script src="{{ asset('vendor/js/plugins/summernote/dist/summernote-bs4.min.js') }}"></script>

    <script src="{{ asset('vendor/sweetalert/js/sweetalert.min.js') }}"></script>

    <script src="{{ asset('vendor/js/custom.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>

    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 200
        })
    </script>
@endpush
