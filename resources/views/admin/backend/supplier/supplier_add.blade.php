@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div style="direction: rtl" class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">إضافة شركة </h4><br><br>


                            <form id="myForm" method="post" action="{{ route('supplier.store') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">إسم الشركة</label>
                                    <div class="form-group col-sm-10">
                                        <input name="name" class="form-control" type="text">
                                    </div>
                                </div>



                                <input type="submit" class="btn btn-info waves-effect waves-light"
                                       value="إضافة">
                            </form>


                        </div>
                    </div>
                </div> <!-- end col -->
            </div>


        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    mobile_number: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please Enter Supplier Name',
                    },
                    mobile_number: {
                        required: 'Please Enter Supplier Number',
                    },
                    email: {
                        required: 'Please Enter Supplier Email',
                    },
                    address: {
                        required: 'Please Enter Supplier Address',
                    },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });

    </script>

@endsection
