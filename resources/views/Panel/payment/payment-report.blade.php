@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5">
    <div class="col-md-10">
        <div class="card mb-4 shadow-lg rounded">
            <div class="card-header bg-primary text-white rounded-top">
                <h3 class="card-title">گزارش پرداخت‌ها - {{ $doctor->name }}</h3>
            </div>

            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>مبلغ پرداخت</th>
                            <th>تاریخ پرداخت</th>
                            <th>نام بیمار</th>
                            <th>عمل</th>
                            <th>عملیات‌ها</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentDetails as $payment)
                        <tr>
                            <td>{{ $payment['amount'] }}</td>
                            <td>{{ $payment['payment_date'] }}</td>
                            <td>{{ $payment['patient_name'] }}</td>
                            <td>{{ $payment['operation_names'] }}</td>
                            <td>
                                <form id="delete-form-{{ $payment['id'] }}" method="POST" action="{{ route('Panel.deleteInvoice', $payment['id']) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $payment['id'] }}')" class="btn btn-danger btn-sm shadow-sm" title="حذف"> <i class="fa fa-trash text-light"></i></button> <!-- دکمه با سایه -->
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    <strong>مجموع پرداخت‌ها: </strong> {{ number_format($totalPaid) }} تومان
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
