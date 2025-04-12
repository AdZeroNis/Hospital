@extends('Admin.layout.master')

@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card card-warning card-outline mb-4 shadow-lg rounded">
                <!--begin::Header-->
                <div class="card-header bg-warning text-dark rounded-top">
                    <div class="card-title">
                        <i class="fas fa-edit me-2"></i>
                        ویرایش تخصص
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Form-->
                <form method="POST" action="{{ route('Panel.UpdateSpeciality', $speciality->id) }}">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label fw-bold text-dark">عنوان تخصص</label>
                                <input
                                    type="text"
                                    class="form-control shadow-sm border-warning"
                                    id="title"
                                    name="title"
                                    value="{{ $speciality->title }}"
                                    required
                                />
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold text-dark">وضعیت</label>
                                <select
                                    name="status"
                                    id="status"
                                    class="form-control shadow-sm border-warning"
                                    required
                                >
                                    <option value="1" {{ $speciality->status == 1 ? 'selected' : '' }}>فعال</option>
                                    <option value="0" {{ $speciality->status == 0 ? 'selected' : '' }}>غیرفعال</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-warning shadow-sm me-2">
                            <i class="fas fa-save me-2"></i>
                            ذخیره تغییرات
                        </button>
                        <a href="{{ route('Panel.SpecialitiesList') }}" class="btn btn-secondary shadow-sm">
                            <i class="fas fa-arrow-right me-2"></i>
                            بازگشت
                        </a>
                    </div>
                    <!--end::Footer-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>

@endsection
