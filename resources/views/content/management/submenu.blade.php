@extends('layouts.main.main')
@section('page-up')
    <!-- Icons -->
    <link rel="stylesheet" href="../resource/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/css/pages/app-calendar.css" />
@endsection

<!-- Vendors JS -->
@section('page-down')
    <!-- Page JS -->
    <script src="../resource/assets/js/app-calendar-events.js"></script>
    <script src="../resource/assets/js/app-calendar.js"></script>
    <script src="../resource/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="../resource/assets/js/extended-ui-sweetalert2.js"></script>
@endsection

@section('container')
    <div class="m-5 flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-2">SubMenu Navigation's Setting</h4>

        <p>
            A role provided access to predefined menus and features so that depending on <br />
            assigned role an administrator can have access to what user needs.
        </p>

        <!-- Role cards -->
        <div class="row g-4">
            <div class="col-12">
                <!-- Role Table -->
                <div class="card">
                    <!-- Search form and Rows per Page dropdown -->
                    <div class="row m-3">
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
                                        {{-- <button class="btn btn-outline-success" type="submit" id="searchButton">Find</button> --}}
                                    </form>
                                    <button class="btn btn-outline-success" type="submit" id="searchButton"
                                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">Add</button>
                                </div>
                            </div>
                        </div>
                        {{-- <!-- Search input on the right -->
                    <div class="col-md-3 d-flex mt-3 justify-content-end align-items-center">
                        <input type="text" id="search" class="form-control" placeholder="Search...">
                    </div> --}}
                    </div>

                    <!-- Table -->
                    <div class="m-3 table-responsive">
                        <table class="table table-hover" id="membersTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sub Menu</th>
                                    <th>Menu</th>
                                    <th>Header</th>
                                    {{-- <th>Icon</th> --}}
                                    <th>Url</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- {{ dd($subMenuData[0]) }} --}}
                                @foreach ($subMenuData as $data)
                                    @if (isset($data['sub_menu_id']))
                                        <tr>
                                            <td class="small">{{ $data['sub_menu_id'] }}</td>
                                            <td class="small">{{ $data['sub_menu_name'] }}</td>
                                            <td class="small">{{ $data['menu_name'] }}</td>
                                            <td class="small">{{ $data['header_name'] }}</td>
                                            {{-- <td class="small">
                                            @if (isset($data['sub_menu_icon']))
                                                <i class="{{ $data['sub_menu_icon'] }}"></i>
                                            @endif
                                        </td> --}}
                                            <td class="small">{{ $data['sub_menu_url'] }}</td>
                                            <td class="small">{{ $data['created_at'] }}</td>
                                            <td class="small">{{ $data['updated_at'] }}</td>
                                            <td class="small text-center" style="">
                                                <div class="d-inline-block text-nowrap">
                                                    <!-- Tombol Edit -->
                                                    <button type="button" id="confirm-color-2"
                                                        class="btn btn-sm btn-icon edit-button"
                                                        data-id="{{ $data['sub_menu_id'] }}"
                                                        data-menu-id="{{ $data['menu_id'] }}"
                                                        data-menu-name="{{ $data['menu_name'] }}"
                                                        data-header-name="{{ $data['header_name'] }}"
                                                        data-sub-menu-name="{{ $data['sub_menu_name'] }}"
                                                        data-sub-menu-url="{{ $data['sub_menu_url'] }}">
                                                        <i class="bx bx-edit"></i>
                                                    </button>

                                                    <!-- Tombol Hapus -->
                                                    <button type="button" class="btn btn-sm btn-icon delete-record"
                                                        data-id="{{ $data['sub_menu_id'] }}">
                                                        <i class="bx bx-trash"></i>
                                                    </button>


                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div id="pagination" class="d-flex justify-content-end m-3"></div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        let rowsPerPage = parseInt(document.getElementById('rowsPerPage').value);
                        const originalRows = Array.from(document.querySelectorAll('#membersTable tbody tr'));
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
                {{-- Event listener untuk tombol hapus --}}
                <script>
                    // Event listener untuk tombol hapus
                    document.addEventListener('DOMContentLoaded', function() {
                        const deleteButtons = document.querySelectorAll('.delete-record');

                        deleteButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                // Ambil data-id dari tombol
                                const menuId = this.getAttribute('data-id');

                                // Tampilkan SweetAlert untuk konfirmasi
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, delete it!',
                                    cancelButtonText: 'Cancel',
                                    customClass: {
                                        confirmButton: 'btn btn-primary me-3',
                                        cancelButton: 'btn btn-label-secondary'
                                    },
                                    buttonsStyling: false
                                }).then(function(result) {
                                    if (result.value) {
                                        // Jika dikonfirmasi, jalankan request Ajax
                                        $.ajax({
                                            url: '/sub-menu/delete/' +
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
                                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                                        Swal.fire({
                                            title: 'Cancelled',
                                            text: 'Your data is safe :)',
                                            icon: 'error',
                                            confirmButtonText: 'OK',
                                            customClass: {
                                                confirmButton: 'btn btn-secondary'
                                            }
                                        });
                                    }
                                });
                            });
                        });
                    });
                </script>
                <!--/ Role Table -->
            </div>
        </div>
        <!--/ Role cards -->

        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header border-bottom">
                <h6 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h6>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form class="add-new-user pt-0" id="addNewUserForm" action="{{ url('/sub-menu/add') }}" method="post">
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
                        <label class="form-label" for="add-user-contact">Url</label>
                        <input type="text" id="add-user-contact" class="form-control" placeholder="Enter URL"
                            aria-label="url" name="url" />
                        @error('url')
                            <div id="error-url" class="text-danger">{{ $message }}</div>
                            <!-- Pesan error dari server-side -->
                        @enderror
                        <div id="error-url-js" class="text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="country">Menu</label>
                        <select id="country" class="form-select" name="menu_id">
                            <option value="">Select</option>
                            @foreach ($menuArray as $header => $menus)
                                @foreach ($menus['menus'] as $menuName => $subMenus)
                                    <option value="{{ $subMenus['menu_id'] }}"
                                        {{ old('menuId') == $subMenus['menu_id'] ? 'selected' : '' }}>
                                        {{ $menuName }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                        @error('menu_id')
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
                    console.log(formData);
                    // Hapus pesan error sebelumnya
                    document.querySelectorAll('.text-danger').forEach(function(el) {
                        el.innerHTML = '';
                    });

                    // Kirimkan data menggunakan AJAX
                    $.ajax({
                        url: '/sub-menu/add',
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
                                    window.location.href = '/sub-menu';
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
                            if (errors.url) {
                                document.getElementById('error-url-js').innerHTML = errors.url[0];
                            }
                            if (errors.menu_id) {
                                document.getElementById('error-menuId-js').innerHTML = errors.menu_id[0];
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // get variable modal
                var modal = document.getElementById('editPermissionModal');
                var editMenuId = document.getElementById('edit_menu_id');
                var editSubMenuName = document.getElementById('edit_sub_menu_name');
                var editMenuName = document.getElementById('edit_menu_name');
                var editHeaderName = document.getElementById('edit_header_name');
                var editSubMenuUrl = document.getElementById('edit_sub_menu_url');

                // Fungsi untuk membuka modal
                function openModal(event) {
                    var button = event.currentTarget; // Tombol yang diklik

                    // Ambil data dari tombol
                    var subMenuId = button.getAttribute('data-id');
                    var menuId = button.getAttribute('data-menu-id');
                    var menuName = button.getAttribute('data-menu-name');
                    var headerName = button.getAttribute('data-header-name');
                    var subMenuName = button.getAttribute('data-sub-menu-name');
                    var subMenuUrl = button.getAttribute('data-sub-menu-url');

                    // Isi form dengan data yang diambil
                    editMenuId.value = subMenuId;
                    editSubMenuName.value = subMenuName;
                    editMenuName.value = menuId; // Pilih menuName pada select2
                    editHeaderName.value = headerName;
                    editSubMenuUrl.value = subMenuUrl;

                    // Tampilkan modal
                    var bsModal = new bootstrap.Modal(modal);
                    bsModal.show();
                }

                // Tambahkan event listener untuk semua tombol dengan kelas 'edit-button'
                document.querySelectorAll('.edit-button').forEach(function(button) {
                    button.addEventListener('click', openModal);
                });
            });
        </script>


        <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <h3>Edit Menu</h3>
                            <p>Modify the selected menu and sub-menu details.</p>
                        </div>
                        <form id="editPermissionForm" class="row" action="{{ url('/sub-menu/edit') }}"
                            method="post">
                            @csrf
                            <input type="hidden" id="edit_menu_id" name="id" />
                            <div class="col-12 mb-3">
                                <label class="form-label" for="edit_sub_menu_name">Sub Menu Name</label>
                                <input type="text" id="edit_sub_menu_name" name="name" class="form-control"
                                    placeholder="Sub Menu Name" />
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="edit_menu_name">Menu Name</label>
                                <select class="form-select" id="edit_menu_name" name="menu_id">
                                    <option value="">Select</option>
                                    @foreach ($menuArray as $header => $menus)
                                        @foreach ($menus['menus'] as $menuName => $subMenus)
                                            <option value="{{ $subMenus['menu_id'] }}">{{ $menuName }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="edit_header_name">Header Name</label>
                                <input type="text" id="edit_header_name" name="header_name" class="form-control"
                                    placeholder="Header Name" readonly />
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="edit_sub_menu_url">Sub Menu URL</label>
                                <input type="text" id="edit_sub_menu_url" name="url" class="form-control"
                                    placeholder="Sub Menu URL" />
                            </div>
                            <div class="col-12 text-center demo-vertical-spacing">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- / Add Role Modal -->
@endsection
