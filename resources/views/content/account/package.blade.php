@extends('layouts.main.main')

@section('container')
    <div class="m-5 flex-grow-1 container-p-y">
        <div class="card">
            <!-- Pricing Plans -->
            <div class="pb-sm-5 pb-2 rounded-top">
                <div class="container py-3">
                    <h2 class="text-center mb-3 mt-0 mt-md-4">Find the right plan for your site</h2>
                    <p class="text-center">
                        Get started with us - it's perfect for individuals and teams. Choose a subscription plan that
                        meets your needs.
                    </p>
                    <div class="d-flex align-items-center justify-content-center flex-wrap gap-2 py-5">
                        <label class="switch switch-primary ms-sm-5 ps-sm-5 me-0">
                            <span class="switch-label">Monthly</span>
                            <input type="checkbox" class="switch-input price-duration-toggler" checked />
                            <span class="switch-toggle-slider">
                                <span class="switch-on"></span>
                                <span class="switch-off"></span>
                            </span>
                            <span class="switch-label">Annually</span>
                        </label>
                    </div>

                    <div class="row mx-4 gy-3">
                        <div class="col-lg">
                            <div class="card border shadow-none">
                                <div class="card-body">
                                    <h5 class="text-start text-uppercase">Bassic</h5>
                                    <div class="text-center position-relative mb-4 pb-1">
                                        <div class="mb-2 d-flex">
                                            <h1 class="price-toggle text-primary price-yearly mb-0">200.000</h1>
                                            <h1 class="price-toggle text-primary price-monthly mb-0 d-none">250.000</h1>
                                            <sub class="h5 text-muted pricing-duration mt-auto mb-2">/mo</sub>
                                        </div>
                                        <small
                                            class="position-absolute start-0 m-auto price-yearly price-yearly-toggle text-muted">2.400.000
                                            / year</small>
                                    </div>
                                    <p>Advance features for enterprise who need more customization</p>
                                    <hr />
                                    <ul class="list-unstyled pt-2 pb-1">
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            10 NAS/Routers
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            1000 Users PPPoE
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            10.000 Users Hotspot
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            Free Setup
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            Integrations
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            Full Support
                                        </li>
                                    </ul>
                                    <a href="auth-register-basic.html" class="btn btn-label-primary d-grid w-100">Get
                                        Started</a>
                                </div>
                            </div>
                        </div>
                        <!-- Starter -->
                        <div class="col-lg mb-md-0 mb-4">
                            <div class="card border shadow-none">
                                <div class="card-body">
                                    <h5 class="text-start text-uppercase">Starter</h5>
                                    <div class="text-center position-relative mb-4 pb-1">
                                        <div class="mb-2 d-flex">
                                            <h1 class="price-toggle text-primary price-yearly mb-0">300.000</h1>
                                            <h1 class="price-toggle text-primary price-monthly mb-0 d-none">400.000</h1>
                                            <sub class="h5 text-muted pricing-duration mt-auto mb-2">/mo</sub>
                                        </div>
                                        <small
                                            class="position-absolute start-0 m-auto price-yearly price-yearly-toggle text-muted">3.600.000
                                            / year</small>
                                    </div>
                                    <p>All the basics for business that are just getting started</p>
                                    <hr />
                                    <ul class="list-unstyled pt-2 pb-1">
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            Up to 10 users
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            150+ components
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            Basic support on Github
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                <i class="bx bx-x fs-5 lh-1"></i>
                                            </span>
                                            Monthly updates
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                <i class="bx bx-x fs-5 lh-1"></i>
                                            </span>
                                            Integrations
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                <i class="bx bx-x fs-5 lh-1"></i>
                                            </span>
                                            Full Support
                                        </li>
                                    </ul>
                                    <a href="auth-register-basic.html" class="btn btn-label-primary d-grid w-100">Get
                                        Started</a>
                                </div>
                            </div>
                        </div>
                        <!--/ Starter -->
                        <!-- Pro -->
                        <div class="col-lg mb-md-0 mb-4">
                            <div class="card border border-2 border-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between flex-wrap mb-3">
                                        <h5 class="text-start text-uppercase mb-0">Pro</h5>
                                        <span class="badge bg-primary rounded-pill">Popular</span>
                                    </div>
                                    <div class="text-center position-relative mb-4 pb-1">
                                        <div class="mb-2 d-flex">
                                            <h1 class="price-toggle text-primary price-yearly mb-0">450.000</h1>
                                            <h1 class="price-toggle text-primary price-monthly mb-0 d-none">600.000</h1>
                                            <sub class="h5 text-muted pricing-duration mt-auto mb-2">/mo</sub>
                                        </div>
                                        <small
                                            class="position-absolute start-0 m-auto price-yearly price-yearly-toggle text-muted">5.400.000
                                            / year</small>
                                    </div>
                                    <p>Batter for growing business that want to more customers</p>
                                    <hr />
                                    <ul class="list-unstyled pt-2 pb-1">
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            Up to 10 users
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            150+ components
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            Basic support on Github
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            Monthly updates
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                <i class="bx bx-x fs-5 lh-1"></i>
                                            </span>
                                            Integrations
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                <i class="bx bx-x fs-5 lh-1"></i>
                                            </span>
                                            Full Support
                                        </li>
                                    </ul>
                                    <a href="auth-register-basic.html" class="btn btn-primary d-grid w-100">Get
                                        Started</a>
                                </div>
                            </div>
                        </div>
                        <!--/ Pro -->
                        <!-- Enterprise -->
                        <div class="col-lg">
                            <div class="card border shadow-none">
                                <div class="card-body">
                                    <h5 class="text-start text-uppercase">ENTERPRISE</h5>
                                    <div class="text-center position-relative mb-4 pb-1">
                                        <div class="mb-2 d-flex">
                                            <h1 class="price-toggle text-primary price-yearly mb-0">750.000</h1>
                                            <h1 class="price-toggle text-primary price-monthly mb-0 d-none">1.000.000</h1>
                                            <sub class="h5 text-muted pricing-duration mt-auto mb-2">/mo</sub>
                                        </div>
                                        <small
                                            class="position-absolute start-0 m-auto price-yearly price-yearly-toggle text-muted">9.000.000
                                            / year</small>
                                    </div>
                                    <p>Advance features for enterprise who need more customization</p>
                                    <hr />
                                    <ul class="list-unstyled pt-2 pb-1">
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            Up to 10 users
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            150+ components
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            Basic support on Github
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            Monthly updates
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            Integrations
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="badge badge-center w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                <i class="bx bx-check bx-xs"></i>
                                            </span>
                                            Full Support
                                        </li>
                                    </ul>
                                    <a href="auth-register-basic.html" class="btn btn-label-primary d-grid w-100">Get
                                        Started</a>
                                </div>
                            </div>
                        </div>

                        <!--/ Enterprise -->
                    </div>
                </div>
            </div>
            <!--/ Pricing Plans -->
        </div>
        <div class="card mt-3">
            <!-- Pricing Plans -->
            <div class="pb-sm-5 pb-2 rounded-top">
                <div class="container py-3">
                    <h2 class="text-center mb-3 mt-0 mt-md-4">Features & Services</h2>
                    <p class="text-center">
                        Compare Between packages and choose a better one for your business.
                    </p>
                    <div class="m-3 table-responsive">
                        <table class="table table-hover" id="membersTable">
                            <thead>
                                <tr>
                                    <th>FEATURES</th>
                                    <th>BASIC</th>
                                    <th>STARTER</th>
                                    <th>STANDARD</th>
                                    <th>PROFESSIONAL</th>
                                    <th>ENTERPRISE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Users</td>
                                </tr>
                                <tr>
                                    <td>NAS/Routers</td>
                                </tr>
                                <tr>
                                    <td>Renewal After</td>
                                </tr>
                                <tr>
                                    <td>PPPoE</td>
                                </tr>
                                <tr>
                                    <td>Hotspot</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/ Pricing Plans -->
        </div>
        <div class="card mt-3">
            <!-- Pricing Plans -->
            <div class="pb-sm-5 pb-2 rounded-top">
                <div class="container py-3">
                    <h2 class="text-center mb-3 mt-0 mt-md-4">ADD ON Features</h2>
                    <p class="text-center">
                        Compare Between packages and choose a better one for your business.
                    </p>
                    <div class="m-3 table-responsive">
                        <table class="table table-hover" id="membersTable">
                            <thead>
                                <tr>
                                    <th>FEATURES</th>
                                    <th>BASIC</th>
                                    <th>STARTER</th>
                                    <th>STANDARD</th>
                                    <th>PROFESSIONAL</th>
                                    <th>ENTERPRISE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Users</td>
                                </tr>
                                <tr>
                                    <td>NAS/Routers</td>
                                </tr>
                                <tr>
                                    <td>Renewal After</td>
                                </tr>
                                <tr>
                                    <td>PPPoE</td>
                                </tr>
                                <tr>
                                    <td>Hotspot</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/ Pricing Plans -->
        </div>
    </div>
@endsection
