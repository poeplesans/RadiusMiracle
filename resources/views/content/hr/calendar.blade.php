@extends('layouts.main.main')

@section('page-up')
    <!-- Icons -->
    <link rel="stylesheet" href="../resource/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="../resource/assets/vendor/css/pages/app-calendar.css" />
@endsection

<!-- Vendors JS -->
@section('page-down')
    <!-- Page JS -->
    <script>
        var usersData = @json($eventData);
    </script>
    {{-- <script src="../resource/assets/js/app-calendar-events.js"></script> --}}
    <script src="../resource/modif/hrcalendar.js"></script>
    <script src="../resource/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="../resource/assets/js/extended-ui-sweetalert2.js"></script>
@endsection

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card app-calendar-wrapper">
            <div class="row g-0">
                <!-- Calendar Sidebar -->
                <div class="col app-calendar-sidebar" id="app-calendar-sidebar">
                    <div class="border-bottom p-4 my-sm-0 mb-3">
                        <div class="d-grid">
                            <button class="btn btn-primary btn-toggle-sidebar" data-bs-toggle="offcanvas">
                                <i class="bx bx-plus me-1"></i>
                                <span class="align-middle">Add Event</span>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <!-- inline calendar (flatpicker) -->
                        <div class="ms-n2">
                            <div class="inline-calendar"></div>
                        </div>

                        <hr class="container-m-nx my-4">

                        <!-- Filter -->
                        <div class="mb-4">
                            <small class="text-small text-muted text-uppercase align-middle">Filter</small>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input select-all" type="checkbox" id="selectAll" data-value="all"
                                checked>
                            <label class="form-check-label" for="selectAll">View All</label>
                        </div>

                        <div class="app-calendar-events-filter">
                            <div class="form-check form-check-success mb-2">
                                <input class="form-check-input input-filter" type="checkbox" id="select-personal"
                                    data-value="prs" checked>
                                <label class="form-check-label" for="select-personal">Present [ OnTime ]</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input input-filter" type="checkbox" id="select-business"
                                    data-value="wh" checked>
                                <label class="form-check-label" for="select-business">Holiday [ Kerja di Hari
                                    Libur ]</label>
                            </div>
                            <div class="form-check form-check-danger mb-2">
                                <input class="form-check-input input-filter" type="checkbox" id="select-family"
                                    data-value="abs" checked>
                                <label class="form-check-label" for="select-family">Absent [ Tidak Hadir ]</label>
                            </div>
                            <div class="form-check form-check-warning mb-2">
                                <input class="form-check-input input-filter" type="checkbox" id="select-holiday"
                                    data-value="lt" checked>
                                <label class="form-check-label" for="select-holiday">Late [ Terlambat ]</label>
                            </div>
                            <div class="form-check form-check-info">
                                <input class="form-check-input input-filter" type="checkbox" id="select-etc" data-value="fd"
                                    checked>
                                <label class="form-check-label" for="select-etc">Full Day [ Izin ]</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Calendar Sidebar -->

                <!-- Calendar & Modal -->
                <div class="col app-calendar-content">
                    <div class="card shadow-none border-0">
                        <div class="card-body pb-0">
                            <!-- FullCalendar -->
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <div class="app-overlay"></div>
                    <!-- FullCalendar Offcanvas -->
                    <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar"
                        aria-labelledby="addEventSidebarLabel">
                        <div class="offcanvas-header border-bottom">
                            <h6 class="offcanvas-title" id="addEventSidebarLabel">Add Event</h6>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <form class="event-form pt-0" id="eventForm" onsubmit="return false">
                                <div class="mb-3">
                                    <label class="form-label" for="eventTitle">Employe Name</label>
                                    <input type="text" class="form-control" id="eventTitle" name="eventTitle"
                                        placeholder="Event Title" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="eventLabel">Absent</label>
                                    <select class="select2 select-event-label form-select" id="eventLabel"
                                        name="eventLabel">
                                        <option data-label="primary" value="wh" selected>Holiday</option>
                                        <option data-label="danger" value="abs">Absent</option>
                                        <option data-label="warning" value="lt">Late</option>
                                        <option data-label="success" value="prs">Present</option>
                                        <option data-label="info" value="fd">Izin</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="eventStartDate">Check In</label>
                                    <input type="text" class="form-control" id="eventStartDate" name="eventStartDate"
                                        placeholder="Start Date" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="eventEndDate">Check Out</label>
                                    <input type="text" class="form-control" id="eventEndDate" name="eventEndDate"
                                        placeholder="End Date" />
                                </div>
                                <div class="mb-3">
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input allDay-switch" />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                        <span class="switch-label">All Day</span>
                                    </label>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="eventDescription">Description</label>
                                    <textarea class="form-control" name="eventDescription" id="eventDescription"></textarea>
                                </div>
                                <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
                                    <div>
                                        <button type="submit"
                                            class="btn btn-primary btn-add-event me-sm-3 me-1">Add</button>
                                        <button type="reset" class="btn btn-label-secondary btn-cancel me-sm-0 me-1"
                                            data-bs-dismiss="offcanvas">Cancel</button>
                                    </div>
                                    <div><button class="btn btn-label-danger btn-delete-event d-none">Delete</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Calendar & Modal -->
            </div>
        </div>
    </div>
@endsection
