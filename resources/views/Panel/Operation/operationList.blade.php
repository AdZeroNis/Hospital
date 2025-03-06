@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-4">
    <div class="col-md-10">
        <!-- فرم فیلتر -->
        <div class="card mb-4 shadow-lg rounded">
            <div class="card-body">
                <form method="GET" action="{{ route('Panel.SearchOperation') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control shadow-sm" placeholder="جستجو بر اساس نام عملیات" value="{{ old('search', request('search')) }}">
                        </div>
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

        <!-- لیست عملیات -->
        <div class="card mb-4 shadow-lg rounded">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
                <h3 class="card-title">
                    <i class="fas fa-list me-2"></i>
                    لیست عملیات
                </h3>
                <a href="{{ route('Panel.CreateOperation') }}" class="btn btn-light shadow-sm ms-auto">
                    <i class="fas fa-plus-circle me-2"></i>
                    اضافه کردن عملیات جدید
                </a>
            </div>

            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ردیف</th>
                            <th>نام عملیات</th>
                            <th>هزینه</th>
                            <th>تایخ ایجاد</th>
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
                            <td>{{ $operation->getCreateAtShamsi() }}</td>
                            <td>
                                <span class="badge {{ $operation->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $operation->status ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('Panel.EditOperation', $operation->id) }}" class="btn btn-warning btn-sm shadow-sm" title="ویرایش">
                                        <i class="fa fa-pencil text-light"></i>
                                    </a>
                                    <form id="delete-form-{{ $operation->id }}" method="POST" action="{{ route('Panel.DeleteOperation', $operation->id) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" @disabled($operation->isDeletable()) onclick="confirmDelete('{{ $operation->id }}')" class="btn btn-danger btn-sm shadow-sm" title="حذف">
                                            <i class="fa fa-trash text-light"></i>
                                        </button>
                                    </form>
                                </div>
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
