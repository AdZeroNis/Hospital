@extends('Panel.layout.master')

@section('content')

<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card card-primary card-outline mb-3">
                <div class="card-header py-2">
                    <div class="card-title">ویرایش عمل جراحی</div>
                </div>
                <form method="POST" action="{{ route('Panel.UpdateSurgery', $surgery->id) }}">
                    @csrf
                    <div class="card-body py-2">
                        <div class="row">
                            <!-- نام بیمار و کد ملی در یک ردیف -->
                            <div class="col-md-6 mb-2">
                                <label for="patient_name" class="form-label mb-1">نام بیمار</label>
                                <input type="text" class="form-control form-control-sm" id="patient_name" name="patient_name" value="{{ $surgery->patient_name }}" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="patient_national_code" class="form-label mb-1">کد ملی بیمار</label>
                                <input type="text" class="form-control form-control-sm" id="patient_national_code" name="patient_national_code" value="{{ $surgery->patient_national_code }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <!-- نوع عمل جراحی و مبلغ -->
                            <div class="col-md-6 mb-2">
                                <label for="operation_id" class="form-label mb-1">نوع عمل جراحی</label>
                                <select class="form-control form-control-sm" id="operation_id" name="operation_id" required>
                                    <option value="">انتخاب نوع عمل جراحی</option>
                                    @foreach ($operations as $operation)
                                        <option value="{{ $operation->id }}" {{ $surgery->operations->first()->id == $operation->id ? 'selected' : '' }}>
                                            {{ $operation->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="amount" class="form-label mb-1">مبلغ عمل جراحی</label>
                                <input type="number" class="form-control form-control-sm" id="amount" name="amount" value="{{ $surgery->operations->first()->pivot->amount }}" required min="0">
                            </div>
                        </div>

                        <div class="row">
                            <!-- بیمه پایه و تکمیلی و شماره مدارک در یک ردیف -->
                            <div class="col-md-4 mb-2">
                                <label for="basic_insurance_id" class="form-label mb-1">بیمه پایه</label>
                                <select class="form-control form-control-sm" id="basic_insurance_id" name="basic_insurance_id">
                                    <option value="">انتخاب بیمه پایه</option>
                                    @foreach ($insurances as $insurance)
                                        @if ($insurance->type == 'basic')
                                            <option value="{{ $insurance->id }}" {{ $surgery->basic_insurance_id == $insurance->id ? 'selected' : '' }}>
                                                {{ $insurance->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="supp_insurance_id" class="form-label mb-1">بیمه تکمیلی</label>
                                <select class="form-control form-control-sm" id="supp_insurance_id" name="supp_insurance_id">
                                    <option value="">انتخاب بیمه تکمیلی</option>
                                    @foreach ($insurances as $insurance)
                                        @if ($insurance->type == 'supplementary')
                                            <option value="{{ $insurance->id }}" {{ $surgery->supp_insurance_id == $insurance->id ? 'selected' : '' }}>
                                                {{ $insurance->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="document_number" class="form-label mb-1">شماره پرونده</label>
                                <input type="number" class="form-control form-control-sm" id="document_number" name="document_number" value="{{ $surgery->document_number }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <!-- انتخاب پزشکان در یک ردیف -->
                            <div class="col-md-4 mb-2">
                                <label for="surgeon_id" class="form-label mb-1">جراح</label>
                                <select class="form-control form-control-sm" id="surgeon_id" name="surgeon_id" required>
                                    <option value="">انتخاب جراح</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ $surgery->doctors->where('pivot.doctor_role_id', 1)->first()->id == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="anesthesiologist_id" class="form-label mb-1">بیهوشی</label>
                                <select class="form-control form-control-sm" id="anesthesiologist_id" name="anesthesiologist_id" required>
                                    <option value="">انتخاب متخصص بیهوشی</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ $surgery->doctors->where('pivot.doctor_role_id', 2)->first()->id == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="consultant_id" class="form-label mb-1">مشاور</label>
                                <select class="form-control form-control-sm" id="consultant_id" name="consultant_id">
                                    <option value="">انتخاب مشاور</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ $surgery->doctors->where('pivot.doctor_role_id', 3)->first()->id ?? '' == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- تاریخ عمل و تاریخ ترخیص در یک ردیف -->
                            <div class="col-md-6 mb-2">
                                <label for="surgeried_at" class="form-label mb-1">تاریخ عمل جراحی</label>
                                <input type="text" class="form-control form-control-sm" id="surgeried_at" name="surgeried_at" value="{{ $surgery->getSurgeriedAtShamsi() }}" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="released_at" class="form-label mb-1">تاریخ ترخیص</label>
                                <input type="text" class="form-control form-control-sm" id="released_at" name="released_at" value="{{ $surgery->getReleasedAtShamsi() }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <!-- توضیحات در یک ردیف جداگانه -->
                            <div class="col-md-12 mb-2">
                                <label for="description" class="form-label mb-1">توضیحات</label>
                                <textarea class="form-control form-control-sm" id="description" name="description" rows="2">{{ $surgery->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer py-2">
                        <button type="submit" class="btn btn-primary btn-sm">ذخیره تغییرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection



