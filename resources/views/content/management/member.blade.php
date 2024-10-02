@extends('layouts.main.main')

@section('container')
    <h4 class="py-3 breadcrumb-wrapper mb-2">Role's & User's Manage Access</h4>

    <p>
        A role provided access to predefined menus and features so that depending on <br />
        assigned role an administrator can have access to what user needs.
    </p>
    <script>
        // Mengubah data $roles menjadi format JSON yang dapat diakses di JavaScript
        const roles = @json($roles);
    </script>
    <!-- Role cards -->
    <div class="row g-4">
        {{-- {{ dd($roles) }} --}}
        @foreach ($roles as $role)
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-normal">Total {{ $role->userrole_count }} User(s)</h6>
                        </div>

                        <div class="d-flex justify-content-between align-items-end">
                            <div class="role-heading">
                                <h4 class="mb-1">{{ $role->name }}</h4>
                                @if ($role->id !== 1)
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editModalRole"
                                        class="role-edit-modal" data-role-id="{{ $role->id }}"
                                        data-role-name="{{ $role->name }}"
                                        data-role-submenus="{{ json_encode($role->roleSubMenus) }}">
                                        <small>Edit Role</small>
                                    </a>
                                @else
                                    <a class="role-edit-modal">
                                        <small>Edit Role</small></a>
                                @endif
                            </div>
                            @if ($role->id !== 1)
                                <a href="javascript:void(0);" class="text-muted delete-role"
                                    data-user="{{ $role->userrole_count }}" data-id="{{ $role->id }}"
                                    data-name="{{ $role->name }}"><i class="bx bx-trash"></i></a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteButtons = document.querySelectorAll('.delete-role');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Ambil data dari tombol
                        const menuId = this.getAttribute('data-id');
                        const menuname = this.getAttribute('data-name');
                        const userCount = this.getAttribute('data-user');

                        // Cek apakah userCount lebih dari 0
                        if (userCount > 0) {
                            console.log('run dropdown')
                            // Buat dropdown untuk memindahkan user ke role lain
                            var dropdownOptions = '';
                            roles.forEach(function(role) {
                                console.log(role.id)
                                console.log(menuId)
                                if (role.id !=
                                    menuId) { // Hindari menampilkan role yang sedang dipilih
                                    dropdownOptions +=
                                        `<option value="${role.id}">${role.name}</option>`;
                                }
                            });

                            Swal.fire({
                                title: 'Role has users!',
                                html: `<div class="text-center">
                                            <span style="font-size: 14px;">Role <b style="color: red;">${menuname}</b> memiliki <b>${userCount}</b> pengguna.</span><br>
                                            <select id="newRole" class="swal2-select form-control mt-2" style="font-size: 14px; width: auto; display: inline-block;">
                                                ${dropdownOptions}
                                            </select>
                                        </div>
                                    `,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Move & Delete',
                                cancelButtonText: 'Cancel',
                                customClass: {
                                    confirmButton: 'btn btn-danger me-3',
                                    cancelButton: 'btn btn-secondary'
                                },
                                buttonsStyling: false,
                                preConfirm: () => {
                                    const newRoleId = document.getElementById('newRole')
                                        .value;
                                    if (!newRoleId) {
                                        Swal.showValidationMessage(
                                            'Please select a new role!');
                                    }
                                    return newRoleId;
                                }
                            }).then(function(result) {
                                if (result.isConfirmed) {
                                    var newRoleId = result.value;
                                    console.log(newRoleId)

                                    // Kirim request AJAX untuk memindahkan user dan menghapus role
                                    $.ajax({
                                        url: '/members/role/delete/' + menuId,
                                        type: 'DELETE',
                                        data: {
                                            new_role_id: newRoleId, // Role baru untuk pengguna
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(response) {
                                            if (response.status === 'success') {
                                                Swal.fire({
                                                    title: 'Deleted!',
                                                    text: response.message,
                                                    icon: 'success',
                                                    confirmButtonText: 'OK',
                                                    customClass: {
                                                        confirmButton: 'btn btn-success'
                                                    }
                                                }).then(function() {
                                                    location.reload();
                                                });
                                            }
                                        },
                                        error: function(xhr) {
                                            Swal.fire({
                                                title: 'Error!',
                                                text: 'Something went wrong. Please try again later.',
                                                icon: 'error',
                                                confirmButtonText: 'OK',
                                                customClass: {
                                                    confirmButton: 'btn btn-danger'
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        } else {
                            // Jika userCount <= 0, tampilkan SweetAlert biasa
                            Swal.fire({
                                title: 'Are you sure?',
                                html: 'Do you want to delete <b style="color: red;">' +
                                    menuname + '</b> ??',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'Cancel',
                                customClass: {
                                    confirmButton: 'btn btn-danger me-3',
                                    cancelButton: 'btn btn-secondary'
                                },
                                buttonsStyling: false
                            }).then(function(result) {
                                if (result.value) {
                                    // Jika dikonfirmasi, jalankan request Ajax untuk penghapusan
                                    $.ajax({
                                        url: '/members/role/delete/' + menuId,
                                        type: 'DELETE',
                                        data: {
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(response) {
                                            if (response.status === 'success') {
                                                Swal.fire({
                                                    title: 'Deleted!',
                                                    text: response.message,
                                                    icon: 'success',
                                                    confirmButtonText: 'OK',
                                                    customClass: {
                                                        confirmButton: 'btn btn-success'
                                                    }
                                                }).then(function() {
                                                    location.reload();
                                                });
                                            }
                                        },
                                        error: function(xhr) {
                                            Swal.fire({
                                                title: 'Error!',
                                                text: 'Something went wrong. Please try again later.',
                                                icon: 'error',
                                                confirmButtonText: 'OK',
                                                customClass: {
                                                    confirmButton: 'btn btn-danger'
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                });
            });
        </script>
        <div class="col-xl-3 col-lg-6 col-md-6">
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
                                Add New Role
                            </button>
                            {{-- <p class="mb-0">Add role, if it does not exist</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <!-- Role Table -->
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
                                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                                        id="search">

                                </form>
                                <button class="btn btn-outline-success" type="submit" id="searchButton"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">Add</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="m-3 table-responsive">
                    <table class="table table-hover" id="membersTable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">NIP</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Bot</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Create At</th>
                                <th class="text-center">Update AT</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{ dd($menuArray) }} --}}
                            @foreach ($users as $user)
                                {{-- {{ $user->role_id }} --}}
                                <tr>
                                    <td class="text-center">{{ $user->id }}</td>
                                    <td class="text-center">{{ $user->nip }}</td>
                                    <td class="text-center">{{ $user->full_name }}</td>
                                    <td class="text-center">{{ $user->username }}</td>
                                    <td class="text-center">{{ $user->email }}</td>
                                    <td class="text-center">{{ $user->status }}</td>
                                    <td class="text-center">{{ $user->access_bot }}</td>
                                    <td class="text-center">{{ $user->role_id->name }}</td>
                                    <td class="text-center">{{ $user->created_at }}</td>
                                    <td class="text-center">{{ $user->updated_at }}</td>
                                    <td class="small text-center" style="">
                                        <div class="d-inline-block text-nowrap">
                                            <!-- Tombol Edit -->
                                            @if ($user->id !== 1)
                                                <button type="button" class="btn btn-sm btn-icon edit-button"
                                                    data-user='@json($user)'>
                                                    <i class="bx bx-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-icon delete-user"
                                                    data-id="{{ $user->email }}">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            @else
                                                <!-- Tombol tidak aktif -->
                                                <button type="button" class="btn btn-sm btn-icon">
                                                    <i class="bx bx-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-icon">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div id="pagination" class="d-flex justify-content-end m-3"></div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const deleteButtons = document.querySelectorAll('.delete-user');

                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            // Ambil data-id dari tombol
                            const menuId = this.getAttribute('data-id');
                            console.log(menuId)
                            // Tampilkan SweetAlert untuk konfirmasi
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'Cancel',
                                customClass: {
                                    confirmButton: 'btn btn-danger me-3',
                                    cancelButton: 'btn btn-secondary'
                                },
                                buttonsStyling: false
                            }).then(function(result) {
                                if (result.value) {
                                    // Jika dikonfirmasi, jalankan request Ajax
                                    $.ajax({
                                        url: '/members/users/delete/' +
                                            menuId, // URL delete, sesuaikan dengan route Anda
                                        type: 'DELETE', // Metode HTTP untuk penghapusan
                                        data: {
                                            _token: '{{ csrf_token() }}' // Laravel CSRF token
                                        },
                                        success: function(response) {
                                            if (response.status === 'success') {
                                                Swal.fire({
                                                    title: 'Deleted!',
                                                    text: response.message,
                                                    icon: 'success',
                                                    confirmButtonText: 'OK',
                                                    customClass: {
                                                        confirmButton: 'btn btn-success'
                                                    }
                                                }).then(function() {
                                                    // Reload halaman atau lakukan tindakan lain setelah sukses
                                                    location.reload();
                                                });
                                            }
                                        },
                                        error: function(xhr) {
                                            Swal.fire({
                                                title: 'Error!',
                                                text: 'Something went wrong. Please try again later.',
                                                icon: 'error',
                                                confirmButtonText: 'OK',
                                                customClass: {
                                                    confirmButton: 'btn btn-danger'
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        });
                    });
                });
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    let rowsPerPage = parseInt(document.getElementById('rowsPerPage').value);
                    const originalRows = Array.from(document.querySelectorAll('#membersTable tbody tr'));
                    // console.log('Element found:', originalRows);
                    const pagination = document.getElementById('pagination');
                    let currentPage = 1;
                    let filteredRows = originalRows.slice(); // Salinan dari originalRows

                    // Handle rows per page selection
                    document.getElementById('rowsPerPage').addEventListener('change', function() {
                        rowsPerPage = parseInt(this.value);
                        showPage(1);
                    });

                    // Search functionality
                    document.getElementById('search').addEventListener('keyup', function() {
                        let value = this.value.trim().toLowerCase();

                        if (value === '') {
                            // Jika input pencarian kosong, kembalikan ke originalRows dan batasi hasil sesuai rowsPerPage
                            filteredRows = originalRows.slice();
                            showPage(1);
                        } else {
                            // Jika ada input pencarian, tampilkan semua hasil yang sesuai tanpa paginasi
                            filteredRows = originalRows.filter(row =>
                                row.textContent.toLowerCase().includes(value)
                            );
                            showAllFilteredRows(); // Tampilkan semua hasil pencarian
                        }
                    });

                    function showPage(page) {
                        currentPage = page;
                        const startIndex = (currentPage - 1) * rowsPerPage;
                        const endIndex = startIndex + rowsPerPage;

                        // Hide all rows
                        originalRows.forEach(row => row.style.display = 'none');

                        // Show only the rows for the current page
                        filteredRows.slice(startIndex, endIndex).forEach(row => row.style.display = '');

                        updatePagination();
                    }

                    function showAllFilteredRows() {
                        // Hide all rows first
                        originalRows.forEach(row => row.style.display = 'none');

                        // Show all filtered rows without pagination
                        filteredRows.forEach(row => row.style.display = '');

                        // Clear pagination because we don't need it when showing all results
                        pagination.innerHTML = '';
                    }

                    function updatePagination() {
                        pagination.innerHTML = '';

                        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);

                        // Jika tidak ada data yang cocok
                        if (filteredRows.length === 0) {
                            const noDataMessage = document.createElement('div');
                            noDataMessage.textContent = 'No matching records found.';
                            noDataMessage.className = 'text-center my-2';
                            pagination.appendChild(noDataMessage);
                            return;
                        }

                        // Create Back button
                        const backButton = document.createElement('button');
                        backButton.textContent = 'Back';
                        backButton.className = 'btn btn-primary btn-sm mx-1';
                        backButton.disabled = currentPage === 1;
                        backButton.addEventListener('click', () => {
                            if (currentPage > 1) {
                                showPage(currentPage - 1);
                            }
                        });
                        pagination.appendChild(backButton);

                        // Page numbers
                        const pageRange = 5;
                        let startPage = Math.max(1, currentPage - Math.floor(pageRange / 2));
                        let endPage = Math.min(totalPages, startPage + pageRange - 1);

                        if (endPage - startPage < pageRange - 1) {
                            startPage = Math.max(1, endPage - pageRange + 1);
                        }

                        for (let i = startPage; i <= endPage; i++) {
                            const pageButton = document.createElement('button');
                            pageButton.textContent = i;
                            pageButton.className = 'btn btn-outline-primary btn-sm mx-1';
                            if (i === currentPage) {
                                pageButton.classList.add('active');
                                pageButton.classList.remove('btn-outline-primary');
                                pageButton.classList.add('btn-primary');
                            }
                            pageButton.addEventListener('click', () => showPage(i));
                            pagination.appendChild(pageButton);
                        }

                        // Create Next button
                        const nextButton = document.createElement('button');
                        nextButton.textContent = 'Next';
                        nextButton.className = 'btn btn-primary btn-sm mx-1';
                        nextButton.disabled = currentPage === totalPages;
                        nextButton.addEventListener('click', () => {
                            if (currentPage < totalPages) {
                                showPage(currentPage + 1);
                            }
                        });
                        pagination.appendChild(nextButton);
                    }

                    // Inisialisasi tampilan halaman pertama
                    showPage(1);
                });
            </script>

            <script>
                // Pagination functionality
                document.addEventListener('DOMContentLoaded', () => {
                    let rowsPerPage = parseInt(document.getElementById('rowsPerPage').value);
                    const rows = document.querySelectorAll('#membersTable tbody tr');
                    // console.log('Element found:', rows);
                    const pagination = document.getElementById('pagination');
                    let currentPage = 1;

                    document.getElementById('rowsPerPage').addEventListener('change', function() {
                        rowsPerPage = parseInt(this.value);
                        showPage(1);
                    });

                    function showPage(page) {
                        currentPage = page;
                        rows.forEach((row, index) => {
                            row.style.display = (index >= (page - 1) * rowsPerPage && index < page * rowsPerPage) ?
                                '' : 'none';
                        });
                        updatePagination();
                    }

                    function updatePagination() {
                        pagination.innerHTML = '';

                        const totalPages = Math.ceil(rows.length / rowsPerPage);

                        // Create Back button
                        const backButton = document.createElement('button');
                        backButton.textContent = 'Back';
                        backButton.className = 'btn btn-primary btn-sm mx-1';
                        backButton.disabled = currentPage === 1;
                        backButton.addEventListener('click', () => {
                            if (currentPage > 1) {
                                showPage(currentPage - 1);
                            }
                        });
                        pagination.appendChild(backButton);

                        // Page numbers
                        const pageRange = 5;
                        let startPage = Math.max(1, currentPage - Math.floor(pageRange / 2));
                        let endPage = Math.min(totalPages, startPage + pageRange - 1);

                        if (endPage - startPage < pageRange - 1) {
                            startPage = Math.max(1, endPage - pageRange + 1);
                        }

                        for (let i = startPage; i <= endPage; i++) {
                            const pageButton = document.createElement('button');
                            pageButton.textContent = i;
                            pageButton.className = 'btn btn-outline-primary btn-sm mx-1';
                            if (i === currentPage) {
                                pageButton.classList.add('active');
                                pageButton.classList.remove('btn-outline-primary');
                                pageButton.classList.add('btn-primary');
                            }
                            pageButton.addEventListener('click', () => showPage(i));
                            pagination.appendChild(pageButton);
                        }

                        // Create Next button
                        const nextButton = document.createElement('button');
                        nextButton.textContent = 'Next';
                        nextButton.className = 'btn btn-primary btn-sm mx-1';
                        nextButton.disabled = currentPage === totalPages;
                        nextButton.addEventListener('click', () => {
                            if (currentPage < totalPages) {
                                showPage(currentPage + 1);
                            }
                        });
                        pagination.appendChild(nextButton);
                    }

                    showPage(1);
                });
            </script>
        </div>
    </div>
    <!-- Offcanvas to add new user -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
        <div class="offcanvas-header border-bottom">
            <h6 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h6>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <form class="add-new-user pt-0" id="addNewUserForm" action="/members/users/add" method="post">
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
                    <input type="text" class="form-control" id="add-user-email" placeholder="Email" name="email"
                        aria-label="Sub Menu Name" />
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
                {{-- <div class="mb-3">
                    <label class="form-label" for="add-user-access_accessbot">Access BOT</label>
                    <input type="text" class="form-control" id="add-user-accessbot" placeholder="Access Bot manage"
                        name="access_bot" aria-label="Sub Menu Name" />
                    @error('access_bot')
                        <div id="error-access_bot" class="text-danger">{{ $message }}</div>
                        <!-- Pesan error dari server-side -->
                    @enderror
                    <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                    <div id="error-access_bot-js" class="text-danger"></div>
                </div> --}}
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
                <div class="text-center">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 mt-6 data-submit" id="adduser"
                        data-bs-dismiss="offcanvas">Submit</button>
                </div>
            </form>
        </div>
        <script>
            document.getElementById('adduser').addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah pengiriman form secara default

                // Ambil data form
                let formData = new FormData(document.getElementById('addNewUserForm'));
                console.log('Get data success');
                // Hapus pesan error sebelumnya
                document.querySelectorAll('.text-danger').forEach(function(el) {
                    el.innerHTML = '';
                });
                console.log('start ajax');

                // Kirimkan data menggunakan AJAX
                $.ajax({
                    url: '/members/users/add',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            }).then(function() {
                                window.location.href = '/members';
                            });
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        console.log(xhr.responseText);
                        // Setel ulang nilai form dari formData
                        document.getElementById('add-user-fullname').value = formData.get('full_name');
                        document.getElementById('add-user-username').value = formData.get('username');
                        document.getElementById('add-user-nip').value = formData.get('nip');
                        document.getElementById('add-user-idtelegram').value = formData.get('telegram_id');
                        document.getElementById('add-user-email').value = formData.get('email');
                        document.getElementById('add-user-password').value = formData.get('password');
                        // document.getElementById('add-user-accessbot').value = formData.get('access_bot');
                        document.getElementById('add-user-role').value = formData.get('role');

                        // Tampilkan pesan error di bawah masing-masing input
                        if (errors.full_name) {
                            document.getElementById('error-full_name-js').innerHTML = errors.full_name[0];
                        }
                        if (errors.username) {
                            document.getElementById('error-username-js').innerHTML = errors.username[0];
                        }
                        if (errors.nip) {
                            document.getElementById('error-nip-js').innerHTML = errors.nip[0];
                        }
                        if (errors.telegram_id) {
                            document.getElementById('error-telegram_id-js').innerHTML = errors.telegram_id[
                                0];
                        }
                        if (errors.email) {
                            document.getElementById('error-email-js').innerHTML = errors.email[0];
                        }
                        if (errors.password) {
                            document.getElementById('error-password-js').innerHTML = errors.password[0];
                        }
                        // if (errors.access_bot) {
                        //     document.getElementById('error-access_bot-js').innerHTML = errors.access_bot[0];
                        // }
                        if (errors.role) {
                            document.getElementById('error-role-js').innerHTML = errors.role[0];
                        }

                        // Tampilkan SweetAlert untuk menampilkan pesan error umum
                        Swal.fire({
                            title: 'Error!',
                            text: 'Please correct the highlighted fields.',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    }
                });
            });
        </script>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select the modal element
            var addPermissionModal = document.getElementById('addPermissionModal');

            // Add an event listener to the modal when it is about to be shown
            addPermissionModal.addEventListener('show.bs.modal', function() {
                // Select all checkboxes inside the modal and uncheck them
                var checkboxes = addPermissionModal.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false; // Uncheck the checkbox
                });
            });
        });
    </script>
    <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center mt-4">
                        <h3>Add Role Model</h3>
                        <p>Permissions you may use and assign to your users.</p>
                    </div>
                    <form id="addPermissionForm" class="row" action="{{ url('/members/role/add') }}" method="post">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label" for="modalPermissionName">Role Access Name</label>
                            <input type="text" id="name" name="name" class="form-control"
                                placeholder="Permission Name" autofocus />
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
                                                                                    <label class="switch switch-success">
                                                                                        <input type="checkbox"
                                                                                            class="switch-input"
                                                                                            name="sub_menus[]"
                                                                                            value="{{ $subMenu['sub_menu_id'] }}" />
                                                                                        <span class="switch-toggle-slider">
                                                                                            <span class="switch-on">
                                                                                                <i class="bx bx-check"></i>
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
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Edit Button ID Users --}}
    <!-- Modal HTML remains the same as before -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3>Edit User</h3>
                        <p>Modify the selected user details.</p>
                    </div>
                    <form id="editUserForm" class="row" action="{{ url('/members/users/edit') }}" method="post">
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
                                @foreach ($roles as $role)
                                    @if ($role->id !== 1)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 text-center demo-vertical-spacing">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.edit-button').forEach(button => {
                button.addEventListener('click', function() {
                    var user = JSON.parse(this.getAttribute('data-user'));

                    // Isi modal dengan data pengguna
                    document.getElementById('edit_user_id').value = user.id;
                    document.getElementById('edit_nip').value = user.nip;
                    document.getElementById('edit_full_name').value = user.full_name;
                    document.getElementById('edit_username').value = user.username;
                    document.getElementById('edit_telegram_id').value = user.telegram_id;
                    document.getElementById('edit_email').value = user.email;
                    document.getElementById('edit_access_bot').value = user.access_bot;
                    document.getElementById('edit_status').value = user.status;
                    document.getElementById('edit_role').value = user.role_id.id;
                    document.getElementById('edit_password').value = '';
                    // Tampilkan modal
                    $('#editUserModal').modal('show');
                });
            });
        });
        document.getElementById('editUserForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form dikirim langsung

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to save the changes?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#editUserModal').modal('hide');
                    Swal.fire(
                        'Saved!',
                        'Your changes have been saved.',
                        'success'
                    )
                    // Submit form setelah konfirmasi
                    event.target.submit();
                }
            });
        });
    </script>

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
                                                                @if (isset($subMenus) && is_array($subMenus) && count($subMenus) >= 8)
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

                            <div class="col-12 mt-3 text-center">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.role-edit-modal').on('click', function() {
                var roleId = $(this).data('role-id');
                var roleName = $(this).data('role-name');
                var selectedSubMenus = $(this).data('role-submenus');
                selectedSubMenus = selectedSubMenus.map(item => item
                    .sub_menu_id); // Ambil hanya sub_menu_id

                // Set nilai pada modal form
                $('#editModalRole #name-edit').val(roleName);
                $('#editModalRole #roleId').val(roleId);

                // Cek checkbox berdasarkan sub_menu_id yang sudah dimiliki role
                $('input[name="sub_menus[]"]').each(function() {
                    if (selectedSubMenus.includes(parseInt($(this).val()))) {
                        $(this).prop('checked', true); // Centang checkbox jika ada di list
                    } else {
                        $(this).prop('checked', false); // Hilangkan centang jika tidak ada
                    }
                });

                // Tampilkan modal
                $('#editModalRole').modal('show');
            });
        });
    </script>
@endsection
