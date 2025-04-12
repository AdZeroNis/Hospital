@extends('Admin.layout.master')

@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card card-warning card-outline shadow-lg rounded">
                <div class="card-header bg-warning text-dark rounded-top">
                    <div class="card-title">
                        <i class="fas fa-edit me-2"></i>
                        ویرایش نقش پزشک
                    </div>
                </div>
                <form method="POST" action="{{ route('Panel.UpdateRolesDoctor', $role->id) }}">
                    @csrf
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">عنوان نقش</label>
                                <div class="form-control border-warning shadow-sm text-dark bg-light">
                                    {{ $role->title }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="quota" class="form-label fw-bold text-dark">درصد سهم در جراحی</label>
                                <input type="number" class="form-control border-warning shadow-sm text-dark" id="quota" name="quota" value="{{ $role->quota }}" min="0" max="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-warning shadow-sm me-2">
                            <i class="fas fa-save me-2"></i>
                            ذخیره تغییرات
                        </button>
                        <a href="{{ route('Panel.RolesDoctorList') }}" class="btn btn-secondary shadow-sm">
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
