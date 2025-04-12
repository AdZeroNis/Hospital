@extends('Admin.layout.master')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm col-lg-8 mx-auto">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">ثبت پرداخت برای فاکتور شماره {{ $invoice->id }}</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('Panel.storePayment') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                {{-- انتخاب نوع پرداخت --}}
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">نوع پرداخت:</label>
                    <div>
                        <input type="radio" id="cash" name="pay_type" value="cash" checked>
                        <label for="cash" class="me-3">نقدی</label>

                        <input type="radio" id="cheque" name="pay_type" value="cheque">
                        <label for="cheque">چکی</label>
                    </div>
                </div>

                {{-- شماره فیش و مبلغ --}}
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="receipt_number" class="form-label fw-bold text-dark">شماره فیش / چک</label>
                        <input type="text" class="form-control form-control-sm border-primary" id="receipt_number" name="receipt_number" value="{{ old('receipt_number') }}">

                    </div>
                    <div class="col-md-6">
                        <label for="amount" class="form-label fw-bold text-dark">مبلغ (ریال)</label>
                        <input type="number" class="form-control form-control-sm border-primary" id="amount" name="amount" value="{{ old('amount') }}">
                    </div>
                </div>

                {{-- تاریخ و آپلود فایل --}}
                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label for="due_date" class="form-label fw-bold text-dark">تاریخ پرداخت</label>
                        <input type="text" class="form-control form-control-sm border-primary" id="due_date" name="due_date"
                        value="{{ old('due_date', \Morilog\Jalali\Jalalian::now()->format('Y/m/d')) }}" data-jdp >

                    </div>

                    <div class="col-md-6">
                        <label for="receipt" class="form-label fw-bold text-dark">عکس فیش / چک</label>
                        <input type="file" class="form-control form-control-sm border-primary" id="receipt" name="receipt" accept="image/*" >
                    </div>
                    @error('receipt')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>

                {{-- توضیحات --}}
                <div class="row g-3 mt-3">
                    <div class="col-md-12">
                        <label for="description" class="form-label fw-bold text-dark">توضیحات</label>
                        <textarea class="form-control form-control-sm border-primary" id="description" name="description" rows="2">{{ old('description') }}</textarea>
                    </div>
                </div>

                {{-- دکمه ثبت --}}
                <div class="card-footer text-center bg-light mt-3">
                    <button type="submit" class="btn btn-primary btn-sm shadow-sm">
                        <i class="fas fa-check me-1"></i>ثبت پرداخت
                    </button>
                </div>
            </form>

            {{-- نمایش پرداخت‌های قبلی --}}
            <h5 class="mt-4">پرداخت‌های قبلی</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نوع پرداخت</th>
                        <th>مبلغ پرداختی</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $payment->pay_type === 'cash' ? 'نقدی' : 'چکی' }}</td>
                        <td>{{ number_format($payment->amount) }} ریال</td>
                        <td>
                            <form action="{{ route('Panel.deleteInvoice', $payment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- گزارش از پرداخت --}}
    <div class="card card-primary card-outline shadow-lg rounded mt-4 col-lg-8 mx-auto">
        <div class="card-header bg-primary text-white rounded-top">
            <div class="card-title d-flex align-items-center">
                <i class="fas fa-chart-bar me-2"></i>
                گزارش از پرداخت‌ها
            </div>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold text-dark">مبلغ پرداخت شده</h5>
                    <p id="paid-amount" class="text-success fs-5">{{ number_format($paidAmount) }} ریال</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold text-dark">مبلغ کل</h5>
                    <p id="total-amount" class="text-primary fs-5">{{ number_format($totalAmount) }} ریال</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold text-dark">مبلغ باقیمانده</h5>
                    <p id="remaining-amount" class="text-danger fs-5">{{ number_format($remainingAmount) }} ریال</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
