<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerLog;
use App\Models\ExchageDayLimit;
use App\Models\Invoice;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\StockTransfer;
use App\Models\TransferredProduct;
use App\Models\Order;
use App\Models\Vat;
use Carbon\Carbon;
use PDF;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\NumberToWords;

class InvoiceController extends Controller
{
    public function all_sell_invoice()
    {
        return view('admin.sales.ManageAllInvoice');
    }


    //Branch and date wise filter
    public function filter(Request $request)
    {
        
        $allInvoice = Order::with('customer','orderdetails')
                    ->where('ordertype','Product')
                    ->where('sales_status','1')
                    ->where('branch_id', auth()->user()->branch_id)->get();

        return Datatables::of($allInvoice)
            ->addIndexColumn()
            ->editColumn('customer_id', function ($invoice) {
                return $invoice->customer->name ?? 'N/A';
            })
            ->addColumn('total', function ($invoice) {
                $total = number_format($invoice->net_total, 2);
                return $total ?? 'N/A';
            })
            ->addColumn('created_at', function ($invoice) {
                return "<span data-title='" . Carbon::parse($invoice->created_at)->format('h:m A') . "'>" . Carbon::parse($invoice->created_at)->format('d M Y') . "</span>";
            })
            ->addColumn('action', function ($invoice) {
                $btn = '<div class="table-actions text-right">';

                    // $btn = '<a href="' . route('admin.sales.return', $invoice->id) . '" class="btn btn-info btn-xs ms-1">
                    //             <i class="fa fa-undo" aria-hidden="true"></i><span title="Return">Return</span>
                    //         </a>';

                    $btn .= '<a href="' . route('admin.sales.edit', $invoice->id) . '" class="btn btn-warning btn-xs ms-1">
                        <i class="fa fa-pencil" aria-hidden="true"></i><span title="Edit">Edit</span>
                    </a>';

                    $btn .= '<a href="' . route('customer.invoice.print', $invoice->id) . '" class="btn btn-success btn-xs print-window" target="_blank">
                        <span title="Print Invoice">Print</span>
                    </a>';

                    $btn .= '<a href="' . route('customer.invoice.bgprint', $invoice->id) . '" class="btn btn-success btn-xs print-window" target="_blank">
                        <span title="Print Invoice">Print BG</span>
                    </a>';

                
                    $btn .= '<button type="button" class="btn btn-primary btn-xs view-btn" data-toggle="modal" data-target="#product-details" value="' . $invoice->id . '">
                        <i class="fa fa-eye" aria-hidden="true"></i> View
                    </button>';
                
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['created_at', 'action'])
            ->make(true);
    }

    public function get_invoice(Request $request)
    {
        $details = Order::with(['customer','orderdetails' => function ($query) {
            $query->with('product');
        }])->find($request->id);
        return $details;
    }

    //downloads customer invoice
    public function customer_invoice_download($id)
    {
        $order = Order::findOrFail($id);
        $customerdtl = Customer::where('id','=',$order->customer_id)->first();
        $pdf = PDF::loadView('invoices.customer_invoice', compact('order','customerdtl'));
        // dd($order->invoiceno );
        return $pdf->download('order-'.$order->invoiceno.'.pdf');
    }

    //downloads customer invoice
    public function customer_invoice_print($id)
    {
        
        $order = Order::with('serviceAdditionalProduct','serviceRequest')->where('id',$id)->first();$totalAdditionalProduct = $order->serviceAdditionalProduct?->sum('total_selling_price') ?? 0;
        $amountInWords = NumberToWords::convert($order->grand_total + $totalAdditionalProduct);

        $customerdtl = Customer::where('id','=',$order->customer_id)->first();
        $pdf = PDF::loadView('invoices.print_invoice', compact('order','customerdtl','amountInWords'));

        $output = $pdf->output();
        return view('invoices.print_invoice', compact('order','customerdtl','amountInWords'));
        
    }

    public function customer_invoice_print_bg($id)
    {
        $order = Order::with('serviceAdditionalProduct')->where('id',$id)->first();
        
        $totalAdditionalProduct = $order->serviceAdditionalProduct?->sum('total_selling_price') ?? 0;
        $amountInWords = NumberToWords::convert($order->grand_total + $totalAdditionalProduct);

        $customerdtl = Customer::where('id','=',$order->customer_id)->first();
        // $pdf = PDF::loadView('invoices.print_invoice_bg', compact('order','customerdtl','amountInWords'));

        // $output = $pdf->output();
        return view('invoices.print_invoice_bg', compact('order','customerdtl','amountInWords'));
        
    }
}
