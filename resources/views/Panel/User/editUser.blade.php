@extends('Panel.layout.master')

@section('content')

<div class="d-flex justify-content-center mt-5"> <!-- تنظیم تراز وسط و فاصله -->
    <div class="col-md-8"> <!-- تنظیم عرض جدول -->

        <!-- ویرایش پروفایل کاربر -->
        <div class="card mb-4 shadow-lg rounded-3"> <!-- اضافه کردن سایه و گوشه‌های گرد -->
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white p-3 rounded-top"> <!-- پس‌زمینه و متن سفارشی -->
                <h3 class="card-title mb-0">ویرایش پروفایل ادمین</h3>
            </div>

            <!-- /.card-header -->
            <div class="card-body p-4"> <!-- اضافه کردن padding برای زیبایی بیشتر -->
                <div class="row align-items-center">
                    <div class="col-md-3 text-center"> <!-- تنظیم موقعیت تصویر -->
                        <img src="{{ asset('Adminasset/assets/img/user2-160x160.jpg') }}" alt="Admin Profile" class="img-fluid rounded-circle shadow-sm" style="width: 150px; height: 150px;"> <!-- تصویر گرد با سایه -->
                    </div>
                    <div class="col-md-9">
                        <!-- فرم ویرایش پروفایل -->
                        <form method="POST" action="{{ route('updateProfile', $user->id) }}">
                            @csrf


                            <div class="mb-3">
                                <label for="name" class="form-label">نام</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">ایمیل</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="current_password" class="form-label">رمز عبور فعلی (برای تغییر رمز ضروری است)</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                       id="current_password" name="current_password"
                                       placeholder="رمز عبور فعلی را وارد کنید">
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">رمز عبور جدید (در صورت تمایل)</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password"
                                       placeholder="در صورت نیاز رمز عبور جدید وارد کنید">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">تایید رمز عبور جدید</label>
                                <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation"
                                       placeholder="تایید رمز عبور جدید">
                            </div>


                            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@endsection
