@extends('layouts.public')

@section('body')
    
<x-slot name="logo">
    <x-jet-authentication-card-logo />
</x-slot>

<div class="mb-4  p-3 text-sm text-gray-600 text-right" dir="rtl">
    شكرا لتسجيلك! قبل البدء ، هل يمكنك التحقق من عنوان بريدك الإلكتروني من خلال النقر على الرابط الذي أرسلناه إليك عبر البريد الإلكتروني للتو؟ إذا لم تتلق البريد الإلكتروني ، فسنرسل لك رسالة أخرى بكل سرور.
    {{-- {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }} --}}
</div>

@if (session('status') == 'verification-link-sent')
    <div class="mb-4 p-3 font-medium text-sm text-green-600 text-success" dir="rtl">
        تم إرسال رابط تحقق جديد إلى عنوان البريد الإلكتروني الذي قدمته أثناء التسجيل.
        {{-- {{ __('A new verification link has been sent to the email address you provided during registration.') }} --}}
    </div>
@endif

<div class="mt-2 flex items-center justify-between pl-3 btn-group">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf

        <div>
            <x-jet-button type="submit" class="btn btn-primary ml-3">
                اعاده ارسال  رساله التحقق
                {{-- {{ __('Resend Verification Email') }} --}}
            </x-jet-button>
        </div>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 btn btn-dark pt-2 pb-2">
            تسجيل الخروج
            {{-- {{ __('Logout') }} --}}
        </button>
    </form>
</div>
@endsection