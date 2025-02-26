<?php

namespace App\Http\Controllers\Panel;

use App\Models\Operation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class OperationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $operations = Operation::all();
        return view('Panel.Operation.operationList', compact('operations', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('Panel.Operation.createOperation', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|max:100|unique:operations,name',
            'price' => 'required|numeric|min:0',
            'status' => 'required|boolean',
        ]);

        $data = $request->all();
        Operation::create($data);

        Alert::success('موفقیت', 'عملیات با موفقیت ایجاد شد');
        return redirect()->route('Panel.OperationList', compact('user'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $operation = Operation::find($id);
        return view('Panel.Operation.editOperation', compact('operation', 'user'));
    }

    public function update(Request $request, $id)
    {
        $operation = Operation::find($id);
        $request->validate([
            'name' => 'required|max:100|unique:operations,name,' . $operation->id,
            'price' => 'required|numeric|min:0',
            'status' => 'required|boolean',
        ]);

        $data = $request->all();
        $operation->update($data);

        Alert::success('موفقیت', 'عملیات با موفقیت به‌روزرسانی شد');
        return redirect()->route('Panel.OperationList');
    }

    public function destroy($id)
    {
        $operation = Operation::find($id);
        $operation->delete();

        Alert::success('موفقیت', 'عملیات با موفقیت حذف شد');
        return redirect()->route('Panel.OperationList');
    }

    public function filters(Request $request)
    {
        $user = Auth::user();
        $query = Operation::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status !== '') {
            if ($request->status == 'active') {
                $query->where('status', 1);
            } elseif ($request->status == 'inactive') {
                $query->where('status', 0);
            }
        }

        $operations = $query->get();

        return view('Panel.Operation.operationList', [
            'operations' => $operations,
            'search' => $request->search,
            'status' => $request->status,
            'user' => $user,
        ]);
    }
}
