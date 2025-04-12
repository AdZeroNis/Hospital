@extends('Admin.layout.master')

@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card card-warning card-outline">
                <div class="card-header bg-warning text-dark">
                    <div class="card-title d-flex align-items-center">
                        <i class="fas fa-user-md me-2"></i>
                        ویرایش پزشک
                    </div>
                </div>
                <form method="POST" action="{{ route('Panel.UpdateDoctor', $doctor->id) }}" id="doctor-form">
                    @csrf
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="name" class="form-label fw-bold text-warning">نام پزشک</label>
                                <input type="text" class="form-control form-control-sm border-warning" id="name" name="name" value="{{ $doctor->name }}" required />
                            </div>
                            <div class="col-md-4">
                                <label for="national_code" class="form-label fw-bold text-warning">کد ملی</label>
                                <input type="text" class="form-control form-control-sm border-warning" id="national_code" name="national_code" value="{{ $doctor->national_code }}" required />
                            </div>
                            <div class="col-md-4">
                                <label for="medical_number" class="form-label fw-bold text-warning">شماره نظام پزشکی</label>
                                <input type="text" class="form-control form-control-sm border-warning" id="medical_number" name="medical_number" value="{{ $doctor->medical_number }}" required />
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label for="speciality_id" class="form-label fw-bold text-warning">تخصص</label>
                                <select class="form-control form-control-sm border-warning" id="speciality_id" name="speciality_id" required>
                                    @foreach($specialities as $speciality)
                                        <option value="{{ $speciality->id }}" {{ $doctor->speciality_id == $speciality->id ? 'selected' : '' }}>
                                            {{ $speciality->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="mobile" class="form-label fw-bold text-dark">موبایل</label>
                                <input type="text" class="form-control form-control-sm border-warning text-dark" id="mobile" name="mobile" value="{{ $doctor->mobile }}" required />
                            </div>
                            <div class="col-md-4">
                                <label for="Doctor_roles_id" class="form-label fw-bold text-dark">نقش پزشک</label>
                                <select class="form-control form-control-sm border-warning text-dark" id="mySelect" name="Doctor_roles[]" multiple="multiple" required>
                                    @foreach($doctor_roles as $doctor_role)
                                        <option value="{{$doctor_role->id}}" {{ in_array($doctor_role->id, $doctor->roles->pluck('id')->toArray()) ? 'selected' : '' }}>
                                            {{$doctor_role->title}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label for="password" class="form-label fw-bold text-dark">رمز</label>
                                <input type="password" class="form-control form-control-sm border-warning text-dark" id="password" name="password" />
                            </div>
                            <div class="col-md-4">
                                <label for="password_confirmation" class="form-label fw-bold text-dark">تایید رمز عبور</label>
                                <input type="password" class="form-control form-control-sm border-warning text-dark @error('password') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-bold text-dark">وضعیت</label>
                                <select class="form-control form-control-sm border-warning text-dark" id="status" name="status">
                                    <option value="1" {{ $doctor->status == 1 ? 'selected' : '' }}>فعال</option>
                                    <option value="0" {{ $doctor->status == 0 ? 'selected' : '' }}>غیرفعال</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <button type="submit" class="btn btn-warning btn-sm">
                            <i class="fas fa-save me-1"></i>بروزرسانی
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
