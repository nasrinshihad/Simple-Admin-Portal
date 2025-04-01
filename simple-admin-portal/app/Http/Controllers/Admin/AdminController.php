<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index()
{
    $customerCount = Customer::count();
    $invoiceCount = Invoice::count();
    
    $maxCustomers = max($customerCount, 500); 
    $maxInvoices = max($invoiceCount, 100);  
    
    return view('admin.dashboard', [
        'customerCount' => $customerCount,
        'invoiceCount' => $invoiceCount,
        'customerPercentage' => ($customerCount / $maxCustomers) * 100,
        'invoicePercentage' => ($invoiceCount / $maxInvoices) * 100
    ]);
}


   public function create($type)
   {
       if (!in_array($type, ['customer', 'invoice'])) {
           abort(404);
       }

       $customers = $type === 'invoice' ? Customer::all() : null;

       return view('admin.forms.create', compact('type', 'customers'));
   }

   public function store(Request $request, $type)
   {
       $validated = $this->validateRequest($request, $type);

       if ($type === 'customer') {
           Customer::create($validated);
           return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully');
       } else {
           Invoice::create($validated);
           return redirect()->route('admin.invoices.index')->with('success', 'Invoice created successfully');
       }
   }

   protected function validateRequest(Request $request, $type, $id = null)
   {
       if ($type === 'customer') {
           return $request->validate([
               'name' => 'required|string|max:255',
               'email' => 'required|email|unique:customers,email,'.$id,
               'phone' => 'nullable|string|max:20',
               'address' => 'nullable|string|max:500',
           ]);
       }

       return $request->validate([
           'customer_id' => 'required|exists:customers,id',
           'date' => 'required|date',
           'amount' => 'required|numeric|min:0',
           'status' => 'required|in:unpaid,paid,cancelled',
       ]);
   }

   public function dataIndex(Request $request, $type)
{
    if (!in_array($type, ['customer', 'invoice'])) {
        abort(404, 'Invalid data type requested');
    }

    if ($request->ajax()) {
        if ($type === 'customer') {
            $query = Customer::select(['id', 'name', 'email', 'phone', 'created_at']);
            
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function($customer) {
                    return '
                        <a href="'.route('admin.edit', ['type' => 'customer', 'id' => $customer->id]).'" 
                           class="btn btn-sm btn-primary">Edit</a>
                        <button class="btn btn-sm btn-danger delete-btn" 
                                data-id="'.$customer->id.'" 
                                data-type="customer">Delete</button>
                    ';
                })
                ->editColumn('created_at', function($customer) {
                    return $customer->created_at->format('Y-m-d');
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            $query = Invoice::with(['customer:id,name'])
                ->select(['id', 'customer_id', 'date', 'amount', 'status']);
            
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('customer_name', function($invoice) {
                    return $invoice->customer->name;
                })
                ->addColumn('action', function($invoice) {
                    return '
                        <a href="'.route('admin.edit', ['type' => 'invoice', 'id' => $invoice->id]).'" 
                           class="btn btn-sm btn-primary">Edit</a>
                        <button class="btn btn-sm btn-danger delete-btn" 
                                data-id="'.$invoice->id.'" 
                                data-type="invoice">Delete</button>
                    ';
                })
                ->editColumn('amount', function($invoice) {
                    return '$'.number_format($invoice->amount, 2);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    return view('admin.lists.index', compact('type'));
}


    public function edit($type, $id)
    {
        if (!in_array($type, ['customer', 'invoice'])) {
            abort(404);
        }

        $model = $type === 'customer' 
            ? Customer::findOrFail($id)
            : Invoice::with('customer')->findOrFail($id);

        $customers = $type === 'invoice' ? Customer::all() : null;

        return view('admin.forms.edit', compact('type', 'model', 'customers'));
    }

    public function update(Request $request, $type, $id)
    {
        $validated = $this->validateRequest($request, $type, $id);

        if ($type === 'customer') {
            $customer = Customer::findOrFail($id);
            $customer->update($validated);
            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer updated successfully');
        } else {
            $invoice = Invoice::findOrFail($id);
            $invoice->update($validated);
            return redirect()->route('admin.invoices.index')
                ->with('success', 'Invoice updated successfully');
        }
    }

    public function destroy($type, $id)
    {
        if ($type === 'customer') {
            $customer = Customer::findOrFail($id);
            $customer->delete();
            return response()->json(['success' => 'Customer deleted successfully']);
        } else {
            $invoice = Invoice::findOrFail($id);
            $invoice->delete();
            return response()->json(['success' => 'Invoice deleted successfully']);
        }
    }

}
