
@extends('layouts.dashboard')

@section('active-dresses','active')
    
@section('body')
<div class="newDresses">
    <form action="/dashboard/seller/add-dersses" method="post" enctype="multipart/form-data">
        
        @csrf
        <fieldset>
            <legend> اضاف فستان جديد </legend>

            <p><input type="file" name="image1" id="" value="{{ old('image1') }}"></p>
            <p><input type="file" name="image2" id="" value="{{ old('image2') }}"></p>
            <p><input type="file" name="image3" id="" value="{{ old('image3') }}"></p>
    
            <p><input name="price" value="{{ old('price') }}" type="text" placeholder="السعر"></p>
            <p><input name="color" value="{{ old('color') }}" type="text" placeholder="اللون"></p>
            <P>
                <span>
                    <input type="checkbox" name="X" value="X">
                    X
                </span>
                <span>
                    <input type="checkbox" name="L" value="L" >
                    L
                </span>
                <span>
                    <input type="checkbox" name="XL" value="XL" >
                    XL
                </span>
            </P>
            <p>
                <textarea placeholder="وصف المنتج" name="description" id="" cols="50" rows="10">{{ old('description') }}</textarea>
            </p>
            <p>
                <select name="type" id="">
                    <option value="فساتين زفاف">فساتين زفاف</option>
                    <option value="فساتين سوارية">فساتين سوارية</option>
                    <option value="فساتين أطفال">فساتين أطفال</option>
                </select>
            </p>
        <p>
            <input class="btn-base btn1" type="submit" value="اضف">
        </p>
    </fieldset>

    </form>
</div>

@section('js-page','/js/pages/dashboard/users.js')
@endsection