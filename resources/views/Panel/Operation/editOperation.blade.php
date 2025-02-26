@extends('Panel.layout.master')

@section('content')

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">ویرایش عملیات</div>
                </div>
                <form method="POST" action="{{ route('Panel.UpdateOperation', $operation->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">نام عملیات</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $operation->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">هزینه (تومان)</label>
                            <input type="number" class="form-control" id="price" name="price" value="{{ $operation->price }}" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">وضعیت</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" {{ $operation->status ? 'selected' : '' }}>فعال</option>
                                <option value="0" {{ !$operation->status ? 'selected' : '' }}>غیرفعال</option>
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
