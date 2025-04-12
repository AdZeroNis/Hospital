@extends('Admin.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5">
    <div class="col-md-10">
        <!-- فرم فیلتر -->
        <div class="card mb-4 shadow-lg rounded">
            <div class="card-body">
                <form method="GET" action="{{ route('Panel.Searchinsurances') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control shadow-sm" autocomplete="off" placeholder="جستجو بر اساس نام بیمه" value="{{ old('search', request('search')) }}">
                        </div>
                        {{-- <div class="col-md-3">
                            <select name="type" class="form-control">
                                <option value="">تمام انواع بیمه</option>
                                <option value="basic" {{ request('type') == 'basic' ? 'selected' : '' }}>پایه</option>
                                <option value="supplementary" {{ request('type') == 'supplementary' ? 'selected' : '' }}>تکمیلی</option>
                            </select>
                        </div> --}}
                        <div class="col-md-4">
                            <select name="status" class="form-control shadow-sm">
                                <option value="">تمام وضعیت‌ها</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-secondary shadow">   <i class="fas fa-search me-1"></i>
                                جستجو</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- لیست بیمه‌ها -->
        <div class="card mb-4 shadow-lg rounded">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
                <i class="fas fa-list me-2"></i>
                <h3 class="card-title">لیست بیمه‌ها</h3>
                <a href="{{ route('Panel.CreateInsurance') }}" class="btn btn-light shadow-sm ms-auto">
                    <i class="fas fa-plus-circle me-2"></i>
                    اضافه کردن بیمه

                </a>
            </div>

            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ردیف</th>
                            <th>نام بیمه</th>
                            <th>نوع بیمه</th>
                            <th>درصد تخفیف</th>

                            <th>وضعیت</th>
                            <th>تاریخ ایجاد</th>
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
                             <!-- تاریخ ایجاد -->
                            <td>
                                <span class="badge {{ $insurance->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $insurance->status ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                            <td>{{ $insurance-> getCreateAtShamsi()}}</td>
                            <td>
                                <a href="{{ route('Panel.EditInsurance', $insurance->id) }}" class="btn btn-warning btn-sm shadow-sm" style="color: white !important;"><i class="fa fa-pencil text-light"></i></a>

                                <form id="delete-form-{{ $insurance->id }}" method="POST" action="{{ route('Panel.DeleteInsurance', $insurance->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" @disabled($insurance->isDeletable()) onclick="confirmDelete('{{ $insurance->id }}')" class="btn btn-danger btn-sm shadow-sm" title="حذف"> <i class="fa fa-trash text-light"></i></button>
                                </form>
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
