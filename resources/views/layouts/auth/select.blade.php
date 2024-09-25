@extends('layouts.auth.main')

@section('container')
    <!-- /Left Text -->
    <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center">
        <div class="flex-row text-center mx-auto">
            <img src="../resource/assets/img/pages/login-light.png" alt="Auth Cover Bg color" width="520"
                class="img-fluid authentication-cover-img" data-app-light-img="pages/login-light.png"
                data-app-dark-img="pages/login-dark.png" />
            <div class="mx-auto">
                <h3>Discover the powerful admin template 🥳</h3>
                <p>
                    Perfectly suited for all level of developers which helps you to <br />
                    kick start your next big projects & Applications.
                </p>
            </div>
        </div>
    </div>
    {{-- {{ dd($office) }} --}}
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
        <div class="w-px-400 mx-auto">
            <form action="/select-login" method="post">
                @csrf
                <h4 class="mb-2 text-center"> DASHBOARD LIST </h4>
                <p class="mb-4 text-center">Please Select Miracle Dashboard to start the adventure</p>
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="row justify-content-center">
                    <!-- /Left Text -->
                    {{-- {{ dd($office) }} --}}
                    @foreach ($office as $item)
                        <div class="col-md-6 mb-md-0 mt-3">
                            <div class="form-check custom-option custom-option-icon">
                                <label class="form-check-label custom-option-content" for="db_{{ $item->office_id }}">
                                    <span class="custom-option-body">
                                        <i class="bx bx-rocket"></i>
                                        <span class="custom-option-title">{{ $item->office->office_name }}</span>
                                        <small>{{ $item->office->status }}</small>
                                    </span>
                                    <input name="db" class="form-check-input" type="radio"
                                        value="{{ $item->office_id }}" id="db_{{ $item->office_id }}" checked />
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var customOptionTitles = document.querySelectorAll('.custom-option-title');

                        customOptionTitles.forEach(function(title) {
                            var fullText = title.textContent.trim();
                            var words = fullText.split(' ');

                            // Kondisi untuk membatasi jumlah kata sesuai yang diinginkan
                            if (words.length > 20) {
                                title.textContent = words.slice(0, 20).join(' ') + '...';
                            } else if (words.length > 2) {
                                title.textContent = words.slice(0, 2).join(' ');
                            } else if (words.length > 1) {
                                title.textContent = words.slice(0, 2).join(' ');
                            } else {
                                title.textContent = words[0];
                            }
                        });
                    });
                </script>

                <div class="row">
                    <div class="col-12 col-md-6 offset-md-3 mt-5">
                        <div class="input-group input-group-merge has-validation">
                            <input type="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="Confirm Password" aria-describedby="password">
                            <span class="input-group-text cursor-pointer"></span>
                        </div>
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            @error('password')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="my-3">
                            <button class="btn btn-primary w-100">
                                Login
                            </button>
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>
@endsection
