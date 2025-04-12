@extends('Panel.layout.master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card card-primary card-outline">
                    <div class="card-header bg-primary text-white">
                        <div class="card-title d-flex align-items-center">
                            <i class="fas fa-procedures me-2"></i>
                            جزئیات عمل جراحی
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- اطلاعات بیمار -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="card h-100 border-primary">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            <i class="fas fa-user me-2"></i>اطلاعات بیمار
                                        </h6>
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <label class="form-label fw-bold text-primary">نام بیمار:</label>
                                                <div class="border-bottom pb-1">{{ $surgery->patient_name }}</div>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-bold text-primary">کد ملی بیمار:</label>
                                                <div class="border-bottom pb-1">{{ $surgery->patient_national_code }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-primary">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            <i class="fas fa-file-medical me-2"></i>اطلاعات پرونده
                                        </h6>
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <label class="form-label fw-bold text-primary">شماره پرونده:</label>
                                                <div class="border-bottom pb-1">{{ $surgery->document_number }}</div>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-bold text-primary">تاریخ عمل جراحی:</label>
                                                <div class="border-bottom pb-1">
                                                    {{ \Morilog\Jalali\Jalalian::fromDateTime($surgery->surgeried_at)->format('Y/m/d') }}
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-bold text-primary">تاریخ ترخیص:</label>
                                                <div class="border-bottom pb-1">
                                                    {{ \Morilog\Jalali\Jalalian::fromDateTime($surgery->released_at)->format('Y/m/d') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- عملیات‌های جراحی -->
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-knife me-2"></i>عملیات‌های جراحی
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>نام عمل</th>
                                                <th>مبلغ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($surgery->operations as $operation)
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-primary">{{ $operation->name }}</span>
                                                    </td>
                                                    <td class="text-end">{{ number_format($operation->pivot->amount) }}
                                                        تومان</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <th>مبلغ کل عملیات</th>
                                                <th class="text-end text-success">
                                                    {{ number_format($surgery->operations->sum('pivot.amount')) }} تومان
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- اطلاعات بیمه -->
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-shield-alt me-2"></i>اطلاعات بیمه
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-primary">بیمه پایه:</label>
                                        <div class="border rounded p-2 bg-light">
                                            {{ $surgery->basicInsurance ? $surgery->basicInsurance->name : 'تعیین نشده' }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-primary">بیمه تکمیلی:</label>
                                        <div class="border rounded p-2 bg-light">
                                            {{ $surgery->suppInsurance ? $surgery->suppInsurance->name : 'تعیین نشده' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- اطلاعات پزشکان -->
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-user-md me-2"></i>اطلاعات پزشکان
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    @foreach ($doctorsInfo as $doctor)
                                        <div class="col-md-4">
                                            <div class="card h-100 border-primary">
                                                <div class="card-body">
                                                    <h6 class="card-subtitle mb-2 text-muted">
                                                        <i class="fas fa-user-md me-2"></i>{{ $doctor['role'] }}
                                                    </h6>
                                                    <div class="border-bottom pb-1">
                                                        {{ $doctor['name'] ?? 'تعیین نشده' }}
                                                        @if ($doctor['has_invoices'])
                                                            @if ($doctor['paid'])
                                                                <span class="badge bg-success float-end">
                                                                    <i class="fas fa-check-circle"></i> پرداخت شده
                                                                </span>
                                                            @else
                                                                <span class="badge bg-danger float-end">
                                                                    <i class="fas fa-times-circle"></i> کامل تسویه نشده
                                                                </span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <small class="text-muted">سهم: {{ number_format($doctor['share']) }}
                                                        تومان</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        @if ($surgery->description)
                            <div class="card border-primary">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-comment-alt me-2"></i>توضیحات
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="border rounded p-3 bg-light">
                                        {{ $surgery->description }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer text-center bg-light">
                        <a href="{{ route('Panel.EditSurgery', $surgery->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>ویرایش
                        </a>
                        <a href="{{ route('Panel.SurgeryList') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-right me-1"></i>بازگشت
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
