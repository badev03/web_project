<?php

namespace App\Traits;


use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

trait AjaxTrait
{


    public function getDataAjax(Request $request, $modelName)
    {


        if ($request->ajax()) {
            $model = '\\App\\Models\\' . $modelName;
            $data = $model::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<ul> 
                <li>
                <a href="'.route('order.orderDetail', $row->id).'">
                        <i class="ri-eye-line"></i>
                    </a>
                </li>';
                    $btn .= '<li>
                <a href="javascript:void(0)" data-id="' . $row->id . '">
                    <i class="ri-pencil-line"></i>
                </a>
            </li>';

                    $btn .= '<li>
                <a href="javascript:void(0)" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">
                    <i class="ri-delete-bin-line"></i>
                </a>
            </li>';

                    $btn .= '<li>
                <a class="btn btn-sm btn-solid text-white" href="order-tracking.html">
                    Tracking
                </a>
            </li>';
                    $btn .= '</ul>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function getDataDetail(Request $request, $modelName)
    {
        if($request->ajax()){
            $model='\\App\\Models\\'. $modelName;
            $data =$model::find($request->id);
            return response()->json($data);
        }
      
        


    }
}
