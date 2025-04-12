@extends('Admin.layout.master')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card card-primary card-outline">
                <div class="card-header bg-primary text-white">
                    <div class="card-title d-flex align-items-center">
                        <i class="fas fa-user-md me-2"></i>
                        جزئیات پزشک
                    </div>
                </div>
                <div class="card-body">
                    <!-- اطلاعات اصلی -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="card h-100 border-primary">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        <i class="fas fa-user me-2"></i>اطلاعات شخصی
                                    </h6>
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-primary">نام پزشک:</label>
                                            <div class="border-bottom pb-1">{{ $doctor->name }}</div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-primary">کد ملی:</label>
                                            <div class="border-bottom pb-1">{{ $doctor->national_code }}</div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-primary">تلفن تماس:</label>
                                            <div class="border-bottom pb-1">{{ $doctor->mobile }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border-primary">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        <i class="fas fa-graduation-cap me-2"></i>اطلاعات تخصصی
                                    </h6>
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-primary">تخصص:</label>
                                            <div class="border-bottom pb-1">{{ $doctor->speciality->title ?? 'تعیین نشده' }}</div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-primary">شماره نظام پزشکی:</label>
                                            <div class="border-bottom pb-1">{{ $doctor->medical_number ?? 'تعیین نشده' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- نقش‌های پزشک -->
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-user-tag me-2"></i>نقش‌های پزشک
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>نقش</th>
                                            <th>درصد سهم</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($doctor->roles as $role)
                                            <tr>
                                                <td>{{ $role->title }}</td>
                                                <td>
                                                    <span class="badge bg-primary">{{ $role->quota }}%</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- عملیات‌های جراحی -->
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-procedures me-2"></i>عملیات‌های جراحی
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>نام بیمار</th>
                                            <th>نوع عمل</th>
                                            <th>نقش</th>
                                            <th>مبلغ سهم</th>
                                            <th>تاریخ عمل</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($surgeries as $surgery)
                                            <tr>
                                                <td>{{ $surgery['patient_name'] }}</td>
                                                <td>
                                                    @foreach($surgery['operations'] as $operation)
                                                        <span class="badge bg-info me-1">{{ $operation->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $surgery['role_name'] }}</span>
                                                </td>
                                                <td>{{ number_format($surgery['amount']) }} تومان</td>
                                                <td>{{ $surgery['surgeried_at'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="3">مجموع دریافتی</th>
                                            <th colspan="2" class="text-success">
                                                {{ number_format($totalAmount) }} تومان
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($doctor->description)
                    <div class="card border-primary">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-comment-alt me-2"></i>توضیحات
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="border rounded p-3 bg-light">
                                {{ $doctor->description }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer text-center bg-light">
                    <a href="{{ route('Panel.EditDoctor', $doctor->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-1"></i>ویرایش
                    </a>
                    <a href="{{ route('Panel.DoctorList') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-right me-1"></i>بازگشت
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
