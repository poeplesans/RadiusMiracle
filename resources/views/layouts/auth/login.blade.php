@extends('layouts.auth.main')

@section('container')
    <!-- /Left Text -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        @if (session()->has('error'))
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Auth</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('error') }}  {{-- Tampilkan pesan error --}}
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const toastElement = document.querySelector('.toast');
                    if (toastElement) {
                        const toast = new bootstrap.Toast(toastElement, { delay: 3000 }); // 3000ms = 3 detik
                        toast.show();
                    }
                });
            </script>
        @endif
    </div>
    <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center">
        <div class="flex-row text-center mx-auto">
            <img src="../warehouse/officeProfile/login-dark.png" alt="Auth Cover Bg color" width="520"
                class="img-fluid authentication-cover-img"  />
            <div class="mx-auto">
                <h3>Discover the powerful admin template 🥳</h3>
                <p>
                    Perfectly suited for all level of developers which helps you to <br />
                    kick start your next big projects & Applications.
                </p>
            </div>
        </div>
    </div>
    <!-- /Left Text -->

    <!-- Login -->
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
        <div class="w-px-400 mx-auto">
            <!-- Logo -->
            <div class="app-brand mb-4">
                <a href="index.html" class="app-brand-link gap-2 mb-2">
                    <span class="app-brand-logo demo">
                        <svg width="26px" height="26px" viewBox="0 0 26 26" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>icon</title>
                            <defs>
                                <linearGradient x1="50%" y1="0%" x2="50%" y2="100%"
                                    id="linearGradient-1">
                                    <stop stop-color="#5A8DEE" offset="0%"></stop>
                                    <stop stop-color="#699AF9" offset="100%"></stop>
                                </linearGradient>
                                <linearGradient x1="0%" y1="0%" x2="100%" y2="100%"
                                    id="linearGradient-2">
                                    <stop stop-color="#FDAC41" offset="0%"></stop>
                                    <stop stop-color="#E38100" offset="100%"></stop>
                                </linearGradient>
                            </defs>
                            <g id="Pages" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Login---V2" transform="translate(-667.000000, -290.000000)">
                                    <g id="Login" transform="translate(519.000000, 244.000000)">
                                        <g id="Logo" transform="translate(148.000000, 42.000000)">
                                            <g id="icon" transform="translate(0.000000, 4.000000)">
                                                <path
                                                    d="M13.8863636,4.72727273 C18.9447899,4.72727273 23.0454545,8.82793741 23.0454545,13.8863636 C23.0454545,18.9447899 18.9447899,23.0454545 13.8863636,23.0454545 C8.82793741,23.0454545 4.72727273,18.9447899 4.72727273,13.8863636 C4.72727273,13.5423509 4.74623858,13.2027679 4.78318172,12.8686032 L8.54810407,12.8689442 C8.48567157,13.19852 8.45300462,13.5386269 8.45300462,13.8863636 C8.45300462,16.887125 10.8856023,19.3197227 13.8863636,19.3197227 C16.887125,19.3197227 19.3197227,16.887125 19.3197227,13.8863636 C19.3197227,10.8856023 16.887125,8.45300462 13.8863636,8.45300462 C13.5386269,8.45300462 13.19852,8.48567157 12.8689442,8.54810407 L12.8686032,4.78318172 C13.2027679,4.74623858 13.5423509,4.72727273 13.8863636,4.72727273 Z"
                                                    id="Combined-Shape" fill="#4880EA"></path>
                                                <path
                                                    d="M13.5909091,1.77272727 C20.4442608,1.77272727 26,7.19618701 26,13.8863636 C26,20.5765403 20.4442608,26 13.5909091,26 C6.73755742,26 1.18181818,20.5765403 1.18181818,13.8863636 C1.18181818,13.540626 1.19665566,13.1982714 1.22574292,12.8598734 L6.30410592,12.859962 C6.25499466,13.1951893 6.22958398,13.5378796 6.22958398,13.8863636 C6.22958398,17.8551125 9.52536149,21.0724191 13.5909091,21.0724191 C17.6564567,21.0724191 20.9522342,17.8551125 20.9522342,13.8863636 C20.9522342,9.91761479 17.6564567,6.70030817 13.5909091,6.70030817 C13.2336969,6.70030817 12.8824272,6.72514561 12.5388136,6.77314791 L12.5392575,1.81561642 C12.8859498,1.78721495 13.2366963,1.77272727 13.5909091,1.77272727 Z"
                                                    id="Combined-Shape2" fill="url(#linearGradient-1)"></path>
                                                <rect id="Rectangle" fill="url(#linearGradient-2)" x="0" y="0"
                                                    width="7.68181818" height="7.68181818"></rect>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="app-brand-text demo h3 mb-0 fw-bold">Miracle</span>
                </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">Welcome to Frest! 👋</h4>
            <p class="mb-4">Please sign-in to your account and start the adventure</p>

            <form id="formAuthentication" class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework"
                action="{{ url('/login') }}" method="post" novalidate="novalidate">
                @csrf
                <div class="mb-3 fv-plugins-icon-container">
                    <label for="email" class="form-label">Email or Username</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" placeholder="Enter your email or username" autofocus=""
                        value="{{ old('email') }}">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">Password</label>
                        <a href="/forgot">
                            <small>Forgot Password?</small>
                        </a>
                    </div>
                    <div class="input-group input-group-merge has-validation">
                        <input type="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            placeholder="············" aria-describedby="password">
                        <span class="input-group-text cursor-pointer"></span>
                    </div>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember-me">
                        <label class="form-check-label" for="remember-me">
                            Remember Me
                        </label>
                    </div>
                </div>
                <button class="btn btn-primary d-grid w-100">
                    Sign in
                </button>
                <input type="hidden">
            </form>

            <p class="text-center">
                <span>New on our platform?</span>
                <a href="/register">
                    <span>Create an account</span>
                </a>
            </p>

            <div class="divider my-4">
                <div class="divider-text">or</div>
            </div>

            <div class="d-flex justify-content-center">
                <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                    <i class="tf-icons bx bxl-facebook"></i>
                </a>

                <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                    <i class="tf-icons bx bxl-google-plus"></i>
                </a>

                <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                    <i class="tf-icons bx bxl-twitter"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- /Login -->
@endsection
