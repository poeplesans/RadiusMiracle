@extends('layouts.main.main')

@section('page-up')
    <!-- Icons -->
    <link rel="stylesheet" href="../resource/assets/vendor/libs/sweetalert2/sweetalert2.css" />
@endsection

<!-- Vendors JS -->
@section('page-down')
    <!-- Page JS -->
    <script src="../resource/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="../resource/assets/js/extended-ui-sweetalert2.js"></script>
@endsection

@section('container')
    <div class="m-5 flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-2">Header's & Menu's Navigation's List</h4>

        <p>
            A role provided access to predefined menus and features so that depending on <br />
            assigned role an administrator can have access to what user needs.
        </p>

        <!-- Role cards -->
        <div class="row g-4">
            @foreach ($menuArray as $header => $menus)
                {{-- {{ dd($menus) }} --}}
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                @php
                                    // Hitung jumlah sub-menu dalam menu
                                    $totalSubMenus = count($menus);
                                @endphp
                                <!-- Menampilkan jumlah sub-menu -->
                                <h6 class="fw-normal">Total {{ $totalSubMenus }} Submenu</h6>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="role-heading">
                                    <h4 class="mb-1">{{ $header }}</h4>
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editModalHeader"
                                        class="role-edit-modal" data-id="{{ $menus['header_id'] }}"
                                        data-name="{{ $header }}"><small>Edit Role</small></a>
                                </div>
                                <a href="javascript:void(0);" class="text-muted delete-header"
                                    data-id="{{ $menus['header_id'] }}"><i class="bx bx-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const deleteButtons = document.querySelectorAll('.delete-header');

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
                                        url: '/header-menu/header/delete/' +
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
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="row h-100">
                        <div class="col-sm-5">
                            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                                <img src="../resource/assets/img/illustrations/lady-with-laptop-light.png" class="img-fluid"
                                    alt="Image" width="100"
                                    data-app-light-img="illustrations/lady-with-laptop-light.png"
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
                                        <input class="form-control me-2" type="search" placeholder="Search"
                                            aria-label="Search" id="search">

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
                                    <th class="text-center">Group Name</th>
                                    <th class="text-center">Count Menu</th>
                                    <th class="text-center">Count Sub-Menu</th>
                                    <th class="text-center">Icon</th>
                                    <th class="text-center">Url</th>
                                    <th class="text-center">Create At</th>
                                    <th class="text-center">Update AT</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- {{ dd($menuArray) }} --}}
                                @foreach ($menuArray as $header => $menus)
                                    {{-- {{ dd($menus) }} --}}
                                    @foreach ($menus['menus'] as $menuName => $subMenus)
                                        {{-- @php
                                        dd($subMenus); // Debugging: Melihat struktur data menuData
                                    @endphp --}}
                                        {{-- {{ dd($menus['header_id']) }} --}}
                                        @if (isset($subMenus['menu_id']))
                                            <tr>
                                                <td class="small text-center">{{ $subMenus['menu_id'] }}</td>
                                                <td class="small text-center">{{ $menuName }}</td>
                                                <td class="small text-center">
                                                    @php
                                                        // Hitung jumlah menu dalam setiap header
                                                        $numericSubMenus = array_filter(
                                                            $subMenus,
                                                            function ($key) {
                                                                return is_numeric($key); // Hanya ambil elemen dengan indeks numerik
                                                            },
                                                            ARRAY_FILTER_USE_KEY,
                                                        );

                                                        $totalSubMenus = count($numericSubMenus);
                                                    @endphp
                                                    {{ $totalSubMenus }} <!-- Menampilkan jumlah menu -->
                                                </td>
                                                <td class="small text-center">{{ $header }}</td>
                                                <td class="small "><i class="{{ $subMenus['icon'] }}"></i> {{ $subMenus['icon'] }}</td>
                                                <td class="small text-center">{{ $subMenus['url'] }}</td>
                                                <td class="small text-center">{{ $subMenus['created_at'] }}</td>
                                                <td class="small text-center">{{ $subMenus['updated_at'] }}</td>
                                                <td class="small text-center" style="">
                                                    {{-- {{ dd($subMenus) }} --}}
                                                    <div class="d-inline-block text-nowrap">
                                                        <!-- Tombol Edit -->
                                                        <button type="button" class="btn btn-sm btn-icon edit-button-menu"
                                                            data-user='@json($subMenus)'
                                                            data-name='{{ $menuName }}'
                                                            data-header='{{ $menus['header_id'] }}'>
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-icon delete-menu"
                                                            data-id="{{ $subMenus['menu_id'] }}">
                                                            <i class="bx bx-trash">
                                                            </i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div id="pagination" class="d-flex justify-content-end m-3"></div>
                </div>
                <div class="modal fade" id="editModalMenu" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content p-3 p-md-5">
                            <div class="modal-body">
                                <div class="text-center mb-4">
                                    <h3>Edit Menu Modal</h3>
                                    <p>Modify the selected menu and sub-menu details.</p>
                                </div>
                                <form id="editUserForm" class="row" action="{{ url('/header-menu/menu/edit') }}"
                                    method="post">
                                    @csrf
                                    <input type="hidden" id="editmenuid" name="id" />
                                    <div class="col-12 mb-3">
                                        <label class="form-label" for="editmenuname">Menu Name</label>
                                        <input type="text" id="editmenuname" name="name" class="form-control"
                                            placeholder="Sub Menu Name" />
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label" for="editheadername">Menu Name</label>
                                        <select class="form-select" id="editheadername" name="header_id">
                                            <option value="">Select</option>
                                            @foreach ($menuArray as $header => $menus)
                                                <option value="{{ $menus['header_id'] }}">{{ $header }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label" for="editmenuicon">Icon</label>
                                        <input type="text" id="editmenuicon" name="icon" class="form-control"
                                            placeholder="Icon Menu" />
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
                        document.querySelectorAll('.edit-button-menu').forEach(button => {
                            button.addEventListener('click', function() {
                                var user = JSON.parse(this.getAttribute('data-user'));
                                var header = this.getAttribute('data-header');
                                var name = this.getAttribute('data-name');
                                console.log(header)
                                // Isi modal dengan data pengguna
                                document.getElementById('editmenuicon').value = user.icon;
                                document.getElementById('editheadername').value = header;
                                document.getElementById('editmenuname').value = name;
                                document.getElementById('editmenuid').value = user.menu_id;
                                var headerSelect = document.getElementById('editheadername');
                                headerSelect.value =
                                    header; // Pastikan headerId cocok dengan nilai value dalam select
                                // Tampilkan modal
                                $('#editModalMenu').modal('show');
                            });
                        });
                    });
                    document.getElementById('editUserForm').addEventListener('submit', function(event) {
                        event.preventDefault(); // Mencegah form dikirim langsung
                        $('#editModalMenu').modal('hide');
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
                            } else {
                                $('#editModalMenu').modal('show');
                            }
                        });
                    });
                    document.addEventListener('DOMContentLoaded', function() {
                        const deleteButtons = document.querySelectorAll('.delete-menu');

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
                                            url: '/header-menu/menu/delete/' +
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
                <!--/ Role Table -->
            </div>
        </div>
        <!--/ Role cards -->

        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
            aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header border-bottom">
                <h6 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h6>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form class="add-new-user pt-0" id="addNewUserForm" action="{{ url('/header-menu/menu/add') }}"
                    method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="add-user-fullname">Sub Menu Name</label>
                        <input type="text" class="form-control" id="add-user-fullname" placeholder="Sub Menu Name"
                            name="name" aria-label="Sub Menu Name" />
                        @error('name')
                            <div id="error-submenuName" class="text-danger">{{ $message }}</div>
                            <!-- Pesan error dari server-side -->
                        @enderror
                        <!-- Div untuk pesan error dari JavaScript (validasi AJAX) -->
                        <div id="error-submenuName-js" class="text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="add-user-email">Icon</label>
                        <input type="text" id="add-user-email" class="form-control" placeholder="Icon class here"
                            aria-label="icon" name="icon" />
                        @error('icon')
                            <div id="error-icon" class="text-danger">{{ $message }}</div>
                            <!-- Pesan error dari server-side -->
                        @enderror
                        <div id="error-icon-js" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="country">Menu</label>
                        <select id="country" class="form-select" name="header_id">
                            <option value="">Select</option>
                            @foreach ($menuArray as $header => $menus)
                                <option value="{{ $menus['header_id'] }}"
                                    {{ old('header_id') == $menus['header_id'] ? 'selected' : '' }}>
                                    {{ $header }}
                                </option>
                            @endforeach
                        </select>
                        @error('header_id')
                            <div id="error-menuId" class="text-danger">{{ $message }}</div>
                            <!-- Pesan error dari server-side -->
                        @enderror
                        <div id="error-menuId-js" class="text-danger"></div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 mt-6 data-submit" id="confirm-color-1"
                            data-bs-dismiss="offcanvas">Submit</button>
                    </div>
                </form>

            </div>
            <script>
                document.getElementById('confirm-color-1').addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah pengiriman form secara default

                    // Ambil data form
                    let formData = new FormData(document.getElementById('addNewUserForm'));

                    // Hapus pesan error sebelumnya
                    document.querySelectorAll('.text-danger').forEach(function(el) {
                        el.innerHTML = '';
                    });

                    // Kirimkan data menggunakan AJAX
                    $.ajax({
                        url: '/header-menu/menu/add',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
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
                                    // Redirect otomatis setelah alert
                                    window.location.href = '/header-menu';
                                });
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.responseJSON);
                            let errors = xhr.responseJSON.errors;

                            // Tampilkan pesan error di bawah masing-masing input
                            if (errors.name) {
                                document.getElementById('error-submenuName-js').innerHTML = errors.name[
                                    0];
                            }
                            // if (errors.url) {
                            //     document.getElementById('error-url-js').innerHTML = errors.url[0];
                            // }
                            if (errors.header_id) {
                                document.getElementById('error-menuId-js').innerHTML = errors.header_id[0];
                            }
                            if (errors.icon) {
                                document.getElementById('error-icon-js').innerHTML = errors.icon[0];
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

        <!-- Add Permission Modal -->
        <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <h3>Add New Header</h3>
                            <p>Permissions you may use and assign to your users.</p>
                        </div>
                        <form id="addPermissionForm" class="row" action="{{ url('/header-menu/header/add') }}"
                            method="post">
                            @csrf
                            <div class="col-12 mb-3">
                                <label class="form-label" for="modalPermissionName">Header Name</label>
                                <input type="text" id="name" name="modalPermissionName" class="form-control"
                                    placeholder="Permission Name" autofocus />
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
                // get variable modal
                var modal = document.getElementById('editModalHeader');
                var editMenuId = document.getElementById('edit_header_id');
                var editHeaderName = document.getElementById('edit_header_name');

                // Fungsi untuk membuka modal
                function openModal(event) {
                    var button = event.currentTarget; // Tombol yang diklik

                    // Ambil data dari tombol
                    var subMenuId = button.getAttribute('data-id');
                    var menuName = button.getAttribute('data-name');

                    // Isi form dengan data yang diambil
                    editMenuId.value = subMenuId;
                    editHeaderName.value = menuName;


                    // Tampilkan modal
                    var bsModal = new bootstrap.Modal(modal);
                    bsModal.show();
                }

                // Tambahkan event listener untuk semua tombol dengan kelas 'edit-button'
                document.querySelectorAll('.role-edit-modal').forEach(function(button) {
                    button.addEventListener('click', openModal);
                });
            });
        </script>
        <div class="modal fade" id="editModalHeader" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <h3>Edit Header</h3>
                            <p>Permissions you may use and assign to your users.</p>
                        </div>
                        <form id="addPermissionForm" class="row" action="{{ url('/header-menu/header/edit') }}"
                            method="post">
                            @csrf
                            <input type="hidden" id="edit_header_id" name="id" />
                            <div class="col-12 mb-3">
                                <label class="form-label" for="modalPermissionName">Header Name</label>
                                <input type="text" id="edit_header_name" name="name" class="form-control"
                                    placeholder="Permission Name" autofocus />
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
            document.getElementById('addPermissionForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                var form = this;
                var formData = new FormData(form);
                console.log(form.method)
                console.log(formData)

                // Use AJAX to submit the form
                fetch(form.action, {
                        method: form.method,
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Show success alert
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // Optionally close the modal
                            $('#addPermissionModal').modal('hide');

                            // Clear the form
                            form.reset();
                        } else {
                            // Show error alert
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message,
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.',
                        });
                    });
            });
        </script>
        <!--Edit Menu Modal -->
    </div>
@endsection
