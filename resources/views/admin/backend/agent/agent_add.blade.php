@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Product Page </h4><br><br>

                            <div class="row">


                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class=" form-label">Supplier Name
                                        </label>
                                        <select id="supplier_id" name="supplier_id" class="form-select"
                                                aria-label="Default select example">
                                            <option selected="">Open this select menu</option>
                                            @foreach($suppliers as $key => $item)
                                                <option value="{{ $item->id}}">{{ $item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class=" form-label">Category Name
                                        </label>
                                        <select name="category_id" class="form-select" id="category_id"
                                                aria-label="Default select example">
                                            <option selected="">Open this select menu</option>
                                            {{--  @foreach($categories as $key => $item)
                                                  <option value="{{ $item->id}}">{{ $item->name}}</option>
                                              @endforeach--}}
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class=" form-label">Product Name
                                        </label>
                                        <select name="product_id" class="form-select" id="product_id"
                                                aria-label="Default select example">
                                            <option selected="">Open this select menu</option>
                                            {{--  @foreach($categories as $key => $item)
                                                  <option value="{{ $item->id}}">{{ $item->name}}</option>
                                              @endforeach--}}
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class=" form-label">Unit Name
                                        </label>
                                        <select name="unit_id" class="form-select" id="unit_id"
                                                aria-label="Default select example">
                                            <option selected="">Open this select menu</option>
                                            @foreach($units as $key => $item)
                                                <option value="{{ $item->id}}">{{ $item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class=" form-label">Amount
                                        </label>
                                        <input name="amount" class="form-control example-text-input"
                                               type="number" id="amount">
                                    </div>

                                </div>


                                <div class="col-md-4">
                                    <div style="margin-top: 8%" class="md-3">
                                        <label class=" form-label">
                                        </label>

                                        <i id="addeventmore"
                                           class="btn btn-secondary btn-rounded waves-effect waves-light fas fa-plus-circle addeventmore">Add
                                            More</i>
                                    </div>

                                </div>


                            </div>
                        </div>
                        <div class="card-body">

                            <form method="Post" action="{{route('cart.store')}}">
                                @csrf

                                <input placeholder="Customer Name" style="margin-bottom: 20px" name="customer_name"
                                       type="text" class="form-control" value="" id="customer_name">

                                <table class="table-sm table-bordered" width="100%" style="border-color: #ddd">

                                    <thead>
                                    <tr>
                                        <th>Company</th>
                                        <th>Type</th>
                                        <th>Unit</th>
                                        <th>Product Name</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody class="addRow" id="addRow">

                                    </tbody>


                                </table>
                                <br><br>

                                <div class="form-control">
                                    <button type="submit" class="btn btn-info" id="storeButton">Purchase Store</button>
                                </div>
                            </form>
                        </div>

                    </div> <!-- end col -->
                </div>


            </div>
        </div>

        <script id="document-template" type="text/x-handlebars-template">
            <tr class="delete_add_more_item" id="delete_add_more_item">


                <td>
                    <input type="hidden" name="supplier_id[]" value="@{{ supplier_id }}"/>
                    @{{ supplier_name }}
                </td>
                <td>
                    <input type="hidden" name="category_id[]" value="@{{ category_id }}"/>
                    @{{ category_name }}
                </td>

                <td>
                    <input type="hidden" name="product_id[]" value="@{{ product_id }}"/>
                    @{{ product_name }}
                </td>

                <td>
                    <input type="hidden" name="unit_id[]" value="@{{ unit_id }}"/>
                    @{{ unit_name }}
                </td>


                <td>
                    <input type="hidden" name="amount[]" value="@{{ amount }}"/>
                    @{{ amount }}
                </td>


                <td>
                    <i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"/>
                </td>

            </tr>

        </script>


        <script type="text/javascript">
            $(document).ready(function () {
                $(document).on("click", ".addeventmore", function () {
                    console.log("Hello Bro");
                    var date = $('date').val();
                    var amount = $('#amount').val();
                    var supplier_id = $('#supplier_id').val();
                    var category_name = $('#category_id').find('option:selected').text();
                    var category_id = $('#category_id').val();
                    var product_id = $('#product_id').val();
                    var product_name = $('#product_id').find('option:selected').text();
                    var supplier_name = $('#supplier_id').find('option:selected').text();
                    var unit_name = $('#unit_id').find('option:selected').text();
                    var unit_id = $('#unit_id').val();
                    var customer_name = $('#customer_name').val();


                    if (date == '') {
                        $.notify("Date is Required", {globalPosition: 'top right', className: 'error'});
                        return false;
                    }

                    if (amount == '') {
                        $.notify("Purchase is Required", {globalPosition: 'top right', className: 'error'});
                        return false;
                    }

                    if (supplier_id == '') {
                        $.notify("supplier_id is Required", {globalPosition: 'top right', className: 'error'});
                        return false;
                    }

                    if (category_name == '') {
                        $.notify("category_name is Required", {globalPosition: 'top right', className: 'error'});
                        return false;
                    }

                    if (category_id == '') {
                        $.notify("category_id is Required", {globalPosition: 'top right', className: 'error'});
                        return false;
                    }

                    if (product_id == '') {
                        $.notify("product_id is Required", {globalPosition: 'top right', className: 'error'});
                        return false;
                    }

                    if (product_name == '') {
                        $.notify("product_name is Required", {globalPosition: 'top right', className: 'error'});
                        return false;
                    }

                    var source = $("#document-template").html();
                    var template = Handlebars.compile(source);
                    var data = {
                        'date': date,
                        'supplier_id': supplier_id,
                        'category_name': category_name,
                        'category_id': category_id,
                        'product_id': product_id,
                        'product_name': product_name,
                        'supplier_name': supplier_name,
                        'amount': amount,
                        'unit_id': unit_id,
                        'unit_name': unit_name,
                        'customer_name': customer_name,
                    };
                    var html = template(data);
                    $("#addRow").append(html);
                });

                $(document).on("click", ".removeeventmore", function () {
                    $(this).closest(".delete_add_more_item").remove();
                });


            });
        </script>
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

        <script type="text/javascript">
            $(function () {
                console.log("Hu=i Moha");
                $(document).on('change', '#supplier_id', function () {
                    console.log("Hui Changed");

                    var supplier_id = $(this).val();
                    $.ajax({
                        url: "{{route('get-category')}}",
                        type: "GET",
                        data: {'supplier_id': supplier_id},
                        success: function (data) {
                            var html = '<option value="">Select Category</option>';
                            $.each(data, function (key, v) {
                                //  html += <option value="1">'+v.category.name+'</option>
                                html += '<option value="' + v.category_id + '">' + v.category.name + '</option>';
                                ``
                                console.log(v.category.name);
                            });
                            $('#category_id').html(html);
                        }
                    })
                })
            });
        </script>
        <script type="text/javascript">
            $(function () {
                console.log("Hu=i Moha");
                $(document).on('change', '#category_id', function () {
                    console.log("Hui Changed");

                    var category_id = $(this).val();
                    $.ajax({
                        url: "{{route('get-products')}}",
                        type: "GET",
                        data: {'category_id': category_id},
                        success: function (data) {
                            var html = '<option value="">Select Product</option>';
                            $.each(data, function (key, v) {
                                //  html += <option value="1">'+v.category.name+'</option>
                                html += '<option value="' + v.id + '">' + v.name + '</option>';
                                ``
                                console.log(v.name);

                            });
                            $('#product_id').html(html);
                        }
                    })
                })
            });
        </script>

@endsection
