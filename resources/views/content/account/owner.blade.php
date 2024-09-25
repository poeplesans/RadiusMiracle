@extends('layouts.main.main')

@section('container')
    <h4 class="py-3 breadcrumb-wrapper mb-2">Owner Manage Access</h4>

    <p>
        A role provided access to predefined menus and features so that depending on <br />
        assigned role an administrator can have access to what user needs.
    </p>

    <div class="row mt-3 g-4">
        <!-- Navigation -->
        <div class="col-12 col-lg-4">
            <div class="d-flex justify-content-between flex-column mb-3 mb-md-0">
                <ul class="nav nav-align-left nav-pills flex-column">
                    <li class="nav-item mb-1">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home"
                            aria-selected="true">
                            <i class="tf-icons bx bx-home me-1"></i> Store Detail's
                            {{-- <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">3</span> --}}
                        </button>
                    </li>
                    <li class="nav-item mb-1">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-Connections"
                            aria-controls="navs-pills-justified-Connections" aria-selected="true">
                            <i class="tf-icons bx bx-data me-1"></i> Server Connections
                            {{-- <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">3</span> --}}
                        </button>
                    </li>
                    <li class="nav-item mb-1">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-Status" aria-controls="navs-pills-justified-Status"
                            aria-selected="true">
                            <i class="tf-icons bx bx-line-chart me-1"></i> Server Status
                            {{-- <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">3</span> --}}
                        </button>
                    </li>
                    <li class="nav-item mb-1">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-Getway" aria-controls="navs-pills-justified-Getway"
                            aria-selected="true">
                            <i class="tf-icons bx bx-git-compare me-1"></i> Payment Getway API
                            {{-- <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">3</span> --}}
                        </button>
                    </li>
                    <li class="nav-item mb-1">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-Payment" aria-controls="navs-pills-justified-Payment"
                            aria-selected="true">
                            <i class="tf-icons bx bx-dollar-circle me-1"></i> Payment's
                            {{-- <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">3</span> --}}
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /Navigation -->

        <!-- Options -->
        <div class="col-12 col-lg-8 pt-4 pt-lg-0">
            <div class="tab-content p-0">
                <!-- Store Details Tab -->
                <div class="tab-pane fade " id="navs-pills-justified-home" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0">Office Profile</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-name">Store Name</label>
                                    <input type="text" class="form-control" id="ecommerce-settings-details-name"
                                        placeholder="Miracle Data Technology" name="settingsDet"
                                        aria-label="settings Details" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-phone">Store Short
                                        Name</label>
                                    <input type="tel" class="form-control phone-mask"
                                        id="ecommerce-settings-details-phone" placeholder="Miracle" name="phone"
                                        aria-label="phone" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-phone">Phone</label>
                                    <input type="tel" class="form-control phone-mask"
                                        id="ecommerce-settings-details-phone" placeholder="+(123) 456-7890" name="phone"
                                        aria-label="phone" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-email">Store contact
                                        email</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-details-email"
                                        placeholder="johndoe@gmail.com" name="email" aria-label="email" />
                                </div>

                                <div class="col-12 col-md-12">
                                    <label class="form-label mb-0" for="ecommerce-settings-sender-email">Address</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-sender-email"
                                        placeholder="johndoe@gmail.com" name="sender_email" aria-label="sender email" />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-sender-email">Latitude</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-sender-email"
                                        placeholder="johndoe@gmail.com" name="sender_email" aria-label="sender email" />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-sender-email">Longitude</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-sender-email"
                                        placeholder="johndoe@gmail.com" name="sender_email" aria-label="sender email" />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-sender-email">Copyright
                                        Text</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-sender-email"
                                        placeholder="johndoe@gmail.com" name="sender_email" aria-label="sender email" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0">Payment</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 g-3">
                                <div class="col-12 col-md-6">
                                    <label for="currency-store" class="form-label mb-0">Payment Getway</label>
                                    <select id="currency-store" class=" form-select" data-placeholder="Store currency">
                                        <option value="">Store Payment Getway</option>
                                        <option value="usd">Zendit</option>
                                        <option value="euro">Midtrans</option>
                                        <option value="pound">Doku</option>
                                        <option value="bitcoin">Fastpay</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="currency-store" class="form-label mb-0">Store currency</label>
                                    <select id="currency-store" class=" form-select" data-placeholder="Store currency">
                                        <option value="">Store Currency</option>
                                        <option value="idr">IDR</option>
                                        <option value="usd">USD</option>
                                        <option value="euro">Euro</option>
                                        <option value="pound">Pound</option>
                                        <option value="bitcoin">Bitcoin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0">Profile</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-name">Store
                                        Name</label>
                                    <input type="text" class="form-control" id="ecommerce-settings-details-name"
                                        placeholder="John Doe" name="settingsDet" aria-label="settings Details" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-phone">Phone</label>
                                    <input type="tel" class="form-control phone-mask"
                                        id="ecommerce-settings-details-phone" placeholder="+(123) 456-7890"
                                        name="phone" aria-label="phone" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-email">Store contact
                                        email</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-details-email"
                                        placeholder="johndoe@gmail.com" name="email" aria-label="email" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-sender-email">Sender
                                        email</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-sender-email"
                                        placeholder="johndoe@gmail.com" name="sender_email" aria-label="sender email" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-3">
                        <button type="reset" class="btn btn-label-secondary">Discard</button>
                        <a class="btn btn-primary" href="app-ecommerce-settings-payments.html">Save</a>
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-pills-justified-Connections" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0">SSH Freeradius</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-name">Host</label>
                                    <input type="text" class="form-control" id="ecommerce-settings-details-name"
                                        placeholder="John Doe" name="settingsDet" aria-label="settings Details" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-phone">Port</label>
                                    <input type="tel" class="form-control phone-mask"
                                        id="ecommerce-settings-details-phone" placeholder="+(123) 456-7890"
                                        name="phone" aria-label="phone" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-email">Username</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-details-email"
                                        placeholder="johndoe@gmail.com" name="email" aria-label="email" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-sender-email">Password</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-sender-email"
                                        placeholder="johndoe@gmail.com" name="sender_email" aria-label="sender email" />
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end ">
                            <button type="reset" class="btn btn-label-secondary m-3">Discard</button>
                            <a class="btn btn-primary m-3" href="app-ecommerce-settings-payments.html">Save</a>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0">Router VPN</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-name">Host</label>
                                    <input type="text" class="form-control" id="ecommerce-settings-details-name"
                                        placeholder="John Doe" name="settingsDet" aria-label="settings Details" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-phone">Port</label>
                                    <input type="tel" class="form-control phone-mask"
                                        id="ecommerce-settings-details-phone" placeholder="+(123) 456-7890"
                                        name="phone" aria-label="phone" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-email">Username</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-details-email"
                                        placeholder="johndoe@gmail.com" name="email" aria-label="email" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-sender-email">Password</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-sender-email"
                                        placeholder="johndoe@gmail.com" name="sender_email" aria-label="sender email" />
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end ">
                            <button type="reset" class="btn btn-label-secondary m-3">Discard</button>
                            <a class="btn btn-primary m-3" href="app-ecommerce-settings-payments.html">Save</a>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="navs-pills-justified-Status" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0">Profile</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-name">Store
                                        Name</label>
                                    <input type="text" class="form-control" id="ecommerce-settings-details-name"
                                        placeholder="John Doe" name="settingsDet" aria-label="settings Details" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-phone">Phone</label>
                                    <input type="tel" class="form-control phone-mask"
                                        id="ecommerce-settings-details-phone" placeholder="+(123) 456-7890"
                                        name="phone" aria-label="phone" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-email">Store contact
                                        email</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-details-email"
                                        placeholder="johndoe@gmail.com" name="email" aria-label="email" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-sender-email">Sender
                                        email</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-sender-email"
                                        placeholder="johndoe@gmail.com" name="sender_email" aria-label="sender email" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-3">
                        <button type="reset" class="btn btn-label-secondary">Discard</button>
                        <a class="btn btn-primary" href="app-ecommerce-settings-payments.html">Save</a>
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-pills-justified-Getway" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class='bx bx-git-merge'></i><i class='bx bx-wifi-0'></i>
                                Midtrans</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-name">Endpoint
                                        Url</label>
                                    <input type="text" class="form-control" id="ecommerce-settings-details-name"
                                        placeholder="https://api.sandbox.midtrans.com/v2/" name="settingsDet"
                                        aria-label="settings Details" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-phone">Merchant
                                        ID</label>
                                    <input type="tel" class="form-control phone-mask"
                                        id="ecommerce-settings-details-phone" placeholder="+(123) 456-7890"
                                        name="xxxxxxxxxxxxxxxxx" aria-label="phone" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-email">Client
                                        Key</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-details-email"
                                        placeholder="xxxxxxxxxxxxxxxxx" name="email" aria-label="email" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-sender-email">Server
                                        Key</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-sender-email"
                                        placeholder="xxxxxxxxxxxxxxxxx" name="sender_email" aria-label="sender email" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class='bx bx-git-merge'></i><i class='bx bx-wifi-0'></i> Zendit
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-name">Endpoint
                                        Url</label>
                                    <input type="text" class="form-control" id="ecommerce-settings-details-name"
                                        placeholder="https://api.sandbox.midtrans.com/v2/" name="settingsDet"
                                        aria-label="settings Details" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-phone">Merchant
                                        ID</label>
                                    <input type="tel" class="form-control phone-mask"
                                        id="ecommerce-settings-details-phone" placeholder="+(123) 456-7890"
                                        name="xxxxxxxxxxxxxxxxx" aria-label="phone" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-email">Secret
                                        KEY</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-details-email"
                                        placeholder="xxxxxxxxxxxxxxxxx" name="email" aria-label="email" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-sender-email">Callback
                                        Token</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-sender-email"
                                        placeholder="xxxxxxxxxxxxxxxxx" name="sender_email" aria-label="sender email" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class='bx bx-git-merge'></i><i class='bx bx-wifi-0'></i> Doku
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-name">Endpoint
                                        Url</label>
                                    <input type="text" class="form-control" id="ecommerce-settings-details-name"
                                        placeholder="https://api.sandbox.midtrans.com/v2/" name="settingsDet"
                                        aria-label="settings Details" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-phone">Merchant
                                        ID</label>
                                    <input type="tel" class="form-control phone-mask"
                                        id="ecommerce-settings-details-phone" placeholder="+(123) 456-7890"
                                        name="xxxxxxxxxxxxxxxxx" aria-label="phone" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-email">Client
                                        ID</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-details-email"
                                        placeholder="xxxxxxxxxxxxxxxxx" name="email" aria-label="email" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-sender-email">Secret
                                        Key</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-sender-email"
                                        placeholder="xxxxxxxxxxxxxxxxx" name="sender_email" aria-label="sender email" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class='bx bx-git-merge'></i><i class='bx bx-wifi-0'></i>
                                Fastpay</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-name">Endpoint
                                        Url</label>
                                    <input type="text" class="form-control" id="ecommerce-settings-details-name"
                                        placeholder="https://api.sandbox.midtrans.com/v2/" name="settingsDet"
                                        aria-label="settings Details" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-phone">Merchant
                                        ID</label>
                                    <input type="tel" class="form-control phone-mask"
                                        id="ecommerce-settings-details-phone" placeholder="+(123) 456-7890"
                                        name="xxxxxxxxxxxxxxxxx" aria-label="phone" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-details-email">Client
                                        Key</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-details-email"
                                        placeholder="xxxxxxxxxxxxxxxxx" name="email" aria-label="email" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-0" for="ecommerce-settings-sender-email">Server
                                        Key</label>
                                    <input type="email" class="form-control" id="ecommerce-settings-sender-email"
                                        placeholder="xxxxxxxxxxxxxxxxx" name="sender_email" aria-label="sender email" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-3">
                        <button type="reset" class="btn btn-label-secondary">Discard</button>
                        <a class="btn btn-primary" href="app-ecommerce-settings-payments.html">Save</a>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="navs-pills-justified-Payment" role="tabpanel">
                    <div class="card mb-4">
                        <!-- Current Plan -->
                        <h5 class="card-header">Current Plan</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <div class="mb-4">
                                        <h6 class="fw-medium mb-2">Your Current Plan is Basic</h6>
                                        <p>A simple start for everyone</p>
                                    </div>
                                    <div class="mb-4">
                                        <h6 class="fw-medium mb-2">Active until Dec 09, 2021</h6>
                                        <p>We will send you a notification upon Subscription expiration</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="fw-medium mb-2">
                                            <span class="me-2">$199 Per Month</span>
                                            <span class="badge bg-label-primary">Popular</span>
                                        </h6>
                                        <p>Standard plan for small to medium businesses</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="alert alert-success mb-4" role="alert">
                                        <h6 class="alert-heading mb-1">Info</h6>
                                        <span>Your plan Subscription is Active</span>
                                    </div>
                                    <div class="plan-statistics">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-medium mb-2">Days</span>
                                            <span class="fw-medium mb-2">24 of 30 Days</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar w-75" role="progressbar" aria-valuenow="75"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p class="mt-1 mb-0">6 days remaining until your plan requires update</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary me-2 mt-2" data-bs-toggle="modal"
                                        data-bs-target="#pricingModal">
                                        Upgrade Plan
                                    </button>
                                    <button class="btn btn-label-success cancel-subscription mt-2">Renew Plan
                                        Subscription</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <!-- Search form and Rows per Page dropdown -->
                        <div class="row mt-3">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="d-flex w-100">
                                        <div class="d-flex flex-wrap">
                                            <div class="btn-group ms-2">
                                                <select id="rowsPerPage" class="form-select w-auto">
                                                    <option selected value="10">10</option>
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                    <option value="250">250</option>
                                                    <option value="500">500</option>
                                                </select>
                                            </div>
                                        </div>
                                        <form class="d-flex ms-auto" role="search" id="searchForm">
                                            <input class="form-control me-2" type="search" placeholder="Search"
                                                aria-label="Search" id="search">

                                        </form>
                                        {{-- <button class="btn btn-outline-success" type="submit" id="searchButton"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">Add</button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="m-3 table-responsive">
                            <table class="table table-hover" id="membersTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">Invoice</th>
                                        <th class="text-center">Item</th>
                                        <th class="text-center">Invoice Date</th>
                                        <th class="text-center">Due Date</th>
                                        <th class="text-center">Payment</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Ppn</th>
                                        <th class="text-center">Discount</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoice as $item)
                                        <tr>
                                            <td class="small text-center"><a href="app-ecommerce-order-details.html"><span
                                                        class="fw-medium">{{ $item->invoice }}</span></a></td>
                                            <td class="small text-center">{{ $item->item }}</td>
                                            <td class="small text-center">{{ $item->invoice_date }}</td>
                                            <td class="small text-center">{{ $item->due_date }}</td>
                                            <td class="small text-center">
                                                <h6 class="mb-0 w-px-100 text-warning"><i
                                                        class="bx bxs-circle fs-tiny me-2"></i>{{ $item->payment }}</h6>
                                            </td>
                                            <td class="small text-center"><span class="badge px-2 bg-label-success"
                                                    text-capitalized="">{{ $item->status }}</span></td>
                                            <td class="small text-center">{{ $item->amount }}</td>
                                            <td class="small text-center">{{ $item->ppn }}</td>
                                            <td class="small text-center">{{ $item->discount }}</td>
                                            <td class="small text-center">{{ $item->total }}</td>
                                            @if ($item->status != 'settlement')
                                                <td class="small text-center">
                                                    <div class="d-flex justify-content-sm-center align-items-sm-center">
                                                        <button class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                                            <a href="#" class="dropdown-item"
                                                                data-bs-toggle="modal" data-bs-target="#paymentModal"
                                                                data-id="{{ $item->invoice }}"
                                                                data-item="{{ $item->item }}"
                                                                data-price="{{ $item->total }}"
                                                                onclick="fillModal(this)">
                                                                <i class='bx bx-dollar-circle'></i> Paid
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif


                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div id="pagination" class="d-flex justify-content-end m-3"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Options-->
    </div>
    <!-- Modal HTML -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <h3 id="modal-item-id"></h3>
                        <h3>Payment Transaction</h3>
                        <p>Permissions you may use and assign to your users.</p>
                    </div>
                    <div class="m-3 table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td class="small text-center">Item Name</td>
                                    <td class="small text-center">:</td>
                                    <td class="small text-center" id="modal-item"></td>
                                </tr>
                                <tr>
                                    <td class="small text-center">Price</td>
                                    <td class="small text-center">:</td>
                                    <td class="small text-center" id="modal-price"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button id="pay-button" class="btn btn-success">Pay Now</button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="snap-container" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
            </div>
        </div>
    </div>
    {{-- <div id="snap-container"></div> --}}

    <script type="text/javascript" src="{{ $url_endpoint }}" data-client-key="{{ $client_key }}"></script>
    {{-- <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ $client_key }}"></script> --}}
    <script>
        function fillModal(element) {
            // Ambil data dari elemen yang diklik
            var id = element.getAttribute("data-id");
            var item = element.getAttribute("data-item");
            var price = element.getAttribute("data-price");

            // Masukkan nilai ke dalam modal
            document.getElementById("modal-item-id").innerText = id;
            document.getElementById("modal-item").innerText = item;
            document.getElementById("modal-price").innerText = 'Rp. ' + price + ',-';
        }
    </script>
    <script>
        document.getElementById('pay-button').addEventListener('click', function() {
            // Ambil data dari modal (disesuaikan dengan data transaksi)
            let item = document.getElementById("modal-item").innerText;
            let id = document.getElementById("modal-item-id").innerText;
            let price = document.getElementById("modal-price").innerText.replace('Rp. ', '').replace(',-', '');


            // Kirim request ke server Laravel untuk mendapatkan Snap Token
            fetch('/owner/pay', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        invoice: id,
                        item_name: item,
                        qty: 1,
                        price: price,
                        first_name: 'Nama Depan', // Disesuaikan dengan data user
                        last_name: 'Nama Belakang',
                        email: 'user@example.com',
                        phone: '08123456789'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Jika token berhasil didapatkan dari server Laravel
                    // console.log(data)
                    if (data.token) {
                        $('#paymentModal').modal('hide');
                        // Memanggil pop-up Snap dengan menggunakan token yang diterima
                        window.snap.pay(data.token, {
                            // embedId: 'snap-container', // ID div tempat Snap muncul
                            onSuccess: function(result) {
                                alert("payment success!");
                                // console.log(result);
                                location.reload();
                            },
                            onPending: function(result) {
                                alert("waiting for your payment!");
                                console.log(result);

                            },
                            onError: function(result) {
                                alert("payment failed!");
                                console.log(result);
                            },
                            onClose: function() {
                                alert('you closed the popup without finishing the payment');
                                location.reload();
                            }
                        });
                    } else {
                        alert('Error getting Snap token: ' + data.error);

                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
@endsection
