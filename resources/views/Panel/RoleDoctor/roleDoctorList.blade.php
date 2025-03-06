@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-4">
    <div class="col-md-10">
        <!-- لیست نقش پزشکان -->
        <div class="card mb-4 shadow-lg rounded">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
                <h3 class="card-title">
                    <i class="fas fa-list me-2"></i>
                    لیست نقش‌های پزشکان
                </h3>
            </div>

            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان نقش</th>
                            <th>درصد سهم</th>
                            <th>اجباری</th>
                            <th>تاریخ ایجاد</th>
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
                            <td>
                                <span class="badge {{ $roleDoctor->required ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $roleDoctor->required ? 'بله' : 'خیر' }}
                                </span>
                            </td>
                            <td>{{ $roleDoctor->getCreatedAtShamsi() }}</td>
                            <td>
                                <span class="badge {{ $roleDoctor->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $roleDoctor->status ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('Panel.EditRolesDoctor', $roleDoctor->id) }}" class="btn btn-warning btn-sm shadow-sm" title="ویرایش">
                                    <i class="fa fa-pencil text-light"></i>
                                </a>
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
