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
        console.log(usersData)
        var dt_user = dt_user_table.DataTable({
            data: usersData, // JSON file to add data
            columns: [
                // columns according to JSON
                { data: '' },
                { data: 'vpn_name' },
                { data: 'ip_address' },
                { data: 'username' },
                { data: 'password' },
                { data: 'protocol' },
                { data: 'description' },
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
                        var $name = full['vpn_name'];
                        // Creates full output for row
                        var $row_output = '<div class="d-flex justify-content-start align-items-center user-name">' +
                            '<div class="d-flex flex-column">' +
                            '<a class="text-body text-truncate">' +
                            '<span class="fw-medium">' + $name + '</span></a></div></div>';
                        return $row_output;
                    }
                },
                {
                    // Plans
                    targets: 2,
                    render: function (data, type, full, meta) {
                        var $plan = full['ip_address'];

                        return '<span class="fw-medium">' + $plan + '</span>';
                    }
                },
                {
                    // Plans
                    targets: 3,
                    render: function (data, type, full, meta) {
                        var $plan = full['username'];

                        return '<span class="fw-medium">' + $plan + '</span>';
                    }
                },
                {
                    // Plans
                    targets: 4,
                    render: function (data, type, full, meta) {
                        var $plan = full['password'];

                        return '<span class="fw-medium">' + $plan + '</span>';
                    }
                },
                {
                    // Plans
                    targets: 5,
                    render: function (data, type, full, meta) {
                        var $plan = full['protocol'];

                        return '<span class="fw-medium">' + $plan + '</span>';
                    }
                },
                {
                    // Plans
                    targets: 6,
                    render: function (data, type, full, meta) {
                        var $plan = full['description'];

                        return '<span class="fw-medium">' + $plan + '</span>';
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
                            return 'Details of ' + data['vpn_name'];
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
        // console.log(res.delegateTarget.getAttribute('id'))
        if (res.delegateTarget.getAttribute('id') === 'editNewUserForm') {
            var form = document.getElementById('editNewUserForm');
            var formData = new FormData(form);
            var actionUrl = form.getAttribute('action'); // Mengambil action URL dari form
            console.log(actionUrl)
        }

        if (res.delegateTarget.getAttribute('id') === 'addNewUserForm') {
            var form = document.getElementById('addNewUserForm');
            var actionUrl = form.getAttribute('action'); // Mengambil action URL dari form
            var formData = new FormData(form);
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            console.log(actionUrl)
        }


        // $.ajax({
        //     url: actionUrl,
        //     type: 'POST',
        //     data: formData,
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     processData: false,
        //     contentType: false,
        //     success: function (response) {
        //         console.log(response);
        //         if (response.status === 'success') {
        //             Swal.fire({
        //                 title: 'Success!',
        //                 text: response.message,
        //                 icon: 'success',
        //                 confirmButtonText: 'OK',
        //                 customClass: {
        //                     confirmButton: 'btn btn-success'
        //                 }
        //             }).then(function () {
        //                 window.location.href = '/members';
        //             });
        //         } else {
        //             Swal.fire({
        //                 title: 'Error!',
        //                 text: 'Please correct the highlighted fields.',
        //                 icon: 'error',
        //                 customClass: {
        //                     confirmButton: 'btn btn-primary'
        //                 },
        //                 buttonsStyling: false
        //             });
        //         }
        //     },
        //     error: function (xhr) {
        //         console.log(xhr.responseText); // Lihat detail error
        //         let errors = xhr.responseJSON ? xhr.responseJSON.errors : null;

        //         if (errors) {
        //             // Loop melalui error dan tampilkan ke pengguna
        //             $.each(errors, function (key, value) {
        //                 console.log('Error pada ' + key + ': ' + value);
        //             });
        //             Swal.fire({
        //                 title: 'Error!',
        //                 text: 'Please correct the highlighted fields.',
        //                 icon: 'error',
        //                 customClass: {
        //                     confirmButton: 'btn btn-primary'
        //                 },
        //                 buttonsStyling: false
        //             });
        //         }


        //     }
        // });
    });
    // Delete Record
    // Delete Record
    $(document).on('click', '.delete-record', function () {
        // $('.datatables-users tbody').on('click', '.delete-record', function () {
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
                try {
                    var modalElement = document.querySelector('.modal'); // Pilih modal berdasarkan class
                    if (modalElement) { // Pastikan modalElement ditemukan
                        var modal = bootstrap.Modal.getInstance(modalElement); // Ambil instance modal
                        if (modal) { // Pastikan modal instance ada
                            modal.hide(); // Tutup modal
                        }
                    }
                } catch (error) {
                    console.error('Error closing modal:', error); // Log error jika terjadi kesalahan
                }
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
    // $('.datatables-users tbody').on('click', '.edit-button', function () {
    $(document).on('click', '.edit-button', function () {
        // Get the user data from the data-user attribute
        try {
            var modalElement = document.querySelector('.modal'); // Pilih modal berdasarkan class
            if (modalElement) { // Pastikan modalElement ditemukan
                var modal = bootstrap.Modal.getInstance(modalElement); // Ambil instance modal
                if (modal) { // Pastikan modal instance ada
                    modal.hide(); // Tutup modal
                }
            }
        } catch (error) {
            console.error('Error closing modal:', error); // Log error jika terjadi kesalahan
        }
        var user = $(this).data('user');

        // Populate the form fields with the data from the user object
        $('#edit_vpn_name').val(user.vpn_name);
        $('#edit_ip_address').val(user.ip_address);
        $('#edit_username').val(user.username);
        $('#edit_password').val(user.password);
        $('#edit_add-user-role').val(user.role);
        // Show the offcanvas (Bootstrap 5)
        var offcanvasElement = document.getElementById('offcanvaseditUser');
        var offcanvas = new bootstrap.Offcanvas(offcanvasElement);
        offcanvas.show();
        // $('#editNewUserForm').modal('show');
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
