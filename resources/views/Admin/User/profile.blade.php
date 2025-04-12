@extends('Admin.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5"> <!-- تنظیم تراز وسط و فاصله -->
    <div class="col-md-8"> <!-- تنظیم عرض جدول -->

        <!-- پروفایل کاربر -->
        <div class="card mb-4 shadow-lg rounded-3"> <!-- اضافه کردن سایه و گوشه‌های گرد -->
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white p-3 rounded-top"> <!-- پس‌زمینه و متن سفارشی -->
                <h3 class="card-title mb-0 btn-sm">پروفایل ادمین</h3>
                <a href="{{route('editProfile',$user->id)}}" class="btn btn-light ms-auto">ویرایش پروفایل</a> <!-- دکمه‌ای با استایل واضح‌تر -->
            </div>

            <!-- /.card-header -->
            <div class="card-body p-4"> <!-- اضافه کردن padding برای زیبایی بیشتر -->
                <div class="row align-items-center">
                    <div class="col-md-3 text-center"> <!-- تنظیم موقعیت تصویر -->
                        <img src="{{ asset('Adminasset/assets/img/user2-160x160.jpg') }}" alt="Admin Profile" class="img-fluid rounded-circle shadow-sm" style="width: 150px; height: 150px;"> <!-- تصویر گرد با سایه -->
                    </div>
                    <div class="col-md-9">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th class="text-muted">نام:</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">ایمیل:</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@endsection
