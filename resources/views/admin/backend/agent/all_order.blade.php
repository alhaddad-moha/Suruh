@extends('admin.admin_master')
@section('admin')

    <div style="direction: rtl" class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">All Products</h4>


                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{route('agent.add')}}" style="float: right"
                               class="btn btn-dark btn-rounded waves-effect waves-light">Add Order</a>
                            <br>
                            <br>
                            <h4 class="card-title"> All Orders Data </h4>


                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>الرقم</th>
                                    <th>رقم المرجع</th>
                                    <th>اسم الزبون</th>
                                    <th>الحالة</th>
                                    <th>التاريخ</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                                <tbody>

                                @foreach($orders as $key => $item)
                                    <tr>
                                        <td> {{ $key+1}} </td>
                                        <td> {{ $item->cart_id }} </td>
                                        <td> {{ $item->customer_name }} </td>
                                        @if($item->status ==1)
                                            <td>تم القبول</td>
                                        @else
                                            <td>
                                                <div class="flex items-center justify-center text-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                         icon-name="check-square" data-lucide="check-square"
                                                         class="lucide lucide-check-square w-4 h-4 mr-2">
                                                        <polyline points="9 11 12 14 22 4"></polyline>
                                                        <path
                                                            d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                                                    </svg>
                                                    تم القبول
                                                </div>
                                            </td>

                                        @endif


                                        <td> {{ $item->order_date  }} </td>

                                        <td>
                                            <a href="{{ route('print.order',$item->id) }}"
                                               class="btn btn-info sm" title="Edit Data"> <i class="fas fa-print"></i>
                                            </a>

                                            <a href="{{ route('product.delete',$item->id) }}"
                                               class="btn btn-danger sm" title="Delete Data" id="delete"> <i
                                                    class="fas fa-trash-alt"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>

@endsection
