<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8"/>
    <title>Dashboard | Moha - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesdesign" name="author"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Cairo:wght@500&family=Tajawal&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amiri&display=swap" rel="stylesheet"></link>
    <link href="https://fonts.googleapis.com/css?family=Cairo:wght@500;600&family=Tajawal&display=swap"
          rel="stylesheet"></link>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <!-- jquery.vectormap css -->
    <link href="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
          rel="stylesheet" type="text/css"/>

    <!-- DataTables -->
    <link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>

    <!-- Responsive datatable examples -->
    <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>

    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
          type="text/css"/>
    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <script data-require="jquery@*" data-semver="3.0.0"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
    <link rel="stylesheet" type="text/css"
          href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css"/>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>


    <style>
        body {

            font-family: "Cairo", sans-serif;
        }
    </style>
</head>

<body data-topbar="dark">

<!-- <body data-layout="horizontal" data-topbar="dark"> -->

<!-- Begin page -->
<div id="layout-wrapper">


    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Invoice</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">سند إستلام</a></li>
                                <li class="breadcrumb-item active">المستند</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    <div class="invoice-title">
                                        <h4 class="float-end font-size-16"><strong>رقم المرجع
                                                # {{$order->id}}</strong></h4>
                                        <h3>
                                            <img src="{{ asset('backend/assets/images/logo-light.png')}}" alt="logo"
                                                 height="24"/> صروح الخليج
                                        </h3>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6">
                                            <address>
                                                {{ date("F j, Y",strtotime($order->order_date)).":"}}
                                                <strong>التاريخ</strong>
                                            </address>
                                        </div>

                                        <div style="direction: rtl" class="col-6 text-end">
                                            <address>
                                                <strong>التسليم الى الأخ:</strong>
                                                {{$order->customer->name}}
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div  class=" invisible col-6">
                                            <address>
                                                {{ date("F j, Y",strtotime($order->order_date)).":"}}
                                                <strong>التاريخ</strong>
                                            </address>
                                        </div>
                                        <div style="direction: rtl" class="col-6 text-end">
                                            <address>
                                                <strong>رقم الهاتف:</strong>
                                                <?php
                                                $country_code = "+967";
                                                $phone = $order->customer->mobile_number;
                                                $phone = preg_replace("/^\+?{$country_code}/", '', $phone);
                                                $country_code = "+966";
                                                $phone = preg_replace("/^\+?{$country_code}/", '', $phone);
                                                ?>
                                                {{$phone}}
                                            </address>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div style="direction: rtl" class="row">
                                <div class="col-12">
                                    <div>
                                        <div class="p-2">
                                            <h3 class="font-size-16"><strong>تفاصيل الطلب</strong></h3>
                                        </div>
                                        <div class="">
                                            <div style="direction: rtl" class="table-responsive">

                                                <table style="direction: rtl" class="table table-responsive ">
                                                    <thead>
                                                    <tr>
                                                        <td class="text-center"><strong>الرقم</strong>
                                                        <td class="text-center"><strong>الوصف</strong>
                                                        <td class="text-center"><strong>الاسم</strong>
                                                        <td class="text-center"><strong>الشركة</strong>
                                                        <td class="text-center"><strong>الكمية</strong>
                                                        <td class="text-center"><strong>النوع</strong>
                                                        </td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->

                                                    @foreach($carts as $key => $item)
                                                        <tr>
                                                            @foreach($suppliers as $supplier)
                                                                @if($supplier->id==$item->product->supplier_id)
                                                                        <?php $supplierName = $supplier->name ?>
                                                                @endif
                                                            @endforeach

                                                            @foreach($units as $unit)
                                                                @if($unit->id==$item->product->unit_id)
                                                                        <?php $unitName = $unit->name ?>
                                                                @endif
                                                            @endforeach

                                                            @foreach($categories as $category)
                                                                @if($category->id==$item->product->category_id)
                                                                        <?php $categoryName = $category->name ?>
                                                                @endif
                                                            @endforeach
                                                            <td class="text-center">{{ $key+1 }}</td>
                                                            <td class="text-center"> {{   $categoryName." ". $supplierName." ".$item->product->name }} </td>
                                                            <td class="text-center"> {{ $item->product->name }} </td>
                                                            <td class="text-center"> {{ $supplierName }} </td>
                                                            <td class="text-center"> {{ $item->quantity ." ".$unitName }} </td>
                                                            <td class="text-center"> {{$categoryName}} </td>
                                                        </tr>

                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="d-print-none">
                                                <div class="float-start">
                                                    <a href="javascript:window.print()"
                                                       class="btn btn-success waves-effect waves-light"><i
                                                            class="fa fa-print"></i></a>
                                                </div>
                                                <div class="float-end">

                                                    <div class="form-check form-check-right">
                                                        <input class="form-check-input" type="radio"
                                                               name="formRadiosRight" id="formRadiosRight2">
                                                        <label class="form-check-label" for="formRadiosRight2">

                                                            انا {{" ".$order->customer->name." "}}قد إستلمت البضاعة
                                                            كاملة
                                                            من المندوب علوي الحداد </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <form action="{{route('customer.verify',['id'=> $order->customer_id])}}"
                                                  method="Post">
                                                @csrf
                                                <input type="hidden" id="order_id" value="{{$order->id}}"
                                                       name="order_id">

                                                <input placeholder="ملاحظات" style="margin-bottom: 20px; width:70%"
                                                       name="notes"
                                                       type="" class="form-control" value="" id="notes">

                                                <button type="submit" class="btn btn-info" id="storeButton">تأكيد
                                                    الإستلام
                                                </button>

                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div> <!-- end row -->

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>

    <div class="main-content">


    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->

<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<script>
    const shareBtnRef = document.querySelector('#share');
    shareBtnRef.onclick = async () => {
        //check if native sharing is available
        if (navigator.share) {
            try {
                const shareData = {
                    title: 'Web Share Demo',
                    text: 'Wanted to share this with you',
                    url: 'http://127.0.0.1:8000/print/order/4',
                }
                await navigator.share(shareData);
                console.log('Share successfull');
            } catch (err) {
                console.log('Error: ', err);
            }
        } else {
            console.warn('Native Web Sharing not supported');
        }
    }
</script>

<script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>


<!-- apexcharts -->
<script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- jquery.vectormap map -->
<script
    src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script
    src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- Responsive examples -->
<script src="{{ asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<script src="{{ asset('backend/assets/js/pages/dashboard.init.js') }}"></script>

<!-- App js -->
<script src="{{ asset('backend/assets/js/app.js') }}"></script>
<script src="{{ asset('backend/assets/js/validate.min.js') }}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}"
    switch (type) {
        case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;

        case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;

        case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;

        case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
    }
    @endif
</script>

<!-- Required datatable js -->
<script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ asset('backend/assets/js/code.js') }}"></script>
<script src="{{ asset('backend/assets/js/handlebars.js') }}"></script>


<script type="text/javascript">
    $(document).ready(
        function () {
            $('#datatable').DataTable();
        });

</script>
</body>

</html>

