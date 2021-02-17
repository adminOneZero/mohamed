@extends('layouts.public')

@section('body')
<div class="container" style="margin-top: 20px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header ">
                    <span class="float-right">
                        تعين كلمه المرور
                    </span>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        <a href="/"><img src="img/logo-2.png" alt=""></a>
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right text-right">الايميل</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right text-right">كلمه المرور الجديده</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right text-right">اعد كلمه المرور</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group  mb-0 text-right mr-0">
                            <div class="col-md-6 offset-md-4 " >
                                <button type="submit" class="btn btn-dark">
                                    تعين كلمه المرور
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
