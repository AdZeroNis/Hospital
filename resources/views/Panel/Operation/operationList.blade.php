@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5"> <!-- تنظیم تراز وسط و فاصله -->
    <div class="col-md-10"> <!-- تنظیم عرض جدول -->
        <!-- فرم فیلتر -->
        <div class="card mb-4">
            <div class="card-body">

                <!-- فرم جستجو برای عملیات -->
                <form method="GET" action="{{ route('Panel.SearchOperation') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="جستجو بر اساس نام عملیات" value="{{ old('search', request('search')) }}">
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

        <!-- لیست عملیات -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">لیست عملیات</h3>
                <a href="{{ route('Panel.CreateOperation') }}" class="btn btn-primary ms-auto">اضافه کردن عملیات جدید</a>
            </div>

            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام عملیات</th>
                            <th>هزینه</th>
                            <th>وضعیت</th>
                            <th style="width: 150px;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($operations as $index => $operation)
                        <tr class="align-middle">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $operation->name }}</td>
                            <td>{{ $operation->price }} تومان</td>
                            <td>{{ $operation->status ? 'فعال' : 'غیرفعال' }}</td>
                            <td>
                                <form id="delete-form-{{ $surgery->id }}" method="POST" action="{{ route('Panel.DeleteOperation', $operation->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $operation->id }}')" class="btn btn-danger btn-sm px-2" title="حذف">حذف</button>
                                </form>
                                {{-- <a href="{{ route('Panel.DeleteOperation', $operation->id) }}" class="btn btn-danger btn-sm">حذف</a> --}}
                                <a href="{{ route('Panel.EditOperation', $operation->id) }}" class="btn btn-warning btn-sm" style="color: white !important;">ویرایش</a>
                                    {{-- <a href="{{ route('Panel.DeleteOperation', $operation->id) }}" class="btn btn-danger btn-sm" style="color: white !important;">حذف</a> --}}



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
