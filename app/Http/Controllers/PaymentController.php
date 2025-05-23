<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment; 
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Http\Request;
use App\Models\User;

class PaymentController extends Controller
{
   
    public function index(Request $request)
    {
        
        $payments = Payment::with(['user', 'enrollment'])->latest()->paginate(15); 
        return view('admin.payments.index', compact('payments')); 
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.payments.create', compact('users')); 
    }

    
    public function store(StorePaymentRequest $request)
    {
        Payment::create($request->validated());

        return redirect()->route('admin.payments.index')->with('success', 'Płatność została pomyślnie dodana.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['user', 'enrollment']);
        return view('admin.payments.index', compact('payment')); 
    }

    public function edit(Payment $payment)
    {
        $users = User::orderBy('name')->get();
        return view('admin.payments.edit', compact('payment', 'users')); 
    }
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());

        return redirect()->route('admin.payments.index')->with('success', 'Płatność została pomyślnie zaktualizowana.');
    }

    public function destroy(Payment $payment)
    {
        

        try {
            $payment->delete();
            return redirect()->route('admin.payments.index')->with('success', 'Płatność została usunięta.');
        } catch (\Exception $e) {
            return redirect()->route('admin.payments.index')->with('error', 'Wystąpił błąd podczas usuwania płatności.');
        }
    }
}
