@extends('layouts.dashboard')
@section('payments','active')

@section('body')


<form action="/get-paid" method="post" class="conversion">
    @csrf
    <input type="text" name="phone_number" placeholderbtn-base btn-success="رقم الهاتف">
    <input type="text" name="money" placeholder="المبلغ">
    <select name="payment_methode" id="" >
        <option value="vodafone">vodafone</option>
    </select>
<button type="submit" class="">طلب التحويل</button>
</form>

{{-- <form action="/get-paid" method="post" class="conversion">
    @csrf

     <input type="text" name="phone_number" placeholder="رقم الهاتف">
    <input type="text" name="money" placeholder="المبلغ">
    <select name="payment_methode" id="">
        <option value="vodafone">vodafone</option>
    </select>
    <button type="submit" class="btn-base btn-success">طلب التحويل</button>
</form> --}}



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
                <th>المبلغ</th>
                <th>وسيلة الدفع</th>
                <th>الهاتف</th>
                <th>الحاله</th>
                <th>التاريخ</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($payments as $payment)
          
                <tr>
                    <td>{{ $payment->money }}</td>
                    <td>{{ $payment->payment_methode }}</td>
                    <td>{{ $payment->phone }}</td>
                    <td>{{ $payment->status == 1 ? 'جاري الارسال...' : 'تم الارسال'}}</td>
                    <td dir="ltr" style="float: right;">{{ $payment->date }}</td>
                </tr>
                    
            @endforeach
            <!-- and so on... -->
        </tbody>
    </table>


@endsection