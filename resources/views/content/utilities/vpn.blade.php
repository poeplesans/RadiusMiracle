@extends('layouts.main.main')

@section('page-up')
    <!-- Icons -->
    <link rel="stylesheet" href="../resource/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
    <link rel="stylesheet" href="../resource/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
    <link rel="stylesheet" href="../resource/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css">
    <link rel="stylesheet" href="../resource/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet"
        href="../resource/assets/vendor/libs/@form-validation/umd/styles/index.min.css">
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
    <div class="role-list m-5 flex-grow-1 container-p-y">
        <!-- Fixed Header -->
        <div class="row g-4 mb-4">
            {{-- {{ $roles }} --}}
            @foreach ($roles as $role)
                <div class="role-one col-sm-6 col-xl-2" id="role-card-{{ $role->id }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-normal">{{ $role->name }}</h6>
                            </div>
                            

                            <div class="d-flex justify-content-between align-items-end">
                                <div class="role-heading">
                                    <h4 class="mb-1">{{ $role->userrole_count }} User's</h4>
                                    
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editModalRole"
                                            class="role-edit-modal" data-role-id="{{ $role->id }}"
                                            data-role-name="{{ $role->name }}" 
                                            data-role-submenus="{{ json_encode($role->roleSubMenus) }}">
                                            <small>Edit Role</small>
                                        </a>
                                    
                                </div>
                                    <a href="javascript:void(0);" class="text-muted delete-role"
                                        data-user="{{ $role->userrole_count }}" data-id="{{ $role->id }}" data-role="{{ $roles }}"
                                        data-name="{{ $role->name }}"><i class="bx bx-trash"></i></a>
                                
                            </div>
                            

                        </div>
                    </div>
                </div> @endforeach
            <div class="col-sm-6
        col-xl-2">
    <div class="card h-100">
        <div class="row h-100">
            <div class="col-sm-5">
                <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                    <img src="../resource/assets/img/illustrations/lady-with-laptop-light.png" class="img-fluid"
                        alt="Image" width="100" data-app-light-img="illustrations/lady-with-laptop-light.png"
                        data-app-dark-img="illustrations/lady-with-laptop-dark.png" />
                </div>
            </div>
            <div class="col-sm-7">
                <div class="card-body text-sm-end text-center ps-sm-0">
                    <button data-bs-target="#addPermissionModal" data-bs-toggle="modal"
                        class="btn btn-primary mb-3 text-nowrap add-new-role">
                        Add Role
                    </button>
                    {{-- <p class="mb-0">Add role, if it does not exist</p> --}}
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title">Members Managements</h5>
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
                        <th>Fullname</th>
                        <th>Username</th>
                        <th>Telegram ID</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <h3>Edit User</h3>
                            <p>Modify the selected user details.</p>
                        </div>
                        <form id="editUserForm" class="update-user row" action="{{ url('/members/users/edit') }}"
                            method="POST">
                            @csrf
                            <input type="hidden" id="edit_user_id" name="id" />
                            <div class="col-12 mb-3">
                                <label class="form-label" for="edit_nip">NIP</label>
                                <input type="text" id="edit_nip" name="nip" class="form-control"
                                    placeholder="NIP" />
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="edit_full_name">Full Name</label>
                                <input type="text" id="edit_full_name" name="full_name" class="form-control"
                                    placeholder="Full Name" />
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="edit_username">Username</label>
                                <input type="text" id="edit_username" name="username" class="form-control"
                                    placeholder="Username" />
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="edit_password">Password</label>
                                <input type="password" id="edit_password" name="password" class="form-control"
                                    placeholder="New Password (leave blank if not changing)" />
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="edit_telegram_id">Telegram ID</label>
                                <input type="text" id="edit_telegram_id" name="telegram_id" class="form-control"
                                    placeholder="Telegram ID" />
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="edit_email">Email</label>
                                <input type="email" id="edit_email" name="email" class="form-control"
                                    placeholder="Email" />
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="edit_access_bot">Access Bot</label>
                                <select class="form-select" id="edit_access_bot" name="access_bot">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="edit_status">Status</label>
                                <select class="form-select" id="edit_status" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="edit_role">Role</label>
                                <select class="form-select" id="edit_role" name="role">
                                    {{-- {{ dd($roles) }} --}}
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 text-center demo-vertical-spacing">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save
                                    Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
            aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header border-bottom">
                <h6 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h6>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form class="add-new-user pt-0" id="addNewUserForm" action="/members/users/add" onsubmit="return false">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="add-user-fullname">Full Name</label>
                        <input type="text" class="form-control" id="add-user-fullname" placeholder="Full Name"
                            name="full_name" aria-label="Sub Menu Name" />
                        @error('full_name')
                            <div id="error-full_name" class="text-danger">{{ $message }}</div>
                            <!-- Pesan error dari server-side -->
                        @enderror
                        <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                        <div id="error-full_name-js" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-user-username">Username</label>
                        <input type="text" class="form-control" id="add-user-username" placeholder="Username"
                            name="username" aria-label="Sub Menu Name" />
                        @error('username')
                            <div id="error-username" class="text-danger">{{ $message }}</div>
                            <!-- Pesan error dari server-side -->
                        @enderror
                        <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                        <div id="error-username-js" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-user-nip">NIP</label>
                        <input type="text" class="form-control" id="add-user-nip" placeholder="Input NIP User"
                            name="nip" aria-label="Sub Menu Name" />
                        @error('nip')
                            <div id="error-nip" class="text-danger">{{ $message }}</div>
                            <!-- Pesan error dari server-side -->
                        @enderror
                        <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                        <div id="error-nip-js" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-user-idtelegram">Telegram ID</label>
                        <input type="text" class="form-control" id="add-user-idtelegram"
                            placeholder="Input ID Telegram User" name="telegram_id" aria-label="Sub Menu Name" />
                        @error('telegram_id')
                            <div id="error-telegram_id" class="text-danger">{{ $message }}</div>
                            <!-- Pesan error dari server-side -->
                        @enderror
                        <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                        <div id="error-telegram_id-js" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-user-email">Email</label>
                        <input type="text" class="form-control" id="add-user-email" placeholder="Email"
                            name="email" aria-label="Sub Menu Name" />
                        @error('email')
                            <div id="error-email" class="text-danger">{{ $message }}</div>
                            <!-- Pesan error dari server-side -->
                        @enderror
                        <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                        <div id="error-email-js" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-user-password">Password</label>
                        <input type="text" class="form-control" id="add-user-password" placeholder="Password"
                            name="password" aria-label="Sub Menu Name" />
                        @error('password')
                            <div id="error-password" class="text-danger">{{ $message }}</div>
                            <!-- Pesan error dari server-side -->
                        @enderror
                        <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                        <div id="error-password-js" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-user-role">Role</label>
                        {{-- <input type="text" class="form-control" id="add-user-role" placeholder="role" name="role"
                        aria-label="Sub Menu Name" /> --}}
                        <select id="add-user-role" class="form-select" name="role">
                            <option value="">Select</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <div id="error-role" class="text-danger">{{ $message }}</div>
                            <!-- Pesan error dari server-side -->
                        @enderror
                        <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                        <div id="error-role-js" class="text-danger"></div>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div>
        {{-- Modal Edit role Access --}}
        <div class="modal fade" id="editModalRole" tabindex="-1" aria-labelledby="editRoleLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center mt-4">
                            <h3>Update Role Model</h3>
                            <p>Permissions you may use and assign to your users.</p>
                        </div>
                        <div class="modal-body">
                            <form id="editPermissionForm" class="row" action="{{ url('/members/role/edit') }}"
                                method="post">
                                @csrf
                                <input type="hidden" id="roleId" name="role_id" />

                                <div class="col-12 mb-3">
                                    <label class="form-label" for="name">Role Access Name</label>
                                    <input type="text" id="name-edit" name="name" class="form-control"
                                        placeholder="Permission Name" />
                                </div>

                                <div class="col-md">
                                    <div class="accordion accordion-header-primary" id="accordionStyle1">
                                        <!-- Loop menus dan submenus di sini, sama seperti sebelumnya -->
                                        @foreach ($menuArray as $header => $menus)
                                            {{-- {{ dd() }} --}}
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header">
                                                    <button type="button" class="accordion-button collapsed"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#accordionStyle1-{{ $menus['header_id'] }}"
                                                        aria-expanded="false">
                                                        {{ $header }}
                                                    </button>
                                                </h2>
                                                <div id="accordionStyle1-{{ $menus['header_id'] }}"
                                                    class="accordion-collapse collapse" data-bs-parent="#accordionStyle1">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            @foreach ($menus['menus'] as $menuName => $subMenus)
                                                                @if (isset($menus['menus']) && is_array($menus['menus']))
                                                                    @if (isset($subMenus) && is_array($subMenus) && count($subMenus) >= 6)
                                                                        {{-- {{ dd($menuName) }} --}}
                                                                        <small class="text-light m-3">
                                                                            <i class="{{ $subMenus['icon'] }} me-2"></i>
                                                                            {{ $menuName }}
                                                                        </small>
                                                                        <div class="row">
                                                                            @foreach ($subMenus as $subMenu)
                                                                                @if (isset($subMenu['name']) && isset($subMenu['sub_menu_id']))
                                                                                    {{-- {{ dd($subMenu) }} --}}
                                                                                    <div
                                                                                        class="col-xl-4 col-lg-6 col-md-6">
                                                                                        <div>
                                                                                            <label
                                                                                                class="switch switch-success">
                                                                                                <input type="checkbox"
                                                                                                    class="switch-input"
                                                                                                    name="sub_menus[]"
                                                                                                    value="{{ $subMenu['sub_menu_id'] }}" />
                                                                                                <span
                                                                                                    class="switch-toggle-slider">
                                                                                                    <span
                                                                                                        class="switch-on">
                                                                                                        <i
                                                                                                            class="bx bx-check"></i>
                                                                                                    </span>
                                                                                                    <span
                                                                                                        class="switch-off">
                                                                                                        <i
                                                                                                            class="bx bx-x"></i>
                                                                                                    </span>
                                                                                                </span>
                                                                                                <span
                                                                                                    class="switch-label small">{{ $subMenu['name'] }}</span>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-12 mt-3 text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- addPermissionModal --}}
        <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center mt-4">
                            <h3>Add Role Model</h3>
                            <p>Permissions you may use and assign to your users.</p>
                        </div>
                        <form class="add-new-user row" id="addNewRoleForm" action="/members/role/add"
                            onsubmit="return false">
                            @csrf
                            <div class="col-12 mb-3">
                                <label class="form-label" for="modalPermissionName">Role Access Name</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Permission Name" />
                            </div>

                            <div class="col-md">
                                <div class="accordion accordion-header-primary" id="accordionStyle1">
                                    @foreach ($menuArray as $header => $menus)
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header">
                                                <button type="button" class="accordion-button collapsed"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#accordionStyle1-{{ $menus['header_id'] }}"
                                                    aria-expanded="false">
                                                    {{ $header }}
                                                </button>
                                            </h2>
                                            <div id="accordionStyle1-{{ $menus['header_id'] }}"
                                                class="accordion-collapse collapse" data-bs-parent="#accordionStyle1">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        @foreach ($menus['menus'] as $menuName => $subMenus)
                                                            @if (isset($menus['menus']) && is_array($menus['menus']))
                                                                @if (isset($subMenus) && is_array($subMenus) && $subMenus[0]['name'] != null)
                                                                    {{-- {{ dd($subMenus[0]['name']) }} --}}
                                                                    <small class="text-light m-3">
                                                                        <i class="{{ $subMenus['icon'] }} me-2"></i>
                                                                        {{ $menuName }}
                                                                    </small>
                                                                    <div class="row">
                                                                        @foreach ($subMenus as $subMenu)
                                                                            @if (isset($subMenu['name']) && isset($subMenu['sub_menu_id']))
                                                                                <div class="col-xl-4 col-lg-6 col-md-6">
                                                                                    <div>
                                                                                        <label
                                                                                            class="switch switch-success">
                                                                                            <input type="checkbox"
                                                                                                class="switch-input"
                                                                                                name="sub_menus[]"
                                                                                                value="{{ $subMenu['sub_menu_id'] }}" />
                                                                                            <span
                                                                                                class="switch-toggle-slider">
                                                                                                <span class="switch-on">
                                                                                                    <i
                                                                                                        class="bx bx-check"></i>
                                                                                                </span>
                                                                                                <span class="switch-off">
                                                                                                    <i class="bx bx-x"></i>
                                                                                                </span>
                                                                                            </span>
                                                                                            <span
                                                                                                class="switch-label small">{{ $subMenu['name'] }}</span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 mt-3 text-center demo-vertical-spacing">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save
                                    Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Fixed Header -->
    </div>
@endsection
