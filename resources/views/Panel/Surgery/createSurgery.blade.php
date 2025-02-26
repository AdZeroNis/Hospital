@extends('Panel.layout.master')

@section('content')

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">اضافه کردن عمل جراحی</div>
                </div>
                <form method="POST" action="{{ route('Panel.StoreSurgery') }}">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="patient_name" class="form-label">نام بیمار</label>
                            <input type="text" class="form-control" id="patient_name" name="patient_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="patient_national_code" class="form-label">کد ملی بیمار</label>
                            <input type="text" class="form-control" id="patient_national_code" name="patient_national_code" required>
                        </div>

                        <!-- Basic Insurance Checkbox -->
                        <div class="mb-3">
                            <label class="form-label">بیمه پایه</label><br>
                            @foreach ($insurances as $insurance)
                                @if ($insurance->type == 'basic')
                                    <input type="checkbox" id="basic_insurance_id" name="basic_insurance_id" value="{{ $insurance->id }}">
                                    <label for="basic_insurance_id">{{ $insurance->name }}</label><br>
                                @endif
                            @endforeach
                        </div>

                        <!-- Supplementary Insurance Checkbox -->
                        <div class="mb-3">

                            @foreach ($insurances as $insurance)
                                @if ($insurance->type == 'supplementary')
                                    <input type="checkbox" id="supp_insurance_id" name="supp_insurance_id" value="{{ $insurance->id }}">
                                    <label for="supp_insurance_id">{{ $insurance->name }}</label><br>
                                @endif
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <label for="document_number" class="form-label">شماره مدارک</label>
                            <input type="number" class="form-control" id="document_number" name="document_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">توضیحات</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="surgeried_at" class="form-label">تاریخ عمل جراحی</label>
                            <input type="date" class="form-control" id="surgeried_at" name="surgeried_at" required>
                        </div>
                        <div class="mb-3">
                            <label for="released_at" class="form-label">تاریخ ترخیص</label>
                            <input type="date" class="form-control" id="released_at" name="released_at" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">اضافه کردن عمل جراحی</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
