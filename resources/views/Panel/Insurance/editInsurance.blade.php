@extends('Panel.layout.master')

@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card card-warning card-outline shadow-lg rounded">
                <div class="card-header bg-warning text-dark rounded-top">
                    <div class="card-title">
                        <i class="fas fa-edit me-2"></i>
                        ویرایش بیمه
                    </div>
                </div>
                <form method="POST" action="{{ route('Panel.UpdateInsurance', $insurance->id) }}">
                    @csrf
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-bold text-dark">نام بیمه</label>
                                <input type="text" class="form-control border-warning shadow-sm text-dark" id="name" name="name" value="{{ $insurance->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="type" class="form-label fw-bold text-dark">نوع بیمه</label>
                                <select class="form-control border-warning shadow-sm text-dark" id="type" name="type" required>
                                    <option value="basic" {{ $insurance->type == 'basic' ? 'selected' : '' }}>پایه</option>
                                    <option value="supplementary" {{ $insurance->type == 'supplementary' ? 'selected' : '' }}>تکمیلی</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="discount" class="form-label fw-bold text-dark">درصد تخفیف</label>
                                <input type="number" class="form-control border-warning shadow-sm text-dark" id="discount" name="discount" value="{{ $insurance->discount }}" min="0" max="100" required>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold text-dark">وضعیت</label>
                                <select class="form-control border-warning shadow-sm text-dark" id="status" name="status">
                                    <option value="1" {{ $insurance->status ? 'selected' : '' }}>فعال</option>
                                    <option value="0" {{ !$insurance->status ? 'selected' : '' }}>غیرفعال</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning shadow-sm">
                            <i class="fas fa-save me-2"></i>
                            ذخیره تغییرات
                        </button>
                        <a href="{{ route('Panel.InsuranceList') }}" class="btn btn-secondary shadow-sm">
                            <i class="fas fa-arrow-right me-2"></i>
                            بازگشت
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
