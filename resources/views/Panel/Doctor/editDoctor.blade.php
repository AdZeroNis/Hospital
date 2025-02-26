@extends('Panel.layout.master')

@section('content')

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-10">
            <!--begin::Quick Example-->
            <div class="card card-primary card-outline mb-4">
                <!--begin::Header-->
                <div class="card-header">
                    <div class="card-title">ویرایش پزشک</div>
                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <form method="POST" action="{{ route('Panel.UpdateDoctor', $doctor->id) }}">
                    @csrf

                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">نام پزشک</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $doctor->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="national_code" class="form-label">کد ملی</label>
                            <input type="text" class="form-control" id="national_code" name="national_code" value="{{ $doctor->national_code }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="medical_number" class="form-label">شماره نظام پزشکی</label>
                            <input type="text" class="form-control" id="medical_number" name="medical_number" value="{{ $doctor->medical_number }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="speciality_id" class="form-label">تخصص</label>
                            <select name="speciality_id" id="speciality_id" class="form-control" required>
                                @foreach ($specialities as $speciality)
                                    <option value="{{ $speciality->id }}" {{ $doctor->speciality_id == $speciality->id ? 'selected' : '' }}>
                                        {{ $speciality->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">موبایل</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $doctor->mobile }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">وضعیت</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="1" {{ $doctor->status == 1 ? 'selected' : '' }}>فعال</option>
                                <option value="0" {{ $doctor->status == 0 ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">بروزرسانی</button>
                    </div>
                    <!--end::Footer-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Quick Example-->
        </div>
    </div>
</div>

@endsection
