
@extends('layouts.dashboard')
@section('active-mange_requests','active')

@section('body')



<div class="wrapper" style="margin: 0px 0px 0px 0px">


    <style>
        .styled-table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }
        .styled-table thead tr {
            background-color: #009879;
            color: #ffffff;
            /* text-align: left; */
            text-align: center;
        }
        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
        }
        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }
        
        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }
        
        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }
        .styled-table tbody tr.active-row {
            font-weight: bold;
            color: #009879;
        }
        
    </style>


    <table class="styled-table" dir="rtl">
            <thead>
                <tr>
                    <th>رقم الطلب</th>
                    <th>ايميلي</th>
                    <th>عنواني</th>
                    <th>الحاله</th>
                    <th>عرض</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($items as $item)
              
                    <tr>
                        <td>{{ $item->order_id }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->status }}</td>
                        <td><i href="#" data-order_id="{{ $item->order_id }}" class="fa fa-eye showOrdersItems"></i></td>
                    </tr>
                        
                @endforeach
                <!-- and so on... -->
            </tbody>
        </table>

            <dir id="orders_modal">
                <table class="styled-table" dir="rtl">
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>الفستان</th>
                            <th>المبلغ</th>
                            <th>الكميه</th>
                            <th>اللون</th>
                            <th>الحاله</th>
                        </tr>
                    </thead>
        
                    <tbody id="table_body">
                       
                        <!-- and so on... -->
                    </tbody>
                </table>

            </dir>


</div>


@section('js-page','/js/pages/dashboard/orders.js')

@endsection