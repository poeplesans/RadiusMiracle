@extends('layouts.main.main')

@section('page-up')
    <!-- Icons -->
    <link rel="stylesheet" href="../resource/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
    <link rel="stylesheet" href="../resource/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
    <link rel="stylesheet" href="../resource/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css">
    <link rel="stylesheet" href="../resource/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/libs/@form-validation/umd/styles/index.min.css">
@endsection

@section('page-down')
    <!-- Vendors JS -->
    <script>
        var usersData = @json($users);
    </script>
    <script src="../resource/assets/vendor/libs/moment/moment.js"></script>
    <script src="../resource/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="../resource/assets/vendor/libs/select2/select2.js"></script>
    <script src="../resource/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="../resource/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="../resource/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="../resource/assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="../resource/assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="../resource/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="../resource/assets/js/extended-ui-sweetalert2.js"></script>
    <!-- Page JS -->
    <script src="../resource/modif/vpn.js"></script>
@endsection

@section('container')
    {{-- {{ $users }} --}}
    <div class="m-5 flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-2">Header's & Menu's Navigation's List</h4>

        <p>
            A role provided access to predefined menus and features so that depending on <br />
            assigned role an administrator can have access to what user needs.
        </p>
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                {{-- <h5 class="card-title">Members Managements</h5> --}}
                {{-- <small>Manage users access Websites</small> --}}
                <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                    {{-- <div class="col-md-4 user_role"></div> --}}
                    <div class="col-md-2 user_plan"></div>
                    <div class="col-md-2 user_status"></div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table">
                    <thead class="border-top">
                        <tr>
                            <th></th>
                            <th>Vpn Name</th>
                            <th>Ip Address</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Protocol</th>
                            {{-- <th>Status</th> --}}
                            <th>Label</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Offcanvas to add new user -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
                aria-labelledby="offcanvasAddUserLabel">
                <div class="offcanvas-header border-bottom">
                    <h6 id="offcanvasAddUserLabel" class="offcanvas-title">Add User VPN</h6>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body mx-0 flex-grow-0">
                    <form class="add-new-user pt-0" id="addNewUserForm" action="/vpn/add" onsubmit="return false">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="vpn_name">vpn_name</label>
                            <input type="text" class="form-control" id="vpn_name" placeholder="Full Name"
                                name="vpn_name" aria-label="Sub Menu Name" />
                            @error('vpn_name')
                                <div id="error-vpn_name" class="text-danger">{{ $message }}</div>
                                <!-- Pesan error dari server-side -->
                            @enderror
                            <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                            <div id="error-vpn_name-js" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="ip_address">ip_address</label>
                            <input type="text" class="form-control" id="ip_address" placeholder="Username"
                                name="ip_address" aria-label="Sub Menu Name" />
                            @error('ipaddress')
                                <div id="error-ip_address" class="text-danger">{{ $message }}</div>
                                <!-- Pesan error dari server-side -->
                            @enderror
                            <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                            <div id="error-ipaddress-js" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="username">username</label>
                            <input type="text" class="form-control" id="username" placeholder="Input NIP User"
                                name="username" aria-label="Sub Menu Name" />
                            @error('nip')
                                <div id="error-nip" class="text-danger">{{ $message }}</div>
                                <!-- Pesan error dari server-side -->
                            @enderror
                            <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                            <div id="error-nip-js" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">password</label>
                            <input type="text" class="form-control" id="password" placeholder="Input ID Telegram User"
                                name="password" aria-label="Sub Menu Name" />
                            @error('telegram_id')
                                <div id="error-telegram_id" class="text-danger">{{ $message }}</div>
                                <!-- Pesan error dari server-side -->
                            @enderror
                            <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                            <div id="error-telegram_id-js" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="add-user-role">protocol</label>
                            {{-- <input type="text" class="form-control" id="add-user-role" placeholder="role" name="role"
                        aria-label="Sub Menu Name" /> --}}
                            <select id="add-user-role" class="form-select" name="role">
                                <option value="">Select</option>

                                <option value="any">Any</option>
                                <option value="pptp">PPTP</option>
                                <option value="l2tp">L2TP</option>

                            </select>
                            @error('role')
                                <div id="error-role" class="text-danger">{{ $message }}</div>
                                <!-- Pesan error dari server-side -->
                            @enderror
                            <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                            <div id="error-role-js" class="text-danger"></div>
                        </div>
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                        <button type="reset" class="btn btn-label-secondary"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </form>
                </div>
            </div>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvaseditUser"
                aria-labelledby="offcanvaseditUserLabel">
                <div class="offcanvas-header border-bottom">
                    <h6 id="offcanvaseditUserLabel" class="offcanvas-title">Edit User VPN</h6>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body mx-0 flex-grow-0">
                    <form class="add-new-user pt-0" id="editNewUserForm" action="/vpn/edit" onsubmit="return false">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="vpn_name">vpn_name</label>
                            <input type="text" class="form-control" id="edit_vpn_name" placeholder="Full Name"
                                name="vpn_name" aria-label="Sub Menu Name" />
                            @error('vpn_name')
                                <div id="error-vpn_name" class="text-danger">{{ $message }}</div>
                                <!-- Pesan error dari server-side -->
                            @enderror
                            <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                            <div id="error-vpn_name-js" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="ip_address">ip_address</label>
                            <input type="text" class="form-control" id="edit_ip_address" placeholder="Username"
                                name="ip_address" aria-label="Sub Menu Name" />
                            @error('ipaddress')
                                <div id="error-ip_address" class="text-danger">{{ $message }}</div>
                                <!-- Pesan error dari server-side -->
                            @enderror
                            <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                            <div id="error-ipaddress-js" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="username">username</label>
                            <input type="text" class="form-control" id="edit_username" placeholder="Input NIP User"
                                name="username" aria-label="Sub Menu Name" />
                            @error('nip')
                                <div id="error-nip" class="text-danger">{{ $message }}</div>
                                <!-- Pesan error dari server-side -->
                            @enderror
                            <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                            <div id="error-nip-js" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">password</label>
                            <input type="text" class="form-control" id="edit_password" placeholder="Input ID Telegram User"
                                name="password" aria-label="Sub Menu Name" />
                            @error('telegram_id')
                                <div id="error-telegram_id" class="text-danger">{{ $message }}</div>
                                <!-- Pesan error dari server-side -->
                            @enderror
                            <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                            <div id="error-telegram_id-js" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="add-user-role">protocol</label>
                            {{-- <input type="text" class="form-control" id="add-user-role" placeholder="role" name="role"
                        aria-label="Sub Menu Name" /> --}}
                            <select id="protocol" class="form-select" name="role">
                                <option id="edit_protocol" value="">Select</option>

                                <option value="any">Any</option>
                                <option value="pptp">PPTP</option>
                                <option value="l2tp">L2TP</option>

                            </select>
                            @error('role')
                                <div id="error-role" class="text-danger">{{ $message }}</div>
                                <!-- Pesan error dari server-side -->
                            @enderror
                            <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                            <div id="error-role-js" class="text-danger"></div>
                        </div>
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                        <button type="reset" class="btn btn-label-secondary"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </form>
                </div>
            </div>
            <!--/ Fixed Header -->
        </div>
    </div>
@endsection
