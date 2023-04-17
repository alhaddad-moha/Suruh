@extends('admin.admin_master')
@section('admin')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">المستند</h4>

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
                                                # {{$order->cart_id}}</strong></h4>
                                        <h3>
                                            <img src="{{ asset('backend/assets/images/logo-light.png')}}" alt="logo"
                                                 height="24"/>
                                        </h3>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6">
                                            <address>
                                                <strong>التاريخ:</strong>
                                                {{$order->order_date}}
                                            </address>
                                        </div>
                                        <div style="direction: rtl" class="col-6 text-end">
                                            <address>
                                                <strong>التسليم الى الأخ:</strong>
                                                {{$order->customer_name}}
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
                                                <table style="direction: rtl" class="table">
                                                    <thead>
                                                    <tr>
                                                        <td class="text-center"><strong>الرقم</strong>
                                                        <td class="text-center"><strong>الاسم</strong>
                                                        <td class="text-center"><strong>الشركة</strong>
                                                        <td class="text-center"><strong>الكمية</strong>
                                                        <td class="text-center"><strong>النوع</strong>
                                                        <td class="text-center"><strong>الوصف</strong>
                                                        </td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->

                                                    @foreach($carts as $key => $item)
                                                        <tr>

                                                            <td class="text-center">{{ $key+1 }}</td>
                                                            <td class="text-center"> {{ $item['product']['name'] }} </td>
                                                            <td class="text-center"> {{ $item['supplier']['name'] }} </td>
                                                            <td class="text-center"> {{ $item->quantity ." ".$item['unit']['name'] }} </td>
                                                            <td class="text-center"> {{ $item['category']['name'] }} </td>
                                                            <td class="text-center"> {{   $item['category']['name']." ". $item['supplier']['name']." ".$item['product']['name'] }} </td>
                                                        </tr>

                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="d-print-none">
                                                <div class="float-end">
                                                    @if($order->status==1)
                                                        <h1 style="font-size:17px">ملاحظات العميل: </h1>
                                                        <h1 style="font-size:17px"> {{$approve['notes']}}</h1>

                                                    @endif
                                                    <a href="javascript:window.print()"
                                                       class="btn btn-success waves-effect waves-light"><i
                                                            class="fa fa-print"></i></a>

                                                    <button class="btn btn-primary waves-effect waves-light ms-2" onclick="copyText()">نسخ الرابط</button>
                                                </div>
                                            </div>
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

    <script>
        function copyText() {

            /* Copy text into clipboard */
            navigator.clipboard.writeText
            ("https://suruh-khalij.com/acceptOrder/{{$order->id}}");
        }
    </script>
    <script>
        const shareBtnRef = document.querySelector('#share');
        shareBtnRef.onclick = async () => {
            //check if native sharing is available
            if (navigator.share) {
                try {
                    const shareData = {
                        title: 'Web Share Demo',
                        text: 'Wanted to share this with you',
                        url: 'http://127.0.0.1:8000/acceptOrder/{{$order->id}}',
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
@endsection
