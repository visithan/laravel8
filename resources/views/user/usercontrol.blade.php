@extends('layouts.masterlayout')
@section('title', 'User Management')
@section('content')
@push('css')
    <style>
        table tr td {
            vertical-align: middle !important;
        }

        table tr th {
            vertical-align: middle !important;
        }

    </style>
@endpush
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            //Column filtering
            $('#studenttbl thead tr').clone(true).appendTo('#studenttbl thead');
            //Add text box at table header
            $('#studenttbl thead tr:eq(1) th').each(function (i) {
                var title = $(this).text();
                if (title != "Created At" && title != "Updated At" && title != "Id" && title !=
                    "Actions") {
                    $(this).html('<input type="text" class="form-control" placeholder="Search ' +
                        title + '" />');
                } else {
                    $(this).html('');
                }
                // Apply the search
                $('input', this).on('keyup change', function () {
                    if (table.column(i).search() !== this.value) {
                        table.column(i).search(this.value).draw();
                    }
                });
            });

            var table = $('#studenttbl').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                orderCellsTop: true,
                fixedHeader: true,

                ajax: {
                    url: "{{ route('apiallusers') }}",
                    method: "post",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "api_token":"admin",
                    },
                    error: function (xhr, status, error) {
                        //console.log(xhr);
                        //console.log(error);
                    }
                },

                /*searchPanes: {
                show: true,
                viewTotal: true,
                columns: [1, 2, 3],
                },
                dom: 'Pfrtip',*/

                columnDefs: [{
                        className: 'text-center',
                        targets: [0, 4, 5, 6, -1]
                    },
                    {
                        orderable: false,
                        targets: [-1]
                    },
                    //{width: "20px", targets: [0, -1]},
                ],
                order: [
                    [0, "asc"]
                ], //Initial no order. //"order": [[ 1, "asc" ]],

                //searchBuilder: true,
                //dom: 'Qlfrtip',
                // initComplete: function() {
                //     // Apply the search
                //     this.api().columns().every(function() {
                //         var that = this;

                //         $('input', this.footer()).on('keyup change clear', function() {
                //             if (that.search() !== this.value) {
                //                 that.search(this.value).draw();
                //             }
                //         });
                //     });
                // }
            });

            //table.searchBuilder.container().prependTo(table.table().container());
            //table.searchPanes.container().prependTo(table.table().container());

            $(document).on('click', '.edituser', function () {
                var user_id = $(this).attr('id');
                //alert(user_id);
                $.ajax({
                    url: "{{ route('oneuser') }}",
                    method: "post",
                    data: {
                        "id": user_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: "Json",
                    success: function (data) {
                        //console.log(data);
                        $('#uid').val(data.id);
                        $('#fname').val(data.name);
                        $('#email').val(data.email);
                        $('#uname').val(data.user_name);
                        $("#editusermodel").modal("show");
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr);
                        console.log(error);
                    }
                });
            });

            /*$(document).on('click', '#edituserbtn', function () {
            alert('Yers0');
            });*/

            $("#edituserform").validate({
                //alert("vbnvbnvbn");
                rules: {
                    fname: "required",
                    uname: {
                        required: true,
                        minlength: 4
                    },
                    email: {
                        required: true,
                        email: true
                    },
                },
                messages: {
                    fname: "Please enter your full name",
                    uname: {
                        required: "Please enter a username",
                        minlength: "Your username must consist of at least 4 characters"
                    },
                    email: "Please enter a valid email address",
                },
                errorElement: "span",
                errorPlacement: function (error, element) {
                    error.addClass("invalid-feedback");
                    error.insertAfter($(element).parent(".input-group"));
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                success: function (label, element) {

                },
                submitHandler: function (form) {
                    $.ajax({
                        url: "{{ route('updateuser') }}",
                        method: "POST",
                        data: new FormData(form),
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $("#edituserform")[0].reset();
                            $("#editusermodel").modal("hide");
                            table.ajax.reload();
                            if (data['type'] === 'error') {
                                $('#notificationmsg').html(data['msg']);
                                $('#notification').removeClass('alert-success hide');
                                $('#notification').addClass('alert-danger show');
                                $("#notification").fadeTo(5000, 500).slideUp(500,
                                    function () {
                                        $("#notification").slideUp(1000);
                                    });
                            } else {
                                $('#notificationmsg').html(data['msg']);
                                $('#notification').removeClass('alert-danger  hide');
                                $('#notification').addClass('alert-success show');
                                $("#notification").fadeTo(5000, 500).slideUp(500,
                                    function () {
                                        $("#notification").slideUp(500);
                                    });
                                /*Swal.fire({
                                position: 'top-end',
                                icon: data['type'],
                                text: data['msg'],
                                showConfirmButton: false,
                                timer: 5000
                                })*/
                            }
                            //console.log(data);
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr);
                            console.log(error);
                        }
                    });
                }


            });

            $("#newuserform").validate({
                rules: {
                    nupass1: {
                        required: true,
                        minlength: 5
                    },
                    nupass2: {
                        required: true,
                        minlength: 5,
                        equalTo: "#nupass1"
                    },
                },
                messages: {
                    password1: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    confirm_password1: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long",
                        equalTo: "Please enter the same password as above"
                    },
                },
                errorElement: "span",
                errorPlacement: function (error, element) {
                    error.addClass("invalid-feedback");
                    error.insertAfter($(element).parent(".input-group"));
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                success: function (label, element) {

                },
                submitHandler: function (form) {
                    $.ajax({
                        url: "{{ route('adnewuser') }}",
                        method: "POST",
                        data: new FormData(form),
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $("#newuserform")[0].reset();
                            $("#newusermodel").modal("hide");
                            table.ajax.reload();
                            if (data['type'] === 'error') {
                                $('#notificationmsg').html(data['msg']);
                                $('#notification').removeClass('alert-success hide');
                                $('#notification').addClass('alert-danger show');
                                $("#notification").fadeTo(5000, 500).slideUp(500,
                                    function () {
                                        $("#notification").slideUp(1000);
                                    });
                            } else {
                                $('#notificationmsg').html(data['msg']);
                                $('#notification').removeClass('alert-danger  hide');
                                $('#notification').addClass('alert-success show');
                                $("#notification").fadeTo(5000, 500).slideUp(500,
                                    function () {
                                        $("#notification").slideUp(500);
                                    });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr);
                            console.log(error);
                        }
                    });
                }
            });



            $(document).on('click', '.changeactivestatus', function () {
                Swal.fire({
                    title: 'Do you want to change the status?',
                    text: "Are you sure?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var user_id = $(this).attr('id');
                        $.ajax({
                            url: "{{ route('changeuserstatus') }}",
                            method: "post",
                            data: {
                                "uid": user_id,
                                "_token": "{{ csrf_token() }}",
                            },
                            dataType: "Json",
                            success: function (data) {
                                Swal.fire(
                                    'Changed!',
                                    'User status has been changed',
                                    'success'
                                );
                                table.ajax.reload();

                            },
                            error: function (xhr, status, error) {
                                console.log(xhr);
                                console.log(error);
                            }
                        });

                    }
                })

            });

            $(document).on('click', '.deleteuser', function () {
                Swal.fire({
                    title: 'Do you want to delete the user?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var user_id = $(this).attr('id');
                        $.ajax({
                            url: "{{ route('deleteuser') }}",
                            method: "post",
                            data: {
                                "uid": user_id,
                                "_token": "{{ csrf_token() }}",
                            },
                            dataType: "Json",
                            success: function (data) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );
                                table.ajax.reload();
                            },
                            error: function (xhr, status, error) {
                                console.log(xhr);
                                console.log(error);
                            }
                        });

                    }
                })

            });

            $(document).on('click', '.passwordreset', function () {
                var user_id = $(this).attr('id');
                //alert(user_id);
                $.ajax({
                    url: "{{ route('oneuser') }}",
                    method: "post",
                    data: {
                        "id": user_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: "Json",
                    success: function (data) {
                        //console.log(data);
                        $('#pwrsuid').val(data.id);
                        $('#pwrsuname').val(data.user_name);
                        $("#pwordrsmodel").modal("show");
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr);
                        console.log(error);
                    }
                });
            });

            $("#pwordrsform").validate({
                rules: {
                    pwrspass1: {
                        required: true,
                        minlength: 5
                    },
                    pwrspass2: {
                        required: true,
                        minlength: 5,
                        equalTo: "#pwrspass1"
                    },
                },
                messages: {
                    password1: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    confirm_password1: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long",
                        equalTo: "Please enter the same password as above"
                    },
                },
                errorElement: "span",
                errorPlacement: function (error, element) {
                    error.addClass("invalid-feedback");
                    error.insertAfter($(element).parent(".input-group"));
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                success: function (label, element) {

                },
                submitHandler: function (form) {
                    $.ajax({
                        url: "{{ route('userpasswordreset') }}",
                        method: "POST",
                        data: new FormData(form),
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $("#pwordrsform")[0].reset();
                            $("#pwordrsmodel").modal("hide");
                            //table.ajax.reload();
                            if (data['type'] === 'error') {
                                $('#notificationmsg').html(data['msg']);
                                $('#notification').removeClass('alert-success hide');
                                $('#notification').addClass('alert-danger show');
                                $("#notification").fadeTo(5000, 500).slideUp(500,
                                    function () {
                                        $("#notification").slideUp(1000);
                                    });
                            } else {
                                $('#notificationmsg').html(data['msg']);
                                $('#notification').removeClass('alert-danger  hide');
                                $('#notification').addClass('alert-success show');
                                $("#notification").fadeTo(5000, 500).slideUp(500,
                                    function () {
                                        $("#notification").slideUp(500);
                                    });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr);
                            console.log(error);
                        }
                    });
                }
            });

            



            function successMsg($msg) {
                var m = ' <div class="alert alert-success alert-dismissible fade show" role="alert">';
                m += '<strong>Success! </strong> ' + $msg;
                m += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                m += '<span aria-hidden="true">&times;</span></button></div>';
                return m;
            }

            function failedMsg($msg) {
                var m = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                m += '<strong>Failed! </strong> ' + $msg;
                m += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                m += '<span aria-hidden="true">&times;</span></button></div>';
                return m;
            }


        });

    </script>
@endpush
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">User Control Pannel</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users Details</h3>
                        <button name="newuserbtn" id="newuserbtn" class="btn btn-group-lg btn-primary float-right"
                            data-toggle="modal" data-target="#newusermodel"> <i class="fas fa-user"></i> New
                            User</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="col-md-12 ">
                            <div class="col-12 mt-3 mb-3">
                                <div class="alert alert-dismissible fade" role="alert" id="notification">
                                    <span id="notificationmsg"></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>

                            <table id="studenttbl" class="table table-striped table-hover table-sm dt-responsive nowrap"
                                role="grid" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">Id</th>
                                        <th>Name</th>
                                        <th>User_Name</th>
                                        <th>E-Mail</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                        <hr class="">
                        {{-- <table class="table table-striped table-hover table-sm table-responsive-sm">
<thead>
<tr>
<th style="width: 50px; text-align: center">Id</th>
<th>Name</th>
<th>User_Name</th>
<th>E-Mail</th>
<th style="text-align: center">Status</th>
<th style="text-align: center">Created At</th>
<th style="text-align: center">Updated At</th>
<th style="text-align: center">Actions</th>
</tr>
</thead>
<tbody>
@foreach($users as $user)
<tr>
    <td class="text-center">{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->user_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">{{ $user->active_status }}</td>
                        <td class="text-center">{{ $user->created_at }}</td>
                        <td class="text-center">{{ $user->updated_at }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning" title="Edit" data-toggle="modal"
                                    data-target="#edituser"><i class="fas fa-user-edit"></i></button>
                                <button type="button" class="btn btn-info" title="Password Reset"
                                    data-toggle="tooltip"><i class="fas fa-key"></i></button>
                                <button type="button" class="btn btn-primary" title="Activate/Deactivate User"
                                    data-toggle="tooltip">
                                    @if($user->active_status == 1)
                                        <i class="fas fa-lock-open"></i>
                                    @else
                                        <i class="fas fa-lock"></i>
                                    @endif
                                </button>
                                <button type="button" class="btn btn-danger" title="Delete" data-toggle="tooltip"><i
                                        class="fas fa-trash-alt"></i></button>
                            </div>
                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                        <div class="mt-4 pagination justify-content-center">
                            {{ $users->links('pagination::bootstrap-4') }}

                        </div> --}}

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Edit User modal-dialog -->
<div class="modal fade show" id="editusermodel" style="display: none; padding-right: 17px;" aria-modal="true">
    <div class="modal-dialog" style="width: 500px">
        <div class="modal-content">
            <form method="post" name="edituserform" id="edituserform" class="" onsubmit="return false">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="uid" name="uid" value="">
                    <div class="input-group mb-3">
                        <label for="fname">Full Name: </label>
                        <div class="input-group">
                            <input type="text" id="fname" name="fname" class="form-control" placeholder="Full name"
                                value="" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="email">Email address: </label>
                        <div class="input-group">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                                value="" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <label for="uname">User Name: </label>
                        <div class="input-group">
                            <input type="text" id="uname" name="uname" class="form-control" placeholder="User name"
                                value="" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="edituserbtn">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<!-- /.modal-dialog -->

<!-- New User modal-dialog -->
<div class="modal fade show" id="newusermodel" style="display: none; padding-right: 17px;" aria-modal="true">
    <div class="modal-dialog" style="width: 500px">
        <div class="modal-content">
            <form method="post" name="newuserform" id="newuserform" class="" onsubmit="return false">
                <div class="modal-header">
                    <h4 class="modal-title">New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="nufname" class="form-control" placeholder="First name" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="nulname" class="form-control" placeholder="Last name" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="nuemail" class="form-control" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="nuuname" class="form-control" placeholder="User name" required
                            minlength="4" maxlength="10">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="nupass1" id="nupass1" class="form-control" placeholder="Password"
                            required minlength="4" maxlength="12">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="nupass2" class="form-control" placeholder="Retype password"
                            required minlength="4" maxlength="12">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="nuuserbtn">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<!-- /.modal-dialog -->

<!-- Password reset modal-dialog -->
<div class="modal fade show" id="pwordrsmodel" style="display: none; padding-right: 17px;" aria-modal="true">
    <div class="modal-dialog" style="width: 500px">
        <div class="modal-content">
            <form method="post" name="pwordrsform" id="pwordrsform" class="" onsubmit="return false">
                <div class="modal-header">
                    <h4 class="modal-title">Password Reset</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="pwrsuid" name="pwrsuid" value="">
                    
                    <div class="input-group mb-3">
                        <input type="text" name="pwrsuname" id="pwrsuname" class="form-control" placeholder="User name" readonly
                            minlength="4" maxlength="10">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="pwrspass1" id="pwrspass1" class="form-control" placeholder="New Password"
                            required minlength="4" maxlength="12">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="pwrspass2" id="pwrspass2" class="form-control" placeholder="Confirm password"
                            required minlength="4" maxlength="12">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="nuuserbtn">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<!-- /.modal-dialog -->


@endsection
