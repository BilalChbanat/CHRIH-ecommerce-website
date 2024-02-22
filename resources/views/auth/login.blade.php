@extends('layout.app')

@section('content')
 <div  class="authentication-wrapper authentication-cover authentication-bg " style="    display: flex;
    align-content: center;
    justify-content: center;">
      <div class="d-flex justify-content-center">
        <!-- Login -->
        <div style="" class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4 w-[30rem]">
          <div class="w-px-400 mx-auto">
            <!-- Logo -->
            <div class="app-brand mb-4">
              <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                  
                </span>
              </a>
            </div>
            <!-- /Logo -->
            <h3 class="mb-1">Welcome to CHRIH! 👋</h3>
            <p class="mb-4">Please sign-in to your account and start the adventure</p>

            <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                @csrf
              <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                 
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                 @enderror
              </div>

              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                  {{-- <a href="auth-forgot-password-cover.html">
                    <small>Forgot Password?</small>
                    
                  </a> --}}
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            <small>
                                {{ __('Forgot Your Password?') }}
                            </small>
                            
                        </a>
                    @endif
                </div>
                <div class="input-group input-group-merge">
                  
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                    @enderror
                    <input id="password" type="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input id="remember-me" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember-me">
                        {{ __('Remember Me') }}
                    </label>
                </div>
              </div>
              <button style="background-color: rgb(103, 103, 234);" type="submit" class="btn btn-primary d-grid w-100">Sign in</button>
            </form>

            <p class="text-center">
              <span>New on our platform?</span>
              <a href="{{route('register')}}">
                <span>Create an account</span>
              </a>
            </p>

            <div class="divider my-4">
              <div class="divider-text">or</div>
            </div>

            <div class="d-flex justify-content-center">
              <a href="" class="btn btn-icon btn-label-facebook me-3">
                <img style="width:2.1rem;" src="{{asset('images/facebook.png')}}" alt="facebook">
              </a>

              <a href="" class="btn btn-icon btn-label-google-plus me-3">
                <img style="width:2.1rem;" src="{{asset('images/google.png')}}" alt="facebook">
              </a>

              <a href="" class="btn btn-icon btn-label-twitter">
                <img style="width:2.1rem;" src="{{asset('images/github.png')}}" alt="facebook">
              </a>
            </div>
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>
@endsection
