@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div style="direction: rtl" class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">إضافة صنف جديد </h4><br><br>


                            <form id="myForm" method="post" action="{{ route('product.store') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">إسم الصنف</label>
                                    <div class="form-group col-sm-10">
                                        <input name="name" class="form-control" type="text">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">الشركة</label>
                                    <div class="form-group col-sm-10">
                                        <select name="supplier_id" class="form-select"
                                                aria-label="Default select example">
                                            <option selected="">اختر شركة</option>
                                            @foreach($suppliers as $key => $item)
                                                <option value="{{ $item->id}}">{{ $item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"> النوع</label>
                                    <div class="form-group col-sm-10">
                                        <select name="category_id" class="form-select"
                                                aria-label="Default select example">
                                            <option selected="">إختر النوع</option>
                                            @foreach($categories as $key => $item)
                                                <option value="{{ $item->id}}">{{ $item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">الوحدة</label>
                                    <div class="form-group col-sm-10">
                                        <select name="unit_id" class="form-select" aria-label="Default select example">
                                            <option selected="">إختر الوحدة</option>
                                            @foreach($units as $key => $item)
                                                <option value="{{ $item->id}}">{{ $item->name}}</option>
                                            @endforeach
                                        </select>
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
                    supplier_id: {
                        required: true,
                    },
                    unit_id: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please Enter Product Name',
                    },
                    supplier_id: {
                        required: 'Please Select Supplier Name',
                    },
                    unit_id: {
                        required: 'Please Select Unit',
                    },
                    category_id: {
                        required: 'Please Select Category',
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
