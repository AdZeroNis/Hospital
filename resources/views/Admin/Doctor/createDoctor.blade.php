@extends('Admin.layout.master')

@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card card-primary card-outline">
                <div class="card-header bg-primary text-white">
                    <div class="card-title d-flex align-items-center">
                        <i class="fas fa-user-plus me-2"></i>
                        اضافه کردن پزشک
                    </div>
                </div>
                <form method="POST" action="{{ route('Panel.StoreDoctor') }}" id="doctor-form">
                    @csrf
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="name" class="form-label fw-bold text-dark">نام پزشک</label>
                                <input type="text" class="form-control form-control-sm border-primary text-dark" id="name" name="name" required />
                            </div>
                            <div class="col-md-4">
                                <label for="national_code" class="form-label fw-bold text-dark">کد ملی</label>
                                <input type="text" class="form-control form-control-sm border-primary text-dark" id="national_code" name="national_code" required />
                            </div>
                            <div class="col-md-4">
                                <label for="medical_number" class="form-label fw-bold text-dark">شماره نظام پزشکی</label>
                                <input type="text" class="form-control form-control-sm border-primary text-dark" id="medical_number" name="medical_number" required />
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label for="speciality_id" class="form-label fw-bold text-dark">تخصص</label>
                                <select class="form-control form-control-sm border-primary text-dark" id="speciality_id" name="speciality_id" required>
                                    <option value="">یک تخصص انتخاب کنید</option>
                                    @foreach($specialities as $speciality)
                                        <option value="{{ $speciality->id }}">{{ $speciality->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="mobile" class="form-label fw-bold text-dark">موبایل</label>
                                <input type="text" class="form-control form-control-sm border-primary text-dark" id="mobile" name="mobile" required />
                            </div>
                            <div class="col-md-4">
                                <label for="Doctor_roles_id" class="form-label fw-bold text-dark">نقش پزشک</label>
                                <select class="form-control form-control-sm border-primary text-dark" id="mySelect" name="Doctor_roles[]" multiple="multiple" required>
                                    @foreach($doctor_roles as $doctor_role)
                                        <option value="{{$doctor_role->id}}">{{$doctor_role->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label for="password" class="form-label fw-bold text-dark">رمز</label>
                                <input type="password" class="form-control form-control-sm border-primary text-dark" id="password" name="password" required />
                            </div>
                            <div class="col-md-4">
                                <label for="password_confirmation" class="form-label fw-bold text-dark">تایید رمز عبور</label>
                                <input type="password" class="form-control form-control-sm border-primary text-dark @error('password') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-bold text-dark">وضعیت</label>
                                <select class="form-control form-control-sm border-primary text-dark" id="status" name="status">
                                    <option value="1">فعال</option>
                                    <option value="0">غیرفعال</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>اضافه کردن
                        </button>
                        <a href="{{ route('Panel.DoctorList') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-right me-1"></i>بازگشت
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section("srcJs")
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Admin\UserRequest', '#doctor-form'); !!}
@endsection
