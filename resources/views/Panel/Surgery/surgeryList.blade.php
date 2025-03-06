@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5"> <!-- تنظیم تراز وسط و فاصله -->
    <div class="col-md-10"> <!-- تنظیم عرض جدول -->
        <!-- فرم فیلتر -->
        <div class="card mb-4 shadow-lg rounded"> <!-- اضافه کردن سایه بیشتر و گوشه گرد -->
            <div class="card-body">
                <!-- فرم جستجو برای اعمال جراحی -->
                <form method="GET" action="{{ route('Panel.SearchSurgery') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control shadow-sm" placeholder="جستجو بر اساس نام بیمار" value="{{ old('search', request('search')) }}"> <!-- اضافه کردن سایه به فیلد ورودی -->
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-control shadow-sm"> <!-- اضافه کردن سایه به انتخابگر وضعیت -->
                                <option value="">تمام وضعیت‌ها</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-secondary shadow">جستجو</button> <!-- دکمه با سایه -->
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- لیست اعمال جراحی -->
        <div class="card mb-4 shadow-lg rounded"> <!-- اضافه کردن سایه بیشتر و گوشه گرد به کارت لیست -->
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top"> <!-- سایه و تغییر رنگ هدر -->
                <h3 class="card-title">لیست اعمال جراحی</h3>
                <a href="{{ route('Panel.CreateSurgery') }}" class="btn btn-light shadow-sm ms-auto">اضافه کردن عمل جراحی جدید</a> <!-- دکمه اضافه کردن با سایه و تغییر رنگ -->
            </div>

            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped table-hover text-center"> <!-- اضافه کردن hover و center -->
                    <thead class="table-light">
                        <tr>
                            <th>ردیف</th>
                            <th>نام بیمار</th>
                            <th>کد ملی بیمار</th>
                            <th>تاریخ جراحی</th>
                            <th>تاریخ رهگیری</th>
                            <th style="width: 150px;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surgeries as $index => $surgery)
                        <tr class="align-middle">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $surgery->patient_name }}</td>
                            <td>{{ $surgery->patient_national_code }}</td>
                            <td>{{ $surgery->getSurgeriedAtShamsi() }}</td>
                            <td>{{ $surgery->getReleasedAtShamsi() }}</td>
                            <td>
                                <form id="delete-form-{{ $surgery->id }}" method="POST" action="{{ route('Panel.DeleteSurgery', $surgery->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $surgery->id }}')" class="btn btn-danger btn-sm shadow-sm" title="حذف"> <i class="fa fa-trash text-light"></i></button> <!-- دکمه با سایه -->
                                </form>
                                <a href="{{ route('Panel.EditSurgery', $surgery->id) }}" class="btn btn-warning btn-sm shadow-sm" style="color: white !important;"><i class="fa fa-pencil text-light"></i></a> <!-- دکمه ویرایش با سایه -->
                                <a href="{{ route('Panel.DetailsSurgery', $surgery->id) }}" class="btn btn-info btn-sm shadow-sm" style="color: white !important;"><i class="fa fa-eye text-light"></i></a> <!-- دکمه مشاهده با سایه -->
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
