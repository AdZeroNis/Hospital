@extends('Panel.layout.master')

@section('content')
<main class="app-main">
    <div class="container-fluid">
        <!-- Stats Cards Row -->
        <div class="row mb-4">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm rounded-3 bg-success text-white">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-md fa-2x text-white-50"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle mb-1 opacity-75">تعداد پزشکان</h6>
                                <h2 class="card-title mb-0 fw-bold">{{ $doctorCount }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm rounded-3 bg-info text-white">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-shield-alt fa-2x text-white-50"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle mb-1 opacity-75">تعداد بیمه‌ها</h6>
                                <h2 class="card-title mb-0 fw-bold">{{ $insuranceCount }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm rounded-3 bg-primary text-white">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-exclamation-circle fa-2x text-white-50"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle mb-1 opacity-75">پرداخت‌های تسویه‌نشده</h6>
                                <h2 class="card-title mb-0 fw-bold">{{ $unpaidPayments->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unpaid Payments Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                        <h5 class="mb-0 fw-bold text-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            لیست پرداخت‌های تسویه‌نشده
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($unpaidPayments->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="py-3 border-bottom-0">#</th>
                                            <th class="py-3 border-bottom-0">پزشک</th>
                                            <th class="py-3 border-bottom-0">مبلغ</th>
                                            <th class="py-3 border-bottom-0">تاریخ</th>
                                            <th class="py-3 border-bottom-0">وضعیت</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($unpaidPayments as $index => $payment)
                                            <tr class="border-top">
                                                <td class="py-3">{{ $index + 1 }}</td>
                                                <td class="py-3 fw-medium">{{ $payment->doctor->name ?? 'نامشخص' }}</td>
                                                <td class="py-3">{{ number_format($payment->amount) }} <span class="text-muted fs-7">ریال</span></td>
                                                <td class="py-3">
                                                    <span class="d-inline-flex align-items-center">
                                                        <i class="far fa-calendar-alt me-2 text-muted"></i>
                                                        {{ \Morilog\Jalali\Jalalian::fromDateTime($payment->created_at)->format('Y/m/d') }}
                                                    </span>
                                                </td>
                                                <td class="py-3">
                                                    <span class="badge bg-danger bg-opacity-10 text-danger py-2 px-3 rounded-pill">
                                                        <i class="fas fa-times-circle me-1"></i>
                                                        تسویه نشده
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-check-circle fa-3x text-success opacity-25"></i>
                                </div>
                                <h5 class="text-muted mb-2">هیچ پرداخت تسویه نشده‌ای وجود ندارد</h5>
                                <p class="text-muted fs-7">همه پرداخت‌ها با موفقیت تسویه شده‌اند</p>
                            </div>
                        @endif
                    </div>
                    @if($unpaidPayments instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="card-footer bg-light border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted fs-7">
                                    نمایش {{ $unpaidPayments->count() }} مورد از {{ $unpaidPayments->total() }} پرداخت
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-outline-primary">مشاهده همه</button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if($nearDueChequePayments->isNotEmpty())
            <div class="card mt-4 border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-danger bg-opacity-10 border-0 py-3">
                    <h5 class="mb-0 fw-bold text-danger">
                        <i class="fas fa-receipt me-2"></i>
                        چک‌های نزدیک به سررسید
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>پزشک</th>
                                    <th>مبلغ</th>
                                    <th>تاریخ سررسید</th>
                                    <th>وضعیت</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nearDueChequePayments as $index => $payment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $payment->invoice->doctor->name ?? 'نامشخص' }}</td>
                                        <td>{{ number_format($payment->amount) }} <span class="text-muted fs-7">ریال</span></td>
                                        <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($payment->due_date)->format('Y/m/d') }}</td>
                                        <td>
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                                <i class="fas fa-clock me-1"></i> نزدیک سررسید
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif


        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1.25rem rgba(0, 0, 0, 0.1) !important;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    .fs-7 {
        font-size: 0.85rem;
    }
    .rounded-3 {
        border-radius: 0.75rem !important;
    }
</style>
@endpush
