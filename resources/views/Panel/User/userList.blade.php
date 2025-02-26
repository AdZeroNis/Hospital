@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5">
     <!-- تراز وسط و فاصله از هدر -->
    <div class="col-md-10"> <!-- تنظیم عرض جدول -->
        <div class="card mb-4">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">لیست کاربران</h3>
                <a href="{{route('Panel.CreateUser')}}" class="btn btn-primary ms-auto" >اضافه کردن کاربر جدید</a>
            </div>



            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>اسم</th>
                            <th>تلفن</th>
                            <th>ایمیل</th>
                            <th style="width: 150px;">عملیات</th> <!-- عرض ستون عملیات -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="align-middle">
                            @foreach ($users as $index => $user)
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td> <!-- نمایش نام کاربر -->
                            <td>{{ $user->mobile }}</td> <!-- نمایش تلفن کاربر -->
                            <td>{{ $user->email }}</td> <!-- نمایش ایمیل کاربر -->
                            <td>
                                <!-- لینک حذف -->
                                <a href="{{route('Panel.DeleteUser',$user->id)}}" class="btn btn-danger btn-sm">حذف</a>
                                <!-- لینک ویرایش -->
                                <a href="{{ route('Panel.Edit', $user->id) }}" class="btn btn-warning btn-sm" style="color: white !important;">ویرایش</a>

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
