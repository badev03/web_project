<?php

namespace App\Traits;

use Illuminate\Http\Request;


const STATUS = 2;

trait AdminTrait
{

    public function status( $id, $model)
    {
      
        $model = $model::find($id);
        if (!$model) {
            return response()->json(['error' => 'Không tìm thấy dữ liệu']);
        }
        $model->status = STATUS;
        $model->save();
        return ['success' => 'Cập nhật trạng thái thành công'];
    }
}
