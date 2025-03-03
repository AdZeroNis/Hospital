@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5"> <!-- تنظیم تراز وسط و فاصله -->
    <div class="col-md-10"> <!-- تنظیم عرض جدول -->
        <!-- فرم فیلتر -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('Panel.Searchinsurances') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="جستجو بر اساس نام بیمه" value="{{ old('search', request('search')) }}">
                        </div>
                        {{-- <div class="col-md-3">
                            <select name="type" class="form-control">
                                <option value=""> انواع بیمه</option>
                                <option value="basic" {{ request('type') == 'basic' ? 'selected' : '' }}>پایه</option>
                                <option value="supplementary" {{ request('type') == 'supplementary' ? 'selected' : '' }}>تکمیلی</option>
                            </select>
                        </div> --}}
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">تمام وضعیت‌ها</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-secondary">جستجو</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- لیست بیمه‌ها -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">لیست بیمه‌ها</h3>
                <a href="{{ route('Panel.CreateInsurance') }}" class="btn btn-primary ms-auto">اضافه کردن بیمه جدید</a>
            </div>

            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام بیمه</th>
                            <th>نوع بیمه</th>
                            <th>درصد تخفیف</th>
                            <th>وضعیت</th>
                            <th style="width: 150px;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($insurances as $index => $insurance)
                        <tr class="align-middle">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $insurance->name }}</td>
                            <td>{{ $insurance->type == 'basic' ? 'پایه' : 'تکمیلی' }}</td>
                            <td>{{ $insurance->discount }}%</td>
                            <td>{{ $insurance->status ? 'فعال' : 'غیرفعال' }}</td>
                            <td>
                                <form id="delete-form-{{ $insurance->id }}" method="POST" action="{{ route('Panel.DeleteInsurance', $insurance->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" @disabled($insurance->isDeletable()) onclick="confirmDelete('{{ $insurance->id }}')" class="btn btn-danger btn-sm px-2" title="حذف"> <i class="fa fa-trash text-light"></i></button>
                                </form>
                                <a href="{{ route('Panel.EditInsurance', $insurance->id) }}" class="btn btn-warning btn-sm" style="color: white !important;"><i class="fa fa-pencil text-light"></i></a>
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
