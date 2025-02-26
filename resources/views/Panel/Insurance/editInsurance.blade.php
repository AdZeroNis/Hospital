@extends('Panel.layout.master')

@section('content')

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">ویرایش بیمه</div>
                </div>
                <form method="POST" action="{{ route('Panel.UpdateInsurance', $insurance->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">نام بیمه</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $insurance->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">نوع بیمه</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="basic" {{ $insurance->type == 'basic' ? 'selected' : '' }}>پایه</option>
                                <option value="supplementary" {{ $insurance->type == 'supplementary' ? 'selected' : '' }}>تکمیلی</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="discount" class="form-label">درصد تخفیف</label>
                            <input type="number" class="form-control" id="discount" name="discount" value="{{ $insurance->discount }}" min="0" max="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">وضعیت</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" {{ $insurance->status ? 'selected' : '' }}>فعال</option>
                                <option value="0" {{ !$insurance->status ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
