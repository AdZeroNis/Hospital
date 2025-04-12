@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5"> <!-- تنظیم تراز وسط و فاصله -->
    <div class="col-md-10"> <!-- تنظیم عرض جدول -->
        <!-- فرم فیلتر -->
        <div class="card mb-4 shadow-lg rounded"> <!-- اضافه کردن سایه بیشتر و گوشه گرد -->
            <div class="card-body">
                <!-- فرم جستجو برای پزشک -->
                <form method="GET" action="{{ route('Panel.SearchDoctor') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control shadow-sm" placeholder="جستجو بر اساس نام پزشک" value="{{ old('search', request('search')) }}" autocomplete="off"> <!-- اضافه کردن سایه به فیلد ورودی -->
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-control shadow-sm"> <!-- اضافه کردن سایه به انتخابگر وضعیت -->
                                <option value="">تمام وضعیت‌ها</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-secondary shadow">   <i class="fas fa-search me-1"></i>
                                جستجو</button> <!-- دکمه با سایه -->
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- لیست پزشکان -->
        <div class="card mb-4 shadow-lg rounded"> <!-- اضافه کردن سایه بیشتر و گوشه گرد به کارت لیست -->
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top"> <!-- سایه و تغییر رنگ هدر -->
                <h3 class="card-title">لیست پزشکان</h3>
                <a href="{{ route('Panel.CreateDoctor') }}" class="btn btn-light shadow-sm ms-auto">

                    <i class="fas fa-plus-circle me-2"></i>
                    اضافه کردن پزشک
                    </a> <!-- دکمه اضافه کردن پزشک با سایه و تغییر رنگ -->
            </div>

            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped table-hover text-center"> <!-- اضافه کردن hover و center -->
                    <thead class="table-light">
                        <tr>
                            <th>ردیف</th>
                            <th>نام پزشک</th>
                            <th>کد ملی</th>

                            <th>تخصص</th>
                            <th>وضعیت</th>
                            <th>تاریخ ایجاد</th>
                            <th style="width: 150px;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doctors as $index => $doctor)
                        <tr class="align-middle">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $doctor->name }}</td>
                            <td>{{ $doctor->national_code }}</td>

                            <td>{{ $doctor->speciality->title ?? 'ندارد' }}</td>
                            <td>
                                <span class="badge {{ $doctor->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $doctor->status ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                            <td>{{ $doctor->getCreateAtShamsi() }}</td>
                            <td>
                                <form id="delete-form-{{ $doctor->id }}" method="POST" action="{{ route('Panel.DeleteDoctor', $doctor->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" @disabled($doctor->isDeletable()) onclick="confirmDelete('{{ $doctor->id }}')" class="btn btn-danger btn-sm shadow-sm" title="حذف"> <i class="fa fa-trash text-light"></i></button> <!-- دکمه با سایه -->
                                </form>
                                <a href="{{ route('Panel.EditDoctor', $doctor->id) }}" class="btn btn-warning btn-sm shadow-sm" style="color: white !important;"><i class="fa fa-pencil text-light"></i></a> <!-- دکمه ویرایش با سایه -->
                                <a href="{{ route('Panel.DetailsDoctor', $doctor->id) }}" class="btn btn-info btn-sm shadow-sm" style="color: white !important;"><i class="fa fa-eye text-light"></i></a> <!-- دکمه مشاهده با سایه -->
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
