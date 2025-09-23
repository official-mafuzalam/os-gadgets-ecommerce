<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('can:expense')->only(['index', 'show']);
    //     $this->middleware('can:expense_create')->only(['create', 'store']);
    //     $this->middleware('can:expense_edit')->only(['edit', 'update']);
    //     $this->middleware('can:expense_delete')->only(['destroy']);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Expense::query();

        // Filters
        if ($request->filled('from_date')) {
            $query->whereDate('date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $expenses = $query->with('category')->latest()->paginate(10);
        $categories = ExpenseCategory::all();
        $totalExpense = $query->sum('amount'); // Total based on filters

        return view('admin.expenses.index', compact('expenses', 'categories', 'totalExpense'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ExpenseCategory::all();
        return view('admin.expenses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
        ]);

        $user_id = auth()->id();

        Expense::create(array_merge($request->all(), ['inserted_by' => $user_id]));

        return redirect()->route('admin.expenses.index')->with('success', 'Expense created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = ExpenseCategory::all();
        $expense = Expense::findOrFail($id);
        return view('admin.expenses.create', compact('categories', 'expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
        ]);

        $user_id = auth()->id();

        Expense::where('id', $id)->update(array_merge($validatedData, [
            'inserted_by' => $user_id,
        ]));

        return redirect()->route('admin.expenses.index')->with('success', 'Expense updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
