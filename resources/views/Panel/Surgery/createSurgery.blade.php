@extends('Panel.layout.master')

@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card card-primary card-outline shadow-lg rounded">
                <div class="card-header bg-primary text-white rounded-top">
                    <div class="card-title d-flex align-items-center">
                        <i class="fas fa-plus-circle me-2"></i>
                        اضافه کردن عمل جراحی
                    </div>
                </div>
                <form method="POST" action="{{ route('Panel.StoreSurgery') }}" id="surgery-form">
                    @csrf
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="patient_name" class="form-label fw-bold text-dark">نام بیمار</label>
                                <input type="text" class="form-control form-control-sm border-primary text-dark shadow-sm" id="patient_name" name="patient_name" required />
                            </div>
                            <div class="col-md-6">
                                <label for="patient_national_code" class="form-label fw-bold text-dark">کد ملی بیمار</label>
                                <input type="text" class="form-control form-control-sm border-primary text-dark shadow-sm" id="patient_national_code" name="patient_national_code" required />
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-12">
                                <label for="operation_id" class="form-label fw-bold text-dark">نوع عمل جراحی</label>
                                <select class="form-control form-control-sm border-primary text-dark shadow-sm" id="mySelect" name="operations[]" multiple="multiple" required>
                                    <option value="">انتخاب نوع عمل جراحی</option>
                                    @foreach ($operations as $operation)
                                        <option value="{{ $operation->id }}" data-price="{{ $operation->price }}">{{ $operation->name }} - {{ number_format($operation->price) }} ریال</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label for="basic_insurance_id" class="form-label fw-bold text-dark">بیمه پایه</label>
                                <select class="form-control form-control-sm border-primary text-dark shadow-sm" id="basic_insurance_id" name="basic_insurance_id">
                                    <option value="">انتخاب بیمه پایه</option>
                                    @foreach ($insurances as $insurance)
                                        @if ($insurance->type == 'basic')
                                            <option value="{{ $insurance->id }}">{{ $insurance->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="supp_insurance_id" class="form-label fw-bold text-dark">بیمه تکمیلی</label>
                                <select class="form-control form-control-sm border-primary text-dark shadow-sm" id="supp_insurance_id" name="supp_insurance_id">
                                    <option value="">انتخاب بیمه تکمیلی</option>
                                    @foreach ($insurances as $insurance)
                                        @if ($insurance->type == 'supplementary')
                                            <option value="{{ $insurance->id }}">{{ $insurance->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="document_number" class="form-label fw-bold text-dark">شماره پرونده</label>
                                <input type="number" class="form-control form-control-sm border-primary text-dark shadow-sm" id="document_number" name="document_number" required />
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label for="surgeon_id" class="form-label fw-bold text-dark">جراح</label>
                                <select class="form-control form-control-sm border-primary text-dark shadow-sm" id="surgeon_id" name="surgeon_id" required>
                                    <option value="">انتخاب جراح</option>
                                    @foreach ($doctors as $doctor)
                                        @if ($doctor->roles->contains('id', 1))
                                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="anesthesiologist_id" class="form-label">متخصص بیهوشی</label>
                                <select class="form-control form-control-sm" id="anesthesiologist_id" name="anesthesiologist_id" required>
                                    <option value="">انتخاب متخصص بیهوشی</option>
                                    @foreach ($doctors as $doctor)
                                        @if ($doctor->roles->contains('id', 2))
                                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="consultant_id" class="form-label">مشاور</label>
                                <select class="form-control form-control-sm" id="consultant_id" name="consultant_id">
                                    <option value="">انتخاب مشاور</option>
                                    @foreach ($doctors as $doctor)
                                        @if ($doctor->roles->contains('id', 3))
                                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-2">
    <div class="col-md-6 mb-2">
        <label for="surgeried_at" class="form-label">تاریخ عمل جراحی</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="surgeried_at"
            name="surgeried_at"
            data-jdp
            placeholder="مثال: 1402/09/15"
            required

        />
    </div>
    <div class="col-md-6 mb-2">
        <label for="released_at" class="form-label">تاریخ ترخیص</label>
        <input
            type="text"
            class="form-control form-control-sm"
            id="released_at"
            name="released_at"
            data-jdp
            placeholder="مثال: 1402/09/20"
            required

        />
    </div>
</div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-12">
                                <label for="description" class="form-label fw-bold text-dark">توضیحات</label>
                                <textarea class="form-control form-control-sm border-primary text-dark shadow-sm" id="description" name="description" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <button type="submit" class="btn btn-primary btn-sm shadow-sm">
                            <i class="fas fa-plus me-1"></i>ثبت عمل جراحی
                        </button>
                        <a href="{{ route('Panel.SurgeryList') }}" class="btn btn-secondary btn-sm shadow-sm">
                            <i class="fas fa-arrow-right me-1"></i>بازگشت
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


