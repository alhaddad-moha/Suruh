@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">تعديل نوع </h4><br><br>


                            <form id="myForm" method="post" action="{{ route('category.update') }}">

                                @csrf

                                <input name="id"  type="hidden" value="{{$category->id}}">

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">اسم النوع
                                        </label>
                                    <div class="form-group col-sm-10">
                                        <input name="name" class="form-control" type="text" value="{{$category->name}}">
                                    </div>
                                </div>


                                <input type="submit" class="btn btn-info waves-effect waves-light"
                                       value="تعديل">
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
                    customer_image: {
                        required: false,
                    },
                },
                messages: {
                    name: {
                        required: 'Please Enter Customer Name',
                    },
                    mobile_number: {
                        required: 'Please Enter Customer Number',
                    },
                    email: {
                        required: 'Please Enter Customer Email',
                    },
                    address: {
                        required: 'Please Enter Customer Address',
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

    <script type="text/javascript">

        $(document).ready(function () {
            $('#image').change(function (e) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });

    </script>


@endsection
