@extends('layouts.main.main')

@section('container')
    <h4 class="py-3 breadcrumb-wrapper mb-2">SubMenu Navigation's Setting</h4>

    <p>
        A role provided access to predefined menus and features so that depending on <br />
        assigned role an administrator can have access to what user needs.
    </p>

    <!-- Role cards -->
    <div class="row g-4">
        <div class="col-6">
            <!-- Role Table -->
            <div class="card">
                <div class="text-center mt-4">
                    <h3>Upload Lines MAP</h3>
                    <p>Modify the selected menu and sub-menu details.</p>
                </div>
                <button type="button" id="confirm-color-2" class="btn btn-outline-primary m-5" data-bs-toggle="modal"
                    data-bs-target="#editPermissionModal">
                    <span class="tf-icons bx bx-trip me-1"></span>Lines Upload
                </button>
            </div>
        </div>
        <div class="col-6">
            <!-- Role Table -->
            <div class="card">
                <div class="text-center mt-4">
                    <h3>Upload Points MAP</h3>
                    <p>Modify the selected menu and sub-menu details.</p>
                </div>
                <button type="button" id="confirm-color-2" class="btn btn-outline-primary m-5" data-bs-toggle="modal"
                    data-bs-target="#editPermissionModal">
                    <span class="tf-icons bx bx-map-pin me-1"></span>Points Upload
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3>Edit Menu</h3>
                        <p>Modify the selected menu and sub-menu details.</p>
                    </div>
                    <!-- Basic  -->
                    <div class="col-12">
                        <div class="card mb-4">

                            <form action="{{ route('points.import') }}" method="POST" enctype="multipart/form-data" class="dropzone needsclick" id="dropzone-basic">
                                <div class="dz-message needsclick">
                                    Drop files here or click to upload
                                    <span class="note needsclick">(This is just a demo dropzone. Selected files are
                                        <span class="fw-medium">not</span> actually uploaded.)</span>
                                </div>
                                <div class="fallback">
                                    <input name="file" type="file" required />
                                </div>
                                <button type="button" class="btn btn-outline-primary m-5">
                                    <span class="tf-icons bx bx-cloud-upload me-1"></span>Upload File
                                </button>
                                
                            </form>

                        </div>
                    </div>
                    <!-- /Basic  -->

                </div>
            </div>
        </div>
    </div>
    <!-- / Add Role Modal -->
@endsection
