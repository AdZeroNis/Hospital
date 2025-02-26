@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5"> <!-- تنظیم تراز وسط و فاصله -->
    <div class="col-md-10"> <!-- تنظیم عرض جدول -->
        <!-- فرم فیلتر -->
        <div class="card mb-4">
            <div class="card-body">

                <!-- فرم جستجو برای پزشک -->
                <form method="GET" action="{{ route('Panel.SearchDoctor') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="جستجو بر اساس نام پزشک" value="{{ old('search', request('search')) }}">
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-control">
                                <option value="">تمام وضعیت‌ها</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-secondary">جستجو</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- لیست پزشکان -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">لیست پزشکان</h3>
                <a href="{{ route('Panel.CreateDoctor') }}" class="btn btn-primary ms-auto">اضافه کردن پزشک جدید</a>
            </div>

            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام پزشک</th>
                            <th>کد ملی</th>
                            <th>شماره نظام پزشکی</th>
                            <th>تخصص</th>
                            <th>موبایل</th>
                            <th>وضعیت</th>
                            <th style="width: 150px;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doctors as $index => $doctor)
                        <tr class="align-middle">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $doctor->name }}</td>
                            <td>{{ $doctor->national_code }}</td>
                            <td>{{ $doctor->medical_number }}</td>
                            <td>{{ $doctor->speciality->title ?? 'ندارد' }}</td>
                            <td>{{ $doctor->mobile }}</td>
                            <td>{{ $doctor->status ? 'فعال' : 'غیرفعال' }}</td>
                            <td>
                                <a href="{{ route('Panel.DeleteDoctor', $doctor->id) }}" class="btn btn-danger btn-sm">حذف</a>
                                <a href="{{ route('Panel.EditDoctor', $doctor->id) }}" class="btn btn-warning btn-sm" style="color: white !important;">ویرایش</a>
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
