@extends('Panel.layout.master')

@section('content')

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">اضافه کردن پزشک</div>
                </div>
                <form method="POST" action="{{ route('Panel.StoreDoctor') }}" id="doctor-form">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- نام و کد ملی و شماره نظام پزشکی در یک ردیف -->
                            <div class="col-md-4 mb-3">
                                <label for="name" class="form-label">نام پزشک</label>
                                <input type="text" class="form-control" id="name" name="name" required />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="national_code" class="form-label">کد ملی</label>
                                <input type="text" class="form-control" id="national_code" name="national_code" required />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="medical_number" class="form-label">شماره نظام پزشکی</label>
                                <input type="text" class="form-control" id="medical_number" name="medical_number" required />
                            </div>
                        </div>

                        <div class="row">
                            <!-- تخصص و موبایل و وضعیت در یک ردیف -->
                            <div class="col-md-4 mb-3">
                                <label for="speciality_id" class="form-label">تخصص</label>
                                <select class="form-control" id="speciality_id" name="speciality_id" required>
                                    <option value="">یک تخصص انتخاب کنید</option>
                                    @foreach($specialities as $speciality)
                                        <option value="{{ $speciality->id }}">{{ $speciality->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="mobile" class="form-label">موبایل</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" required />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">وضعیت</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1">فعال</option>
                                    <option value="0">غیرفعال</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- رمز و تایید رمز در یک ردیف -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">رمز</label>
                                <input type="password" class="form-control" id="password" name="password" required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">تایید رمز عبور</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="تایید رمز عبور">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">اضافه کردن</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section("srcJs")
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Admin\UserRequest', '#doctor-form'); !!}
@endsection
