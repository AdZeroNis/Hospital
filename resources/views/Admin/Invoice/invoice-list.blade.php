@extends('Admin.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5">
    <div class="col-md-10">
        <!-- فرم فیلتر -->
        <div class="card mb-4 shadow-lg rounded">
            <div class="card-body">
                <!-- فرم جستجو برای صورتحساب‌ها -->
                <form method="GET" action="{{route('Panel.InvoiceFilters')}}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control shadow-sm" placeholder="جستجو بر اساس پزشک"  autocomplete="off" value="{{ old('search', request('search')) }}">
                        </div>

                        <div class="col-md-3">
                            <select name="status" class="form-control shadow-sm">
                                <option value="">تمام وضعیت‌ها</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>پرداخت شده</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>در انتظار پرداخت</option>

                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-secondary shadow">
                                <i class="fas fa-search me-1"></i>
                                جستجو
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- لیست صورتحساب‌ها -->
        <div class="card mb-4 shadow-lg rounded">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
                <h3 class="card-title">لیست صورتحساب‌ها</h3>
            </div>

            <div class="card-body p-0">
                <table class="table table-striped table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ردیف</th>
                            <th>نام پزشک</th>
                            <th>مبلغ کل (تومان)</th>
                            <th>باقی‌مانده(تومان)</th>

                            <th>وضعیت</th>
                            <th>تاریخ</th>
                            <th style="width: 150px;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $index => $invoice)
                        <tr class="align-middle">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $invoice->doctor->name }}</td>
                            <td>{{ number_format($invoice->amount) }}</td>
                            <td>
                                {{ number_format($invoice->amount - $invoice->payments->sum('amount')) }}
                            </td>

                            <td>
                                <span class="badge {{ $invoice->status == 1 ? 'bg-success' : 'bg-warning' }}">
                                    {{ $invoice->status == 1 ? 'تسویه شده' : 'تسویه نشده' }}
                                </span>
                            </td>

                            <td>{{ $invoice->getCreateAtShamsi() }}</td>
                            <td>
                                <!-- منوی کشویی برای عملیات -->
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm shadow-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i> <!-- سه نقطه -->
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <form id="delete-form-{{ $invoice->id }}" method="POST" action="{{ route('Panel.DeleteInvoice', $invoice->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger" type="button" onclick="confirmDelete('{{ $invoice->id }}')">حذف</button>
                                        </form>

                                        @if($invoice->status != 1)
                                            <li><a class="dropdown-item" href="{{route('Panel.StorePayment',$invoice->id)}}">مالی</a></li>
                                        @else
                                            <li><a class="dropdown-item disabled" href="#" style="color: #6c757d; pointer-events: none;">مالی</a></li>
                                        @endif

                                        <li><a class="dropdown-item" href="{{route('Panel.print', $invoice->id)}}" target="_blank">چاپ</a></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('Panel.ReportPayments', [$invoice->doctor->id, $invoice->id]) }}">گزارش پرداخت‌ها</a>
                                        </li>

                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
