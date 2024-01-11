<?php

namespace App\Http\Controllers\Client;

use Auth;
use Exception;
use App\Models\User;
use App\Models\Order;
use App\Models\Variant;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\Attribute_value;
use App\Http\Controllers\Controller;
use Kjmtrue\VietnamZone\Models\Ward;
use Kjmtrue\VietnamZone\Models\District;
use Kjmtrue\VietnamZone\Models\Province;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    private function calculateTotalPrice($cart)
    {
        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalPrice += $item['quantity'] * $item['sale_price'];
        }

        return $totalPrice;
    }
    public function getProvinces()
    {
        $provinces = Province::select('id', 'name', 'gso_id')->get();


        return response()->json([
            'provinces' => $provinces,
        ], 200);
    }
    public function getDistricts($id)
    {
        $districts = Province::findOrFail($id)->districts;
        return response()->json([
            'districts' => $districts,
        ], 200);
    }
    public function getWards($id)
    {
        $wards = District::findOrFail($id)->wards;
        return response()->json([
            'wards' => $wards,
        ], 200);
    }
    public function getLocationName($province, $district)
    {

        $provinceName = Province::where('id', $province)->first()->name;
        $districtName = District::where('province_id', $province)->first()->name;
        $wardName = Ward::where('district_id', $district)->first()->name;
        if ($provinceName !== null && $districtName !== null && $wardName !== null) {
            return $wardName . ',' . $districtName . ',' . $provinceName;
        } else {
            return [
                'error' => 'Không tìm thấy địa chỉ',
            ];
        }
    }
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        if (!$cart) {
            return redirect()->route('cart');
        }

        $totalPrice = $this->calculateTotalPrice($cart);

        $data = [
            'name' => '',
            'phone' => '',
            'address' => '',
            'email' => '',
        ];

        if (auth()->check() && auth()->user()->status == 1) {
            $user = auth()->user();
            $data = [
                'name' => $user->name,
                'user_id' => $user->id,
                'phone' => $user->phone,
                'address' => $user->address,
                'email' => $user->email,
            ];
            // tách địa chỉ sau đó tìm id của địa chỉ đó để hiển thị ra  view
            $addressParts = explode(",", $data['address']);
            $addressParts = array_map('trim', $addressParts);
            $data['province'] = $addressParts[3];
            $province = Province::where('name', $data['province'])->first()->id;
            $data['district'] = $addressParts[2];
            $district = District::where('name', $data['district'])->first()->id;
            $data['ward'] = $addressParts[1];
            $ward = Ward::where('name', $data['ward'])->first()->id;
            $data['number_add'] = $addressParts[0];
            return view('clients.page.checkout', compact('cart', 'totalPrice', 'data', 'province', 'district', 'ward'));
        } else {
            return view('clients.page.checkout', compact('cart', 'totalPrice', 'data'));
        }
    }

    public function getCurrentUser(Request $request)
    {
        if (!auth()->check()) {
            $createAccount = $request->has('create_account');
            return $this->createUser($request, $createAccount ? 1 : 0);
        } else {
            return auth()->user();
        }
    }
    public function checkoutStore(Request $request)
    {
        $validation = $this->validateCheckOut($request);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        $user = $this->getCurrentUser($request);
        $this->createOder($user, $request);
    }

    public function Vnpay(Request $request)
    {
        try {
            // Validate the checkout request
            $validation = $this->validateCheckOut($request);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            // Retrieve cart information
            $cart = session()->get('cart');
            $totalPrice = $this->calculateTotalPrice($cart);

            // VNPAY configuration
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = route('vnpay.Return');
            $vnp_TmnCode = "5LOH0J1T"; // Replace with your VNPAY merchant code
            $vnp_HashSecret = "JGQBWAPMQEYCJWJWLBXZKOQDCAZAFMIC"; // Replace with your VNPAY hash secret
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $totalPrice * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

         



            // Prepare VNPAY input data
            $vnp_OrderInfo = $order->toJson();
            $vnp_TxnRef = $order->order_code;

            $inputData = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            ];

            // Include optional parameters
            if (!empty($vnp_BankCode)) {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);

            // Generate the VNPAY URL with secure hash
            $query = http_build_query($inputData, '', '&');
            $hashdata = strtoupper(hash_hmac('sha512', $query, $vnp_HashSecret));

            $vnp_Url = $vnp_Url . "?" . $query . '&vnp_SecureHash=' . $hashdata;

            // Redirect or return JSON response
            if (isset($_POST['redirect'])) {
                return redirect()->away($vnp_Url);
            } else {
                return response()->json(['code' => '00', 'message' => 'success', 'data' => $vnp_Url]);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function vnpayReturn(Request $request)
    {
        try {
            if ($request->vnp_ResponseCode == '00' && $request->vnp_TransactionStatus == '00') {
                $order = Order::where('order_code', $request->vnp_TxnRef)->first();

                if ($order) {
                    $order->update(['status' => 2]);
                    return redirect()->route('homes')->with('success', 'Đặt hàng thành công');
                }
            }

            return 'toang';
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createOrder($user, $request, $status = 0)
    {
        // tạo đơn hàng
        $cart = session()->get('cart');

        $totalPrice = $this->calculateTotalPrice($cart);
        $oder =  $user->orders()->create([
            'order_code' => 'DH' . rand(100000, 999999),
            'total_amount' => $totalPrice,
            'payment_method' => $request->payment_method,
            'status' => $status,
            'note' => $request->note,
        ]);
        if ($oder) {
            // tạo chi tiết đơn hàng
            foreach ($cart as $item) {
                $oder->orderDetails()->create([
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'attribute' => $item['attribute'],
                ]);
                // update lại số lượng sản phẩm trong bảng variant
                $attribute = Attribute_value::where('value', $item['attribute'])->first()->id;
                $variant = Variant::where('product_id', $item['id'])->where('attribute_value_id', $attribute)->first();
                $variant->quantity = $variant->quantity - $item['quantity'];
                $variant->save();
            }
        }
        session()->forget('cart');
        // // xóa giỏ hàng
    }


    public function createUser(Request $request, $status = 1)
    {
        // kiểm tra email đã tồn tại chưa
        $checkEmail = User::where('email', $request->email)->first();
        if ($checkEmail) {
            // hiển thị thông báo lỗi
            return redirect()->back()->with('error', 'Email đã tồn tại');
        }

        // tạo mật khẩu ngẫu nhiên 8 ký tự
        $password = $request->has('create_account') ? $request->password : rand(10000000, 99999999);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' =>  $request->number_add . ',' . $this->getLocationName($request->province, $request->district),
            'password' => bcrypt($password),
            'role' => 1,
            'status' => $status,
        ];
        $user = User::create($data);

        return $user;
    }



    public function validateCheckOut(Request $request)
    {

        return Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|numeric|min:10|unique:users,phone,' . auth()->id(),
            'number_add' => 'required',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'email' => 'email',
        ], [
            'name.required' => 'Vui lòng nhập họ tên',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.numeric' => 'Số điện thoại phải là số',
            'phone.unique' => 'Số điện thoại đã tồn tại',

            'phone.min' => 'Số điện thoại phải có ít nhất 10 số',
            'number_add.required' => 'Vui lòng nhập địa chỉ',
            'province.required' => 'Vui lòng chọn tỉnh/thành phố',
            'district.required' => 'Vui lòng chọn quận/huyện',
            'ward.required' => 'Vui lòng chọn xã/phường',

            'email.email' => 'Email không đúng định dạng',
        ]);
    }
}
