<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="../resource/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Container - Layouts | Frest - Bootstrap Admin Template</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../resource/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <!-- Icons -->
    <link rel="stylesheet" href="../resource/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../resource/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../resource/assets/vendor/css/rtl/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../resource/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../resource/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/libs/fullcalendar/fullcalendar.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/libs/quill/editor.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />

    <!-- Import From File -->
    @yield('page-up')
    {{-- @yield('page-style') --}}
    {{-- <link rel="stylesheet" href="../resource/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/fonts/flag-icons.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/libs/select2/select2.css" />


    <!-- Core CSS -->
    <link rel="stylesheet" href="../resource/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../resource/assets/vendor/css/rtl/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../resource/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../resource/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/libs/tagify/tagify.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/libs/dropzone/dropzone.css" />

    
    <!-- Page CSS -->
    <link rel="stylesheet" href="../resource/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/css/pages/page-pricing.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/css/pages/app-calendar.css" /> --}}
    {{-- <link rel="stylesheet" href="../resource/assets/vendor/libs/fullcalendar/fullcalendar.css" /> --}}
    {{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <link rel="stylesheet" href="../resource/assets/vendor/libs/flatpickr/flatpickr.css" /> --}}

    <!-- Page MAP -->
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/@turf/turf/turf.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}



    <!-- Helpers -->
    <script src="../resource/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="../resource/assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../resource/assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="/home" class="app-brand-link">
                        <span class="app-brand-text demo menu-text fw-bold ms-2">Miracle Data Technology</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
                        <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
                    </a>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var brandText = document.querySelector('.app-brand-text');
                        var fullText = brandText.textContent.trim();

                        var words = fullText.split(' ');

                        if (words.length > 20) {
                            brandText.textContent = words.slice(0, 2).join(' ');
                        } else if (words.length > 2) {
                            brandText.textContent = words.slice(0, 2).join(' ');
                        } else if (words.length > 1) {
                            brandText.textContent = words.slice(0, 2).join(' ');
                        } else {
                            brandText.textContent = words[0];
                        }
                    });
                </script>
                <div class="menu-divider mt-0"></div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1" style="font-size: 0.75rem;">
                    @include('layouts.main.menu')
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="container-xxl">
                        @include('layouts.main.navbar')
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    {{-- <div class="m-5 flex-grow-1 container-p-y"> --}}
                        @yield('container')
                        <!--/ Layout Demo -->
                    {{-- </div> --}}
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme mb-3">
                        @include('layouts.main.footer')
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="../resource/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../resource/assets/vendor/libs/popper/popper.js"></script>
    <script src="../resource/assets/vendor/js/bootstrap.js"></script>
    <script src="../resource/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../resource/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../resource/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../resource/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../resource/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../resource/assets/vendor/libs/fullcalendar/fullcalendar.js"></script>
    <script src="../resource/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="../resource/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="../resource/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="../resource/assets/vendor/libs/select2/select2.js"></script>
    <script src="../resource/assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="../resource/assets/vendor/libs/moment/moment.js"></script>

    <!-- Main JS -->
    <script src="../resource/assets/js/main.js"></script>
    
    <!--Import From File Down -->
    @yield('page-down')
    {{-- @yield('page-script') --}}
    {{-- <script src="../resource/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../resource/assets/vendor/libs/popper/popper.js"></script>
    <script src="../resource/assets/vendor/js/bootstrap.js"></script>
    <script src="../resource/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../resource/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../resource/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../resource/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../resource/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    
    <script src="../resource/assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="../resource/assets/vendor/libs/dropzone/dropzone.js"></script>
    <script src="../resource/assets/vendor/libs/sweetalert2/sweetalert2.js"></script> --}}


    {{-- <!-- Main JS -->
    <script src="../resource/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../resource/assets/js/dashboards-analytics.js"></script>
    <script src="../resource/assets/js/extended-ui-sweetalert2.js"></script>

    <!-- Page JS Online -->

    <!-- Kemudian muat Bootstrap JS dan skrip lainnya -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/1.3.0/typeahead.bundle.min.js"></script>
    <!-- Select2 -->


    <!-- Page JS -->
    <script src="../resource/assets/vendor/libs/select2/select2.js"></script>
    <script src="../resource/assets/js/forms-selects.js"></script>
    <script src="../resource/assets/js/forms-typeahead.js"></script>
    <script src="../resource/assets/js/forms-file-upload.js"></script> --}}
    {{-- <script src="../resource/assets/js/pages-pricing.js"></script> --}}


</body>

</html>
