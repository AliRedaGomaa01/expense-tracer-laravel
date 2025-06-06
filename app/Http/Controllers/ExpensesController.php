<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Enums\CategoryEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ExpenseRequest;
use App\Services\DateAndExpenseService;
use Illuminate\Support\Facades\Validator;

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
      ->paginate(12)->withQueryString();

    $expensesSum = Expenses::filters($filters)
      ->sum('price');

    $expenseData = $this->dateAndExpenseService->handleExpenseData($filters, $expensesSum, $categories);

    return response()->json([
      'status' => 'success',
      compact('expenses', 'categories', 'expenseData', 'filters')
    ]);
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
  public function store(Request $request)
  {
    $categoryIds = implode(',', (collect(CategoryEnum::toArray())->pluck('id')->toArray()));

    $validator = Validator::make(
      $request->all(),
      [
        'date' => ['required', 'date'],
        'expenses' => ['required', 'array', 'min:1'],
        'expenses.*.price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
        'expenses.*.name' => ['required', 'string', 'max:255'],
        'expenses.*.category_id' => ['required', 'numeric', "in:$categoryIds"],
      ]
    );

    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'errors' => $validator->errors()
      ]);
    }

    $validated = $validator->validated();

    DB::transaction(function () use (&$date, $validated) {
      $date = request()->user()->dates()->firstOrCreate(collect($validated)->only('date')->toArray());

      foreach ($validated['expenses'] as $expense) {
        $date->expenses()->create($expense);
      }

      $date->update(['expenses_sum' => $date->expenses->sum('price')]);

      $date->load('expenses');
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
  public function update(Request $request, Expenses $expense)
  {
    $categoryIds = implode(',', (collect(CategoryEnum::toArray())->pluck('id')->toArray()));

    $validator = Validator::make(
      $request->all(),
      [
        'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
        'name' => ['required', 'string', 'max:255'],
        'category_id' => ['required', 'numeric', "in:$categoryIds"],
      ]
    );

    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'errors' => $validator->errors()
      ]);
    }

    $validated = $validator->validated();

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

    if ($date->expenses->isEmpty()) {
      $date->delete();
    } else {
      $date->update(['expenses_sum' => $date->expenses->sum('price')]);
    }

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
