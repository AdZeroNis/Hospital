<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>صورت‌حساب</title>
    <style>
        body {
            font-family: 'Tahoma', sans-serif;
            direction: rtl;
            margin: 30px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        .section {
            margin-bottom: 20px;
        }
        .btn-print {
            display: inline-block;
            background-color: #e3342f;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            float: left;
        }
        .info-table td {
            border: none;
            padding: 4px 0;
        }
    </style>
</head>
<body>

    <a href="#" onclick="window.print()" class="btn-print" >🖨 چاپ صورت‌حساب</a>

    <div class="section">
        <table class="info-table">
            <tr>
                <td><strong>صورت‌حساب پایه:</strong> {{ $invoice->doctor->insurance_type ?? '---' }}</td>
                <td><strong>نام پزشک:</strong> {{ $invoice->doctor->name }}</td>
                <td><strong>شماره صورت‌حساب:</strong> {{ $invoice->id }}</td>
                <td><strong>تاریخ صدور:</strong> {{ \Morilog\Jalali\Jalalian::fromDateTime($invoice->created_at)->format('Y/m/d') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>ردیف</th>
                <th>بیمار</th>
                <th>عنوان عمل(ها)</th>
                <th>تاریخ عمل</th>
                <th>تاریخ ترخیص</th>
                <th>سهم (تومان)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surgeryDetails as $index => $surgery)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $surgery['patient_name'] }}</td>
                <td>{{ $surgery['operations'] }}</td>
                <td>{{ $surgery['surgeried_at'] }}</td>
                <td>{{ $surgery['discharged_at'] }}</td>
                <td>{{ number_format($surgery['amount']) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @if($invoice->payments->isNotEmpty())
    <div class="section">
        <h4>لیست پرداختی‌ها</h4>
        <table>
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>مبلغ (تومان)</th>
                    <th>تاریخ پرداخت</th>
                    <th>روش پرداخت</th>
                    <th>توضیحات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->payments as $index => $payment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ number_format($payment->amount) }}</td>
                        <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($payment->due_date)->format('Y/m/d') }}</td>
                        <td>{{ $payment->method == 'cash' ? 'نقدی' : 'چک' }}</td>
                        <td>{{ $payment->description ?? '---' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

    <div class="section">
        <table class="info-table">
            <tr>
                <td><strong>مجموع مبلغ:</strong> {{ number_format($totalAmount) }} تومان</td>
                <td><strong>پرداخت‌شده:</strong> {{ number_format($paidAmount) }} تومان</td>
                <td><strong>باقی‌مانده:</strong> {{ number_format($remainingAmount) }} تومان</td>
            </tr>
        </table>
    </div>

</body>
</html>
