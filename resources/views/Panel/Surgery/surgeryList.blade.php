@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5"> <!-- تنظیم تراز وسط و فاصله -->
    <div class="col-md-10"> <!-- تنظیم عرض جدول -->
        <!-- فرم فیلتر -->
        <div class="card mb-4">
            <div class="card-body">

                <!-- فرم جستجو برای اعمال جراحی -->
                <form method="GET" action="{{ route('Panel.SearchSurgery') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="جستجو بر اساس نام بیمار" value="{{ old('search', request('search')) }}">
                        </div>
                   
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-secondary">جستجو</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- لیست اعمال جراحی -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">لیست اعمال جراحی</h3>
                <a href="{{ route('Panel.CreateSurgery') }}" class="btn btn-primary ms-auto">اضافه کردن عمل جراحی جدید</a>
            </div>

            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام بیمار</th>
                            <th>کد ملی بیمار</th>
                            <th>بیمه پایه</th>

                            <th style="width: 150px;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surgeries as $index => $surgery)
                        <tr class="align-middle">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $surgery->patient_name }}</td>
                            <td>{{ $surgery->patient_national_code }}</td>
                            <td>{{ $surgery->basicInsurance ? $surgery->basicInsurance->name : 'ندارد' }}</td>

                            <td>
                                <a href="{{ route('Panel.DeleteSurgery', $surgery->id) }}" class="btn btn-danger btn-sm">حذف</a>
                                <a href="{{ route('Panel.EditSurgery', $surgery->id) }}" class="btn btn-warning btn-sm" style="color: white !important;">ویرایش</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@endsection
