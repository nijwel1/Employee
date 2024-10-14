@extends('layouts.app')
@section('title', '| Leave Type Trash')
@section('header', 'Leave Type Trash')
@section('content')
    @push('css')
    @endpush
    <div class="dd-content">

        <!-- Breadcrumb Start Here -->
        <section class="breadcrumb-section m-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="breadcrumb-wrapper">
                            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                                aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                                    <li class="breadcrumb-item " aria-current="page"><a
                                            href="{{ route('leave.type.index') }}">Leave Type</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Trash</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" id="deleteAllBtn" disabled class="btn btn-sm btn-danger me-2"> <i
                                    class="far fa-trash-alt"></i> All
                                Delete</button>
                            <a href="{{ route('leave.type.index') }}" class="btn btn-sm btn-base"><i
                                    class="fas fa-undo"></i>
                                Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb End Here -->

        <section class="employee-section mb-4">
            <div class="container-fluid">
                <!-- employee short info -->
                <div class="row gy-4 mb-4">
                    <div class="col-lg-12">

                        <table id="" class="table table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"> # </th>
                                    <th>Tile</th>
                                    <th>Is Paid</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($leaves as $key => $leave)
                                    <tr>
                                        <td width="5%">
                                            <form id="deleteAllForm" action="{{ route('leave.type.delete.all') }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="checkbox" name="id[]" value="{{ $leave->id }}">
                                                {{ $key + 1 }}
                                            </form>
                                        </td>
                                        <td>{{ $leave->title }}</td>
                                        <td width="15%">
                                            <span
                                                class="badge rounded-pill @if ($leave->paid_status == 'paid') text-bg-success @else text-bg-danger @endif ">{{ $leave->paid_status }}</span>
                                        </td>
                                        <td>{{ $leave->remarks }}</td>
                                        <td width="10%">
                                            <div class="d-flex gap-1">
                                                <form action="{{ route('leave.type.restore', $leave->id) }}" method="get">
                                                    <button type="submit" id="restoreBtn"
                                                        class="btn btn-outline-base btn-sm restoreBtn ">
                                                        <i class="fas fa-trash-restore"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('leave.type.forceDelete', $leave->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" id="delete"
                                                        class="btn btn-outline-danger btn-sm delete">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
    </div>
    </section>
    </div>
    @push('js')
        <script>
            $(document).ready(function() {
                const $deleteAllBtn = $('#deleteAllBtn');
                const $checkboxes = $('input[name="id[]"]');
                const $checkAll = $('#checkAll');

                // Function to update the delete button state
                function updateDeleteButtonState() {
                    $deleteAllBtn.prop('disabled', !$checkboxes.is(':checked'));
                }

                // Event listener for individual checkboxes
                $checkboxes.change(function() {
                    updateDeleteButtonState();
                });

                // Event listener for the "Check All" checkbox
                $checkAll.change(function() {
                    $checkboxes.prop('checked', this.checked);
                    updateDeleteButtonState();
                });

                // Initial state check
                updateDeleteButtonState();
            });

            $('body').on('click', '.delete', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });

            $('body').on('click', '#deleteAllBtn', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#deleteAllForm').submit();
                    }
                })
            });


            $('body').on('click', '#restoreBtn', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will restore the selected item.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, restore it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        </script>
    @endpush
@endsection
