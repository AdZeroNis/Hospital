@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5"> <!-- تنظیم تراز وسط و فاصله -->
    <div class="col-md-10"> <!-- تنظیم عرض جدول -->
        <!-- فرم فیلتر -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('Panel.SearchDoctorRole') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="جستجو بر اساس نام نقش دکتر" value="{{ old('search', request('search')) }}">
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

        <!-- لیست نقش‌های دکتر -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">لیست نقش‌های دکتر</h3>
                <a href="{{ route('Panel.CreateDoctorRole') }}" class="btn btn-primary ms-auto">اضافه کردن نقش جدید</a>
            </div>

            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان نقش دکتر</th>
                            <th>وضعیت</th>
                            <th style="width: 150px;">عملیات</th> <!-- تنظیم عرض ستون عملیات -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doctorRoles as $index => $role)

                        <tr class="align-middle">
                            <td>{{ $index + 1 }}</td> <!-- ردیف -->
                            <td>{{ $role->title }}</td> <!-- نمایش عنوان نقش دکتر -->
                            <td>{{ $role->status ? 'فعال' : 'غیرفعال' }}</td> <!-- وضعیت نقش -->
                            <td>
                                <!-- لینک حذف -->
                                <a href="{{ route('Panel.DeleteDoctorRole', $role->id) }}" class="btn btn-danger btn-sm">حذف</a>
                                <!-- لینک ویرایش -->
                                <a href="{{ route('Panel.EditDoctorRole', $role->id) }}" class="btn btn-warning btn-sm" style="color: white !important;">ویرایش</a>
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
