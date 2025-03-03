@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5"> <!-- تنظیم تراز وسط و فاصله -->
    <div class="col-md-10"> <!-- تنظیم عرض جدول -->
        <!-- فرم فیلتر -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('Panel.SearchSurgery') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="جستجو بر اساس نام بیمار" value="{{ old('search', request('search')) }}">
                        </div>
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

        <!-- لیست اعمال جراحی -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">لیست اعمال جراحی</h3>
                <a href="{{ route('Panel.CreateSurgery') }}" class="btn btn-primary ms-auto">اضافه کردن عمل جراحی جدید</a>
            </div>

            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام بیمار</th>
                            <th>کد ملی بیمار</th>
                            <th>بیمه پایه</th>
                            <th>بیمه تکمیلی</th>
                            <th>تاریخ جراحی</th>
                            <th>تاریخ رهگیری</th>
                            {{-- <th>وضعیت</th> --}}
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
                            <td>{{ $surgery->suppInsurance ? $surgery->suppInsurance->name : 'ندارد' }}</td>
                            {{-- <td>{{ $surgery->status ? 'فعال' : 'غیرفعال' }}</td> --}}
                            <td>{{ $surgery->getSurgeriedAtShamsi() }}</td>
                            <td>{{ $surgery->getReleasedAtShamsi() }}</td>
                            <td>
                                <form id="delete-form-{{ $surgery->id }}" method="POST" action="{{ route('Panel.DeleteSurgery', $surgery->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" @disabled($surgery->isDeletable()) onclick="confirmDelete('{{ $surgery->id }}')" class="btn btn-danger btn-sm px-2" title="حذف">    <i class="fa fa-trash text-light"></i></button>
                                </form>
                                <a href="{{ route('Panel.EditSurgery', $surgery->id) }}" class="btn btn-warning btn-sm" style="color: white !important;"><i class="fa fa-pencil text-light"></i></a>
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
