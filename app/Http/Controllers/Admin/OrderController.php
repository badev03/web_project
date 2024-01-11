<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Traits\AjaxTrait;
class OrderController extends Controller
{
    use AjaxTrait;
    public function index()
    {
        return view('back-end.page.order.index');
    }

    public function getData(Request $request)
    {
        return $this->getDataAjax($request, 'Order');
    }
    public function orderDetail(Request $request, $id){
        $detail = Order::with('orderDetails')->find($id);
     
        return view('back-end.page.order.order-detail',compact('detail'));
    }
   
    

}
