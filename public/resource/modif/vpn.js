/**
 * Page User List
 */

'use strict';


// Datatable (jquery)
$(function () {
    
    var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil CSRF token dari meta tag
    var apiUrl = '/members/api'; // URL API

    let borderColor, bodyBg, headingColor;

    if (isDarkStyle) {
        borderColor = config.colors_dark.borderColor;
        bodyBg = config.colors_dark.bodyBg;
        headingColor = config.colors_dark.headingColor;
    } else {
        borderColor = config.colors.borderColor;
        bodyBg = config.colors.bodyBg;
        headingColor = config.colors.headingColor;
    }

    // Variable declaration for table
    var dt_user_table = $('.datatables-users'),
        select2 = $('.select2'),
        userView = 'user/',
        statusObj = {
            1: { title: 'inactive', class: 'bg-label-warning' },
            2: { title: 'active', class: 'bg-label-success' },
            3: { title: 'waitting', class: 'bg-label-secondary' }
        };
    function findKeyByTitle(title) {
        var resultKeys = []; // To store keys that match the title

        for (var key in statusObj) {
            if (statusObj.hasOwnProperty(key)) {
                if (statusObj[key].title === title) {
                    resultKeys.push(key); // Add the key to results if it matches
                }
            }
        }

        return resultKeys; // Return the array of matching keys
    }

    if (select2.length) {
        var $this = select2;
        $this.wrap('<div class="position-relative"></div>').select2({
            placeholder: 'Select Country',
            dropdownParent: $this.parent()
        });
    }
    // Fungsi untuk mengambil data dari API
    function fetchUserData(apiUrl, csrfToken) {
        return fetch(apiUrl, {
            method: 'GET',
            // headers: {
            //   'X-CSRF-TOKEN': csrfToken,
            //   'Content-Type': 'application/json'
            // }
        })
            .then(response => {
                // console.log(response)
                console.log('Filtered Events:', usersData);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    return usersData; // Mengambil data jika status success
                    // return data.data; // Mengambil data jika status success
                } else {
                    throw new Error('Error fetching data');
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                return [];
            });
    }
    // Users datatable
    if (dt_user_table.length) {
        // console.log(usersData)
        var dt_user = dt_user_table.DataTable({
            data: usersData, // JSON file to add data
            // ajax: function (data, callback, settings) {
            //     // Panggil fungsi fetchUserData yang sudah dibuat
            //     fetchUserData(apiUrl, csrfToken)
            //         .then(responseData => {
            //             callback({
            //                 data: responseData // Data yang diterima dari API
            //             });
            //         })
            //         .catch(error => {
            //             // console.error('Error in DataTable:', error);
            //             callback({
            //                 data: [] // Kembalikan array kosong jika ada error
            //             });
            //         });
            // },
            columns: [
                // columns according to JSON
                { data: '' },
                { data: 'full_name' },
                { data: 'nip' },
                { data: 'telegram_id' },
                { data: 'access_bot' },
                { data: 'status' },
                { data: 'role' },
                { data: 'action' }
            ],
            columnDefs: [
                {
                    // For Responsive
                    className: 'control',
                    searchable: false,
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0,
                    render: function (data, type, full, meta) {
                        return '';
                    }
                },
                {
                    // User full name and email
                    targets: 1,
                    responsivePriority: 4,
                    render: function (data, type, full, meta) {
                        var $name = full['full_name'],
                            $email = full['email'],
                            $username = full['nip'],
                            $image = full['avatar'];
                        if ($image) {
                            // For Avatar image
                            var $output =
                                '<img src="' + assetsPath + 'img/avatars/' + $image + '" alt="Avatar" class="rounded-circle">';
                        } else {
                            // For Avatar badge
                            var stateNum = Math.floor(Math.random() * 6);
                            var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                            var $state = states[stateNum],
                                $name = full['full_name'],
                                $initials = $name.match(/\b\w/g) || [];
                            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                            $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';
                        }
                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-start align-items-center user-name">' +
                            '<div class="avatar-wrapper">' +
                            '<div class="avatar avatar-sm me-3">' +
                            $output +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<a href="' +
                            userView + $username +
                            '" class="text-body text-truncate"><span class="fw-medium">' +
                            $name + ' [' + $username + ']' +
                            '</span></a>' +
                            '<small class="text-muted">' +
                            $email +
                            '</small>' +
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },
                // {
                //   // User nip
                //   targets: 2,
                //   render: function (data, type, full, meta) {
                //     var $role = full['nip'];
                //     var roleBadgeObj = {
                //       Subscriber:
                //         '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2"><i class="bx bx-user bx-xs"></i></span>',
                //       Author:
                //         '<span class="badge badge-center rounded-pill bg-label-success w-px-30 h-px-30 me-2"><i class="bx bx-cog bx-xs"></i></span>',
                //       Maintainer:
                //         '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2"><i class="bx bx-pie-chart-alt bx-xs"></i></span>',
                //       Editor:
                //         '<span class="badge badge-center rounded-pill bg-label-info w-px-30 h-px-30 me-2"><i class="bx bx-edit bx-xs"></i></span>',
                //       Admin:
                //         '<span class="badge badge-center rounded-pill bg-label-secondary w-px-30 h-px-30 me-2"><i class="bx bx-mobile-alt bx-xs"></i></span>'
                //     };
                //     return "<span class='text-truncate d-flex align-items-center'>" + roleBadgeObj[$role] + $role + '</span>';
                //   }
                // },
                {
                    // Plans
                    targets: 2,
                    render: function (data, type, full, meta) {
                        var $plan = full['username'];

                        return '<span class="fw-medium">' + $plan + '</span>';
                    }
                },
                {
                    // Plans
                    targets: 3,
                    render: function (data, type, full, meta) {
                        var $plan = full['telegram_id'];

                        return '<span class="fw-medium">' + $plan + '</span>';
                    }
                },
                {
                    // Plans
                    targets: 4,
                    render: function (data, type, full, meta) {
                        var $plan = full['email'];

                        return '<span class="fw-medium">' + $plan + '</span>';
                    }
                },
                {
                    // User Status
                    targets: 5,
                    render: function (data, type, full, meta) {
                        var $status = full['status'];
                        var activeKeys = findKeyByTitle($status);
                        var statusInfo = statusObj[activeKeys]; // Assume data is 1, 2, or 3
                        if (statusInfo) {
                            return '<span class="badge ' + statusInfo.class + '">' + statusInfo.title + '</span>';
                        } else {
                            return '<span class="badge bg-label-secondary">Unknown</span>'; // Fallback for unknown status
                        }
                        // return '<span class="badge bg-label-warning">' + $status + '</span>';
                    }
                },
                {
                    // Actions
                    targets: -1,
                    title: 'Actions',
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        // console.log(data)
                        var $username = full['username']
                        return (
                            '<div class="d-inline-block text-nowrap">' +
                            '<button class="btn btn-sm btn-icon edit-button" data-user=\'' + JSON.stringify(full).replace(/'/g, "&apos;") + '\'><i class="bx bx-edit"></i></button>' +
                            '<button class="btn btn-sm btn-icon delete-record"><i class="bx bx-trash"></i></button>' +
                            '</div>'
                        );
                    }
                }
            ],
            order: [[1, 'desc']],
            dom:
                '<"row mx-2"' +
                '<"col-md-2"<"me-3"l>>' +
                '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
                '>t' +
                '<"row mx-2"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            language: {
                sLengthMenu: '_MENU_',
                search: '',
                searchPlaceholder: 'Search..'
            },
            // Buttons with Dropdown
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-label-secondary dropdown-toggle mx-3',
                    text: '<i class="bx bx-export me-1"></i>Export',
                    buttons: [
                        {
                            extend: 'print',
                            text: '<i class="bx bx-printer me-2" ></i>Print',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5],
                                // prevent avatar to be print
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            },
                            customize: function (win) {
                                //customize print view for dark
                                $(win.document.body)
                                    .css('color', headingColor)
                                    .css('border-color', borderColor)
                                    .css('background-color', bodyBg);
                                $(win.document.body)
                                    .find('table')
                                    .addClass('compact')
                                    .css('color', 'inherit')
                                    .css('border-color', 'inherit')
                                    .css('background-color', 'inherit');
                            }
                        },
                        {
                            extend: 'csv',
                            text: '<i class="bx bx-file me-2" ></i>Csv',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5],
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'excel',
                            text: '<i class="bx bxs-file-export me-2"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5],
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="bx bxs-file-pdf me-2"></i>Pdf',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5],
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'copy',
                            text: '<i class="bx bx-copy me-2" ></i>Copy',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5],
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        }
                    ]
                },
                {
                    text: '<i class="bx bx-plus me-0 me-lg-2"></i><span class="d-none d-lg-inline-block">Add New User</span>',
                    className: 'add-new btn btn-primary ms-n1',
                    attr: {
                        'data-bs-toggle': 'offcanvas',
                        'data-bs-target': '#offcanvasAddUser'
                    }
                }
            ],
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Details of ' + data['full_name'];
                        }
                    }),
                    type: 'column',
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>'
                                : '';
                        }).join('');

                        return data ? $('<table class="table"/><tbody />').append(data) : false;
                    }
                }
            },
            initComplete: function () {
                this.api()
                    .columns(6)
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select id="UserPlan" class="form-select text-capitalize"><option value=""> Select Role </option></select>'
                        )
                            .appendTo('.user_plan')
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                            });
                    });
                // Adding status filter once table initialized
                this.api()
                    .columns(5)
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select id="FilterTransaction" class="form-select text-capitalize"><option value=""> Select Status </option></select>'
                        )
                            .appendTo('.user_status')
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append(
                                    '<option value="' +
                                    d +
                                    '" class="text-capitalize">' +
                                    d +
                                    '</option>'
                                );
                            });
                    });
            }
        });
    }
    // Delete Record
    $('.add-new-user').on('click', '.data-submit', function (res) {
        console.log(res.delegateTarget.getAttribute('id'))
        if (res.delegateTarget.getAttribute('id') === 'addNewRoleForm') {
            var form = document.getElementById('addNewRoleForm');
            var formData = new FormData(form);
            var actionUrl = form.getAttribute('action'); // Mengambil action URL dari form
            console.log(form)
        }

        if (res.delegateTarget.getAttribute('id') === 'addNewUserForm') {
            var form = document.getElementById('addNewUserForm');
            var actionUrl = form.getAttribute('action'); // Mengambil action URL dari form
            var formData = new FormData(form);
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
        }


        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            success: function (response) {
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
                    }).then(function () {
                        window.location.href = '/members';
                    });
                } else {
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
            },
            error: function (xhr) {
                console.log(xhr.responseText); // Lihat detail error
                let errors = xhr.responseJSON ? xhr.responseJSON.errors : null;

                if (errors) {
                    // Loop melalui error dan tampilkan ke pengguna
                    $.each(errors, function (key, value) {
                        console.log('Error pada ' + key + ': ' + value);
                    });
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


            }
        });
    });
    // Delete Record
    // Delete Record
    $('.role-one').on('click', '.delete-role', function () {
        var menuname = $(this).data('name');
        var menuId = $(this).data('id');
        var userCount = $(this).data('user');

        var rolesData = $(this).data('role'); // Ambil data-role dari elemen
        // console.log('Raw rolesData:', rolesData);

        // Cek apakah rolesData masih berupa string dan lakukan parsing
        if (typeof rolesData === 'string') {
            try {
                rolesData = JSON.parse(rolesData); // Parsing jika rolesData adalah string JSON
            } catch (e) {
                console.error('JSON parsing error:', e);
            }
        }

        // console.log(rolesData); // Cek output dari rolesData

        // Cek apakah userCount lebih dari 0
        if (userCount > 0) {
            // console.log('run dropdown');
            // Pastikan rolesData adalah array sebelum menggunakan forEach
            if (Array.isArray(rolesData)) {
                var dropdownOptions = '';
                rolesData.forEach(function (role) {
                    if (role.id != menuId) { // Hindari menampilkan role yang sedang dipilih
                        dropdownOptions += `<option value="${role.id}">${role.name}</option>`;
                    }
                });

                Swal.fire({
                    title: 'Role has users!',
                    html: `<div class="text-center">
                    <span style="font-size: 14px;">Role <b style="color: red;">${menuname}</b> memiliki <b>${userCount}</b> pengguna.</span><br>
                    <select id="newRole" class="swal2-select form-control mt-2" style="font-size: 14px; width: auto; display: inline-block;">
                        ${dropdownOptions}
                    </select>
                </div>`,
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
                        const newRoleId = document.getElementById('newRole').value;
                        if (!newRoleId) {
                            Swal.showValidationMessage('Please select a new role!');
                        }
                        return newRoleId;
                    }
                }).then(function (result) {
                    if (result.isConfirmed) {
                        var newRoleId = result.value;
                        // console.log(newRoleId);

                        // Kirim request AJAX untuk memindahkan user dan menghapus role
                        $.ajax({
                            url: '/members/role/delete/' + menuId,
                            type: 'DELETE',
                            data: {
                                new_role_id: newRoleId, // Role baru untuk pengguna
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        customClass: {
                                            confirmButton: 'btn btn-success'
                                        }
                                    }).then(function () {
                                        $('#role-card-' + menuId).remove();
                                    });
                                }
                            },
                            error: function (xhr) {
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
                console.error('rolesData is not an array');
            }
        } else {
            // Jika userCount <= 0, tampilkan SweetAlert biasa
            Swal.fire({
                title: 'Are you sure?',
                html: 'Do you want to delete <b style="color: red;">' + menuname + '</b> ??',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger me-3',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    // Jika dikonfirmasi, jalankan request Ajax untuk penghapusan
                    $.ajax({
                        url: '/members/role/delete/' + menuId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                }).then(function () {
                                    $('#role-card-' + menuId).remove();
                                });
                            }
                        },
                        error: function (xhr) {
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


    // Delete Record
    $('.datatables-users tbody').on('click', '.delete-record', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to remove the data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // $('#editUserModal').modal('hide');
                Swal.fire(
                    'Saved!',
                    'Your changes have been saved.',
                    'success'
                )
                dt_user.row($(this).parents('tr')).remove().draw();
                // Submit form setelah konfirmasi
                // event.target.submit();
            }
        });
    });
    $(document).on('click', '.edit-button', function () {

        var user = JSON.parse($(this).attr('data-user'));

        // Isi modal dengan data pengguna
        $('#edit_user_id').val(user.id);
        $('#edit_nip').val(user.nip);
        $('#edit_full_name').val(user.full_name);
        $('#edit_username').val(user.username);
        $('#edit_telegram_id').val(user.telegram_id);
        $('#edit_email').val(user.email);
        $('#edit_access_bot').val(user.access_bot);
        $('#edit_status').val(user.status);
        $('#edit_role').val(user.role_id); // Pastikan role_id ada di user

        // Reset password field
        $('#edit_password').val('');
        // Tampilkan modal
        $('#editUserModal').modal('show');
    });

    $('.role-edit-modal').on('click', function () {
        var roleId = $(this).data('role-id');
        var roleName = $(this).data('role-name');
        var selectedSubMenus = $(this).data('role-submenus');
        selectedSubMenus = selectedSubMenus.map(item => item
            .sub_menu_id); // Ambil hanya sub_menu_id

        // Set nilai pada modal form
        $('#editModalRole #name-edit').val(roleName);
        $('#editModalRole #roleId').val(roleId);

        // Cek checkbox berdasarkan sub_menu_id yang sudah dimiliki role
        $('input[name="sub_menus[]"]').each(function () {
            if (selectedSubMenus.includes(parseInt($(this).val()))) {
                $(this).prop('checked', true); // Centang checkbox jika ada di list
            } else {
                $(this).prop('checked', false); // Hilangkan centang jika tidak ada
            }
        });

        // Tampilkan modal
        $('#editModalRole').modal('show');
    });


    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
});

// Validation & Phone mask
(function () {
    const phoneMaskList = document.querySelectorAll('.phone-mask'),
        addNewUserForm = document.getElementById('addNewUserForm');

    // Phone Number
    if (phoneMaskList) {
        phoneMaskList.forEach(function (phoneMask) {
            new Cleave(phoneMask, {
                phone: true,
                phoneRegionCode: 'US'
            });
        });
    }
    // Add New User Form Validation
    const fv = FormValidation.formValidation(addNewUserForm, {
        fields: {
            userFullname: {
                validators: {
                    notEmpty: {
                        message: 'Please enter fullname '
                    }
                }
            },
            userEmail: {
                validators: {
                    notEmpty: {
                        message: 'Please enter your email'
                    },
                    emailAddress: {
                        message: 'The value is not a valid email address'
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                // Use this for enabling/changing valid/invalid class
                eleValidClass: '',
                rowSelector: function (field, ele) {

                    // field is the field name & ele is the field element
                    return '.mb-3';
                }
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            // Submit the form when all fields are valid
            // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            autoFocus: new FormValidation.plugins.AutoFocus()

        }
    });

})();
