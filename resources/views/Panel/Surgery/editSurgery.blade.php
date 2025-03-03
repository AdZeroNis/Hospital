@extends('Panel.layout.master')

@section('content')

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">ویرایش عمل جراحی</div>
                </div>
                <form method="POST" action="{{ route('Panel.UpdateSurgery', $surgery->id) }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- نام بیمار و کد ملی در یک ردیف -->
                            <div class="col-md-6 mb-3">
                                <label for="patient_name" class="form-label">نام بیمار</label>
                                <input type="text" class="form-control" id="patient_name" name="patient_name" value="{{ $surgery->patient_name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="patient_national_code" class="form-label">کد ملی بیمار</label>
                                <input type="text" class="form-control" id="patient_national_code" name="patient_national_code" value="{{ $surgery->patient_national_code }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <!-- بیمه پایه و تکمیلی و شماره مدارک در یک ردیف -->
                            <div class="col-md-4 mb-3">
                                <label for="basic_insurance_id" class="form-label">بیمه پایه</label>
                                <select class="form-control" id="basic_insurance_id" name="basic_insurance_id" required>
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
                            <div class="col-md-4 mb-3">
                                <label for="supp_insurance_id" class="form-label">بیمه تکمیلی</label>
                                <select class="form-control" id="supp_insurance_id" name="supp_insurance_id">
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
                            <div class="col-md-4 mb-3">
                                <label for="document_number" class="form-label">شماره پرونده</label>
                                <input type="number" class="form-control" id="document_number" name="document_number" value="{{ $surgery->document_number }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <!-- تاریخ عمل و تاریخ ترخیص در یک ردیف -->
                            <div class="col-md-6 mb-3">
                                <label for="surgeried_at" class="form-label">تاریخ عمل جراحی</label>
                                <input type="text" class="form-control" id="surgeried_at" name="surgeried_at" value="{{ $surgery->getSurgeriedAtShamsi() }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="released_at" class="form-label">تاریخ ترخیص</label>
                                <input type="text" class="form-control" id="released_at" name="released_at" value="{{ $surgery->getReleasedAtShamsi() }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <!-- توضیحات در یک ردیف جداگانه -->
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">توضیحات</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ $surgery->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
