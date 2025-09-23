<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('can:expense')->only(['index']);
    //     $this->middleware('can:expense_create')->only(['create', 'store']);
    //     $this->middleware('can:expense_edit')->only(['edit', 'update']);
    //     $this->middleware('can:expense_delete')->only(['destroy']);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenseCategories = ExpenseCategory::active()->get();
        return view('admin.expenses.categories.index', compact('expenseCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.expenses.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        ExpenseCategory::create($validated);

        return redirect()->route('admin.expense-categories.index')->with('success', 'Expense category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = ExpenseCategory::findOrFail($id);
        return view('admin.expenses.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = ExpenseCategory::findOrFail($id);
        return view('admin.expenses.categories.create', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = ExpenseCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $category->update($validated);

        return redirect()->route('admin.expense-categories.index')->with('success', 'Expense category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = ExpenseCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.expense-categories.index')->with('success', 'Expense category deleted successfully.');
    }
}
