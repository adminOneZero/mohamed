
@extends('layouts.dashboard')

@section('active-dresses','active')
    
@section('body')
<form action="/dashboard/seller/add-dersses" method="post" enctype="multipart/form-data">
       
    @csrf
    <div>
        <input type="file" name="image1" id="" value="{{ old('image1') }}">
        <input type="file" name="image2" id="" value="{{ old('image2') }}">
        <input type="file" name="image3" id="" value="{{ old('image3') }}">
    </div>
    <input name="price" value="{{ old('price') }}" type="text" placeholder="السعر">
    <input name="color" value="{{ old('color') }}" type="text" placeholder="اللون">
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

    <textarea  name="description" id="" cols="50" rows="10">
        {{ old('description') }}
        Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero's De Finibus Bonorum et Malorum for use in a type specimen book. It usually begins with
    </textarea>
    <select name="type" id="">
        <option value="فساتين زفاف">فساتين زفاف</option>
        <option value="فساتين سوارية">فساتين سوارية</option>
        <option value="فساتين أطفال">فساتين أطفال</option>
        <option value="اخرى">اخرى</option>
    </select>
    <input type="submit" value="اضف">
</form>

@section('js-page','/js/pages/dashboard/users.js')
@endsection