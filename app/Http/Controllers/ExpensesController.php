<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Enums\CategoryEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ExpenseRequest;
use App\Services\DateAndExpenseService;

class ExpensesController extends Controller
{
  public function __construct(
    public DateAndExpenseService $dateAndExpenseService
  ) {
  }
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    ['categories' => $categories, 'filters' => $filters, 'isEmpty' => $isEmpty] = $this->dateAndExpenseService->handleFilters($request);

    $expenses = Expenses::with(['date'])
      ->filters($filters)
      ->orderBy('date_id', 'desc')
      ->paginate(20);

    $expensesSum = Expenses::filters($filters)
      ->sum('price');

    $expenseData = $this->dateAndExpenseService->handleExpenseData($filters, $expensesSum, $categories);

    return response()->json(compact('expenses', 'categories', 'expenseData', 'filters'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $categories = CategoryEnum::toArray();
    return response()->json(compact('categories'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ExpenseRequest $request)
  {
    $validated = $request->validated();

    DB::transaction(function () use (&$date, $validated) {
      $date = request()->user()->dates()->firstOrCreate(collect($validated)->only('date')->toArray());

      foreach ($validated['expenses'] as $expense) {
        $date->expenses()->create($expense);
      }

      $date->update(['expenses_sum' => $date->expenses->sum('price')]);
    });

    return response()->json([
      'status' => 'success',
      'data' => compact('date'),
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show(Expenses $expenses)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Expenses $expenses)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ExpenseRequest $request, Expenses $expense)
  {
    $validated = $request->validated();

    $expense->update($validated);

    $expense->date->update(['expenses_sum' => $expense->date->expenses->sum('price')]);

    return response()->json([
      'status' => 'success',
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Expenses $expense)
  {
    $date = $expense->date;

    $expense->delete();

    $date->update(['expenses_sum' => $date->expenses->sum('price')]);

    return response()->json(['status' => 'success']);
  }

  public function seed()
  {

    foreach (range(1, 27) as $day) {
      DB::transaction(function () use (&$day) {
        $date = request()->user()->dates()->firstOrCreate([
          'date' => "2001-0" . rand(1, 9) . "-$day",
        ]);

        $expenses = [];

        $categories = collect(CategoryEnum::toArray());

        foreach (['a', 'b', 'c'] as $expenseName) {
          $expenses[] = [
            'name' => $expenseName . '-' . $day . '-' . rand(10, 30),
            'price' => rand(10, 30),
            'category_id' => rand($categories->min('id'), $categories->max('id')), // CategoryEnum
            'date_id' => $date->id,
            'created_at' => now(),
            'updated_at' => now(),
          ];
        }

        Expenses::insert($expenses);

        $date->update(['expenses_sum' => $date->expenses->sum('price')]);
      });
    }
    return response()->json(['status' => 'success']);
  }

  public function deleteAll()
  {
    request()->user()->dates()->delete();
    return response()->json(['status' => 'success']);
  }
}
