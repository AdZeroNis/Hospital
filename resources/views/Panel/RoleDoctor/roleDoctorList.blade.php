@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5"> <!-- تنظیم تراز وسط و فاصله -->
    <div class="col-md-10"> <!-- تنظیم عرض جدول -->
        <!-- فرم فیلتر -->
        <div class="card mb-4">
            <div class="card-body">

                <!-- فرم جستجو برای نقش پزشک -->
                <form method="GET" action="{{ route('Panel.SearchDoctorRole') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="جستجو بر اساس نام نقش پزشک" value="{{ old('search', request('search')) }}">
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-control">
                                <option value="">تمام وضعیت ها</option>
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

        <!-- لیست نقش پزشکان -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">لیست نقش‌های پزشکان</h3>
                <a href="{{ route('Panel.CreateRolesDoctor') }}" class="btn btn-primary ms-auto">اضافه کردن نقش جدید</a>
            </div>

            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
            
    <tr>
        <th>ردیف</th>
        <th>عنوان نقش</th>
        <th>درصد سهم</th>
        <th>اجباری</th> <!-- ستون جدید -->
        <th>وضعیت</th>
        <th style="width: 150px;">عملیات</th>
    </tr>
</thead>
<tbody>
    @foreach ($roles as $index => $roleDoctor)
    <tr class="align-middle">
        <td>{{ $index + 1 }}</td>
        <td>{{ $roleDoctor->title }}</td>
        <td>{{ $roleDoctor->quota }}%</td>
        <td>{{ $roleDoctor->required ? 'بله' : 'خیر' }}</td> <!-- نمایش وضعیت اجباری -->
        <td>{{ $roleDoctor->status ? 'فعال' : 'غیرفعال' }}</td>
        <td>
            <a href="{{ route('Panel.DeleteRolesDoctor', $roleDoctor->id) }}" class="btn btn-danger btn-sm">حذف</a>
            <a href="{{ route('Panel.EditRolesDoctor', $roleDoctor->id) }}" class="btn btn-warning btn-sm" style="color: white !important;">ویرایش</a>
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
