@extends('Panel.layout.master')

@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card card-primary card-outline shadow-lg rounded">
                <div class="card-header bg-primary text-white rounded-top">
                    <div class="card-title">
                        <i class="fas fa-plus-circle me-2"></i>
                        اضافه کردن عملیات جدید
                    </div>
                </div>
                <form method="POST" action="{{ route('Panel.StoreOperation') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-bold text-dark">نام عملیات</label>
                                <input type="text" class="form-control border-primary shadow-sm text-dark" id="name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label fw-bold text-dark">هزینه (تومان)</label>
                                <input type="number" class="form-control border-primary shadow-sm text-dark" id="price" name="price" min="0" required>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold text-dark">وضعیت</label>
                                <select class="form-control border-primary shadow-sm text-dark" id="status" name="status">
                                    <option value="1">فعال</option>
                                    <option value="0">غیرفعال</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary shadow-sm">
                            <i class="fas fa-save me-2"></i>
                            ذخیره
                        </button>
                        <a href="{{ route('Panel.OperationList') }}" class="btn btn-secondary shadow-sm">
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
