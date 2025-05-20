<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Expense;
use Illuminate\Http\Request;


class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();
        return view('admin.expense', compact('expenses'));
    }

    public function store(Request $request)
    {
        Expense::create($request->only(['name', 'price', 'expense_day']));
        return redirect('/admin/expense')->with('success', 'Thêm danh mục thu chi thành công!');

    }

    public function edit($id)
    {
        return response()->json(Expense::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->update($request->only(['name', 'price', 'expense_day']));
        return redirect('/admin/expense')->with('success', 'Cập nhật danh mục thu chi thành công!');
    }

    public function destroy($id)
    {
        Expense::destroy($id);
        return redirect('/admin/expense')->with('success', 'Xóa danh mục thu chi thành công!');

    }
}
