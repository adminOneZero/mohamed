
@extends('layouts.dashboard')
@section('active-receivied_order','active')

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
    
        <table class="styled-table">
            <thead>
                <tr>
                    <th>الفستان</th>
                    <th>المبلغ</th>
                    <th>الكميه</th>
                    <th>اللون</th>
                    <th>الحاله</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td ><img style="height: 100px; width: 90px;" src="{{ $item->image1 }}" alt=""></td>
                    <td>${{ $item->price }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->color }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
                    
                @endforeach
                <!-- and so on... -->
            </tbody>
        </table>

{{ $items->links('vendor.pagination.custom') }}

</div>


@section('js-page','/js/pages/dashboard/users.js')

@endsection