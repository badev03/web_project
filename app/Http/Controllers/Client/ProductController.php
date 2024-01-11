<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Models\Product;

use App\Traits\ProductTrait;
use Illuminate\Http\Request;
use App\Models\Attribute_value;

use function Laravel\Prompts\alert;
use App\Http\Controllers\Controller;

use Kjmtrue\VietnamZone\Models\Ward;
use Kjmtrue\VietnamZone\Models\District;
use Kjmtrue\VietnamZone\Models\Province;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ProductTrait;


    public function productDetail($slug)
    {
        $productDetail = $this->detail($slug);
        $variants = $productDetail->variants;

        // Lấy mảng các attribute_value_id từ tất cả các biến thể
        $attributeValueIds = $variants->pluck('attribute_value_id')->toArray();

        // Lấy thông tin về thuộc tính và giá trị thuộc tính dựa trên các attribute_value_id
        $attributes = Attribute_value::with('attribute')->whereIn('id', $attributeValueIds)->get();

        // Hiển thị tất cả dữ liệu trước khi trang web kết thúc

        return view('clients.page.product-detail', compact('productDetail', 'attributes', 'variants'));
    }
    public function cart()
    {
        $cart = session()->get('cart');


        return view('clients.page.cart.cart', compact('cart'));
    }

    public function validateCart(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'variant' => 'required',
            'attribute' => 'required',
            'quantity' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) use ($id, $request) {
                    $product = $this->checkProductExists($id);
                    $this->checkProductStatus($product);
                    $this->checkVariantQuantity($value, $request, $product);
                },
            ],
        ]);

        return $validator;
    }

    private function checkProductExists($id)
    {
        $product = Product::find($id);

        if (!$product) {
            throw new \Exception('Sản phẩm không tồn tại trong cơ sở dữ liệu.');
        }

        return $product;
    }

    private function checkProductStatus($product)
    {
        if (!$product->status) {
            throw new \Exception('Sản phẩm đã ngừng kinh doanh');
        }
    }

    private function checkVariantQuantity($value, $request, $product)
    {
        $variant = $product->variants
            ->where('attribute_value_id', $request->attribute)
            ->first();

        if ($value > $variant->quantity) {
            throw new \Exception('Trong kho chỉ có ' . $variant->quantity . ' sản phẩm');
        }
    }
    public function addToCart(Request $request, $id)
    {
        $validation = $this->validateCart($request, $id);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'error',
                'errors' => $validation->errors(),
            ], 422);
        }

        $product = Product::findOrFail($id);
        $quantity = $request->quantity;
        $variant = $request->variant;
        $attributeId = $request->attribute;
        $attribute = Attribute_value::find($request->attribute)->value;
        $cart = session()->get('cart', []);

        $found = $this->checkCartForProduct($cart, $id, $variant, $attribute, $quantity, $product, $request, $attributeId);

        if (!$found) {
            $this->addToCartIfNotFound($cart, $id, $product, $quantity, $attribute, $variant);
        }



        session()->put('cart', $cart);

        $miniCartHtml = view('clients.layouts.cart-mini', compact('cart'))->render();
        // tính tổng tiền của giỏ hàng lưu vào session cart

        return response()->json([
            'message' => 'success',
            'cart' => $cart,

            'miniCartHtml' => $miniCartHtml,
        ], 200);
    }

    private function checkCartForProduct(&$cart, $id, $variant, $attribute, $quantity, $product, $request, $attributeId)
    {
        foreach ($cart as $key => $value) {
            if ($value['variant'] == $variant && $value['attribute'] == $attribute && $value['id'] == $id) {
                $cart[$key]['quantity'] += $quantity;
                if ($cart[$key]['quantity'] > $product->variants()->where('attribute_value_id', $attributeId)->first()->quantity) {
                    throw new \Exception('Trong kho chỉ có ' . $product->variants()->where('attribute_value_id', $request->attribute)->first()->quantity . ' sản phẩm');
                } else {
                    return true;
                }
            }
        }

        return false;
    }

    private function addToCartIfNotFound(&$cart, $id, $product, $quantity, $attribute, $variant)
    {
        $cart[] = [
            'id' => $id,
            'name' => $product->name,
            'slug' => $product->slug,
            'quantity' => $quantity,
            'sale_price' => $product->sale_price,
            'attribute' => $attribute,
            'variant' => $variant,
            'image' => $product->image,
        ];
    }
    public function remove(Request $request)
    {
        if ($request->variant) {
            $cart = session()->get('cart');
            foreach ($cart as $id => $cartItem) {
                if ($cartItem['variant'] === $request->variant) {
                    unset($cart[$id]);
                    break; // Dừng vòng lặp sau khi xóa sản phẩm
                }
            }
            session()->put('cart', $cart);
            $miniCartHtml = view('clients.layouts.cart-mini', compact('cart'))->render();

            session()->flash('success', 'Product removed successfully');
            return response()->json([
                'message' => 'success',
                'cart' => $cart,
                'miniCartHtml' => $miniCartHtml,
            ], 200);
        }
    }

    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart');

        if ($request->has('quantity') && $request->has('variant') && $request->has('attribute')) {
            $quantity = $request->quantity;
            $variant = $request->variant;
            $attributeId = attribute_value::where('value', $request->attribute)->first()->id;
            $attribute = $request->attribute;
            $product = Product::findOrFail($id);

            foreach ($cart as $key => $value) {
                if ($value['variant'] == $variant && $value['attribute'] == $attribute && $value['id'] == $id) {
                    $cart[$key]['quantity'] = $quantity;

                    $variant = $product->variants
                        ->where('attribute_value_id', $attributeId)
                        ->first();


                    if ($quantity > $variant->quantity) {
                        return response()->json([
                            'message' => 'error',
                            'errors' => ['quantity' => ' Sản phẩm ' . $value['name'] . '(' . $value['attribute'] . ') trong kho chỉ có ' . $variant->quantity . ' sản phẩm'],
                        ], 422);
                    } else {

                        $totalPrice = $this->calculateTotalPrice($cart);
                        session()->put('cart', $cart);
                        $miniCartHtml = view('clients.layouts.cart-mini', compact('cart'))->render();

                        return response()->json([
                            'message' => 'success',
                            'cart' => $cart,
                            'totalPrice' => $totalPrice,
                            'miniCartHtml' => $miniCartHtml,

                        ], 200);
                    }
                }
            }
        }
    }

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

        }else{
            return view('clients.page.checkout', compact('cart', 'totalPrice', 'data'));
        }

    }
    public function checkoutStore(Request $request)
    {
        $validation = $this->validateCheckOut($request);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        // nếu ấn nút tạo tài khoản thì cho nhập mk rồi tạo
        if($request->has('create_account')){
            $user = $this->createUser($request);
            auth()->login($user);
        }else{
        // ngược lại thì tạo tài khoản với status =0
            $user = $this->createUser($request,0);

        }


        $cart = session()->get('cart');
        // $totalPrice = $this->calculateTotalPrice($cart);



        // $data['total_price'] = $totalPrice;
        // $data['status'] = 0;
        // $data['user_id'] = auth()->user()->id;
        // $data['note'] = $request->note;
        // $data['payment_method'] = $request->payment_method;

        // $data['order_code'] = 'DH' . time();
        // $order = auth()->user()->orders()->create($data);
        // foreach ($cart as $item) {
        //     $order->products()->attach($item['id'], [
        //         'quantity' => $item['quantity'],
        //         'price' => $item['sale_price'],
        //         'attribute_value_id' => $item['variant'],
        //     ]);
        // }
        session()->forget('cart');
        return redirect()->route('checkout');
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
            'address' => $request->number_add . ',' . $request->ward . ',' . $request->district . ',' . $request->province,
            'password' => bcrypt($password),
            'role' => 1,
            'status' => $status,
        ];
        $user = User::create($data);
    
        return $user;
    }
    
    public function Vnpay(){
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "https://localhost/vnpay_php/vnpay_return.php";
$vnp_TmnCode = "";//Mã website tại VNPAY 
$vnp_HashSecret = ""; //Chuỗi bí mật

$vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
$vnp_OrderInfo = $_POST['order_desc'];
$vnp_OrderType = $_POST['order_type'];
$vnp_Amount = $_POST['amount'] * 100;
$vnp_Locale = $_POST['language'];
$vnp_BankCode = $_POST['bank_code'];
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
//Add Params of 2.0.1 Version
$vnp_ExpireDate = $_POST['txtexpire'];
//Billing
$vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
$vnp_Bill_Email = $_POST['txt_billing_email'];
$fullName = trim($_POST['txt_billing_fullname']);
if (isset($fullName) && trim($fullName) != '') {
    $name = explode(' ', $fullName);
    $vnp_Bill_FirstName = array_shift($name);
    $vnp_Bill_LastName = array_pop($name);
}
$vnp_Bill_Address=$_POST['txt_inv_addr1'];
$vnp_Bill_City=$_POST['txt_bill_city'];
$vnp_Bill_Country=$_POST['txt_bill_country'];
$vnp_Bill_State=$_POST['txt_bill_state'];
// Invoice
$vnp_Inv_Phone=$_POST['txt_inv_mobile'];
$vnp_Inv_Email=$_POST['txt_inv_email'];
$vnp_Inv_Customer=$_POST['txt_inv_customer'];
$vnp_Inv_Address=$_POST['txt_inv_addr1'];
$vnp_Inv_Company=$_POST['txt_inv_company'];
$vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
$vnp_Inv_Type=$_POST['cbo_inv_type'];
$inputData = array(
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
    "vnp_ExpireDate"=>$vnp_ExpireDate,
    "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
    "vnp_Bill_Email"=>$vnp_Bill_Email,
    "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
    "vnp_Bill_LastName"=>$vnp_Bill_LastName,
    "vnp_Bill_Address"=>$vnp_Bill_Address,
    "vnp_Bill_City"=>$vnp_Bill_City,
    "vnp_Bill_Country"=>$vnp_Bill_Country,
    "vnp_Inv_Phone"=>$vnp_Inv_Phone,
    "vnp_Inv_Email"=>$vnp_Inv_Email,
    "vnp_Inv_Customer"=>$vnp_Inv_Customer,
    "vnp_Inv_Address"=>$vnp_Inv_Address,
    "vnp_Inv_Company"=>$vnp_Inv_Company,
    "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
    "vnp_Inv_Type"=>$vnp_Inv_Type
);

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}
if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
    $inputData['vnp_Bill_State'] = $vnp_Bill_State;
}

//var_dump($inputData);
ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
}
$returnData = array('code' => '00'
    , 'message' => 'success'
    , 'data' => $vnp_Url);
    if (isset($_POST['redirect'])) {
        header('Location: ' . $vnp_Url);
        die();
    } else {
        echo json_encode($returnData);
    }
    }
   
    

    public function validateCheckOut(Request $request)
    {

        return Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|numeric|min:10',
            'number_add' => 'required',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'email' => 'email',
        ], [
            'name.required' => 'Vui lòng nhập họ tên',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.numeric' => 'Số điện thoại phải là số',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 số',
            'number_add.required' => 'Vui lòng nhập địa chỉ',
            'province.required' => 'Vui lòng chọn tỉnh/thành phố',
            'district.required' => 'Vui lòng chọn quận/huyện',
            'ward.required' => 'Vui lòng chọn xã/phường',

            'email.email' => 'Email không đúng định dạng',
        ]);
    }


    // hiển thị thông baos lỗi khi quá số lượng 
    // cập nhật cả trên giỏ hàngg

    // public function validateCart(Request $request, $id)
    // {
    //     return Validator::make($request->all(), [
    //         'variant' => 'required',
    //         'attribute' => 'required',
    //         'quantity' => [
    //             'required',
    //             'numeric',
    //             'min:1',
    //             function ($attribute, $value, $fail) use ($id, $request) {
    //                 $product = Product::find($id);

    //                 if (!$product) {
    //                     $fail('Sản phẩm không tồn tại trong cơ sở dữ liệu.');
    //                     return;
    //                 }

    //                 if (!$product->status) {
    //                     $fail('Sản phẩm đã ngừng kinh doanh');
    //                     return;
    //                 }

    //                 $variant = $product->variants
    //                     ->where('attribute_value_id', $request->attribute)
    //                     ->first();



    //                 if ($value > $variant->quantity) {
    //                     $fail('Trong kho chỉ có ' . $product->variants()->where('attribute_value_id', $request->attribute)->first()->quantity . ' sản phẩm');
    //                     return;
    //                 }
    //             },
    //         ],
    //     ]);
    // }

    // public function addToCart(Request $request, $id)
    // {

    //     $validation = $this->validateCart($request, $id);
    //     if ($validation->fails()) {
    //         return response()->json([
    //             'message' => 'error',
    //             'errors' => $validation->errors(),
    //         ], 422);
    //     }
    //     $product = Product::findOrFail($id);
    //     $quantity = $request->quantity;
    //     $price = $product->sale_price;
    //     $variant = $request->variant;
    //     $attribute = Attribute_value::find($request->attribute)->value;

    //     $cart = session()->get('cart', []);

    //     $found = false;
    //     foreach ($cart as $key => $value) {
    //         if ($value['variant'] == $variant && $value['attribute'] == $attribute && $value['id'] == $id) {
    //             $cart[$key]['quantity'] += $quantity;
    //             if ($cart[$key]['quantity'] > $product->variants()->where('attribute_value_id', $request->attribute)->first()->quantity) {
    //                 return response()->json([
    //                     'message' => 'error',
    //                     'errors' => ['quantity' => 'Trong kho chỉ có ' . $product->variants()->where('attribute_value_id', $request->attribute)->first()->quantity . ' sản phẩm'],
    //                 ], 422);
    //             } else {
    //                 $found = true;
    //                 break;
    //             }
    //         }
    //     }

    //     if (!$found) {
    //         $cart[] = [
    //             'id' => $id,
    //             'name' => $product->name,
    //             'quantity' => $quantity,
    //             'sale_price' => $price,
    //             'attribute' =>  $attribute,
    //             'variant' => $variant,
    //             'image' => $product->image,
    //         ];
    //     }


    //     session()->put('cart', $cart);

    //     $miniCartHtml = view('clients.layouts.cart', compact('cart'))->render();

    //     return response()->json([
    //         'message' => 'success',
    //         'cart' => $cart,
    //         'miniCartHtml' => $miniCartHtml,
    //     ], 200);
    // }

}
