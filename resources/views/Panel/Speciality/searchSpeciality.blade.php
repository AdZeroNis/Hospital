@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5"> <!-- تنظیم تراز وسط و فاصله -->
    <div class="col-md-10"> <!-- تنظیم عرض جدول -->
        <!-- فرم فیلتر -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('Panel.SearchSpeciality') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="جستجو بر اساس نام  تخصص" value="{{ old('search', request('search')) }}">
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

        <!-- لیست تخصص‌ها -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">لیست تخصص‌ها</h3>
                <a href="{{ route('Panel.CreateSpeciality') }}" class="btn btn-primary ms-auto">اضافه کردن تخصص جدید</a>
            </div>

            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان تخصص</th>
                            <th>وضعیت</th>
                            <th style="width: 150px;">عملیات</th> <!-- تنظیم عرض ستون عملیات -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($specialities as $index => $speciality)
                        <tr class="align-middle">
                            <td>{{ $index + 1 }}</td> <!-- ردیف -->
                            <td>{{ $speciality->title }}</td> <!-- نمایش عنوان تخصص -->
                            <td>{{ $speciality->status ? 'فعال' : 'غیرفعال' }}</td> <!-- وضعیت تخصص -->
                            <td>
                                <!-- لینک حذف -->
                                {{-- <a href="{{ route('Panel.DeleteSpeciality', $speciality->id) }}" class="btn btn-danger btn-sm">حذف</a> --}}
                                <form id="delete-form-{{ $speciality->id }}" method="POST" action="{{ route('Panel.DeleteSpeciality', $speciality->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $speciality->id }}')" class="btn btn-danger btn-sm px-2" title="حذف">حذف</button>
                                </form>
                                <!-- لینک ویرایش -->
                                <a href="{{ route('Panel.EditSpeciality', $speciality->id) }}" class="btn btn-warning btn-sm" style="color: white !important;">ویرایش</a>
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
