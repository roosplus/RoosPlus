<?php

namespace App\Helpers;

use App\Models\Item;
use App\Models\Settings;
use App\Models\User;
use App\Models\Timing;
use App\Models\Order;
use App\Models\Variants;
use App\Models\OrderDetails;
use App\Models\Transaction;
use App\Models\CustomStatus;
use App\Models\Payment;
use Session;
use App\Models\PricingPlan;
use App\Models\SocialLinks;
use App\Models\SystemAddons;
use App\Models\RoleAccess;
use App\Models\RoleManager;
use App\Models\TopDeals;
use App\Models\Cart;
use App\Models\Tax;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\Languages;
use App\Models\StoreCategory;
use Illuminate\Support\Str;
use App;
use App\Models\City;
use App\Models\Pixcel;
use App\Models\AppSettings;
use Config;
use App\Helpers\loyaltyhelper;
use App\Models\AgeVerification;
use App\Models\Footerfeatures;
use App\Models\OtherSettings;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use File;

class helper
{
    public static function appdata($vendor_id)
    {
        if (file_exists(storage_path('installed'))) {
            $host = $_SERVER['HTTP_HOST'];
            if ($host  ==  env('WEBSITE_HOST')) {
                $data = Settings::first();
                if (!empty($vendor_id)) {
                    $data = Settings::where('vendor_id', $vendor_id)->first();
                }
            }
            // if the current host doesn't contain the website domain (meaning, custom domain)
            else {
                $data = Settings::where('custom_domain', $host)->first();
            }
            return $data;
        } else {
            return redirect('install');
            exit;
        }
    }
    public static function otherappdata($vendor_id)
    {
        $data = OtherSettings::where('vendor_id', $vendor_id)->first();
        return $data;
    }

    // front
    public static function vendordata($id)
    {
        $data = User::where('id', $id)->where('is_available', 1)->where('is_deleted', 2)->first();
        return $data;
    }

    public static function image_path($image)
    {
        if ($image == "" && $image == null) {
            $path = asset('storage/app/public/admin-assets/images/about/defaultimages/item-placeholder.png');
        } else {
            $path = asset('storage/app/public/admin-assets/images/about/defaultimages/item-placeholder.png');
        }

        if (Str::contains($image, 'nodata')) {
            if (file_exists(storage_path('app/public/admin-assets/images/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/' . $image);
            }
        }
        if (Str::contains($image, 'authformbgimage') || Str::contains($image, 'quick-call')) {
            if (file_exists(storage_path('app/public/admin-assets/images/about/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/about/' . $image);
            }
        }
        if (Str::contains($image, 'theme-')) {
            if (file_exists(storage_path('app/public/admin-assets/images/theme/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/theme/' . $image);
            }
        }
        if (Str::contains($image, 'work-')) {
            if (file_exists(storage_path('app/public/landing/images/png/' . $image))) {
                $path = asset('storage/app/public/landing/images/png/' . $image);
            }
        }
        if (Str::contains($image, 'feature-')) {
            if (file_exists(storage_path('app/public/admin-assets/images/feature/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/feature/' . $image);
            }
        }
        if (Str::contains($image, 'testimonial-')) {
            if (file_exists(storage_path('app/public/admin-assets/images/testimonials/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/testimonials/' . $image);
            }
        }
        if (Str::contains($image, 'screenshot-')) {
            if (file_exists(storage_path('app/public/admin-assets/images/screenshot/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/screenshot/' . $image);
            }
        }
        if (Str::contains($image, 'banktransfer') || Str::contains($image, 'cod') || Str::contains($image, 'razorpay') || Str::contains($image, 'stripe') || Str::contains($image, 'wallet') || Str::contains($image, 'flutterwave') || Str::contains($image, 'paystack') || Str::contains($image, 'mercadopago') || Str::contains($image, 'paypal') || Str::contains($image, 'myfatoorah') || Str::contains($image, 'toyyibpay') || Str::contains($image, 'phonepe') || Str::contains($image, 'payment') || Str::contains($image, 'paytab') || Str::contains($image, 'mollie') || Str::contains($image, 'khalti') || Str::contains($image, 'xendit')) {
            if (file_exists(storage_path('app/public/admin-assets/images/about/payment/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/about/payment/' . $image);
            }
        }
        if (Str::contains($image, 'trusted_badge')) {
            if (file_exists(storage_path('app/public/admin-assets/images/about/trusted_badge/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/about/trusted_badge/' . $image);
            }
        }
        if (Str::contains($image, 'res')) {
            if (file_exists(storage_path('app/public/admin-assets/images/about/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/about/' . $image);
            }
        }

        if (Str::contains($image, 'logo')) {
            if (file_exists(storage_path('app/public/admin-assets/images/about/logo/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/about/logo/' . $image);
            }
            if (file_exists(storage_path('app/public/admin-assets/images/about/defaultimages/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/about/defaultimages/' . $image);
            }
        }

        if (Str::contains($image, 'favicon')) {
            if (file_exists(storage_path('app/public/admin-assets/images/about/favicon/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/about/favicon/' . $image);
            }
            if (file_exists(storage_path('app/public/admin-assets/images/about/defaultimages/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/about/defaultimages/' . $image);
            }
        }
        if (Str::contains($image, 'og_image')) {
            if (file_exists(storage_path('app/public/admin-assets/images/about/og_image/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/about/og_image/' . $image);
            }
            if (file_exists(storage_path('app/public/admin-assets/images/about/defaultimages/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/about/defaultimages/' . $image);
            }
        }
        if (Str::contains($image, 'item-')) {
            if (file_exists(storage_path('app/public/item/' . $image))) {
                $path = asset('storage/app/public/item/' . $image);
            }
        }
        if (Str::contains($image, 'banner') || Str::contains($image, 'promotion-')) {
            if (file_exists(storage_path('app/public/admin-assets/images/banners/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/banners/' . $image);
            }
        }
        if (Str::contains($image, 'order')) {
            if (file_exists(storage_path('app/public/front/images/' . $image))) {
                $path = asset('storage/app/public/front/images/' . $image);
            }
        }
        if (Str::contains($image, 'profile')) {
            if (file_exists(storage_path('app/public/admin-assets/images/profile/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/profile/' . $image);
            }
        }
        if (Str::contains($image, 'category')) {
            if (file_exists(storage_path('app/public/admin-assets/images/category/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/category/' . $image);
            }
        }
        if (Str::contains($image, 'blog')) {
            if (file_exists(storage_path('app/public/admin-assets/images/blog/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/blog/' . $image);
            }
        }
        if (Str::contains($image, 'flag')) {
            if (file_exists(storage_path('app/public/admin-assets/images/language/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/language/' . $image);
            }
        }
        if (Str::contains($image, 'cover')) {
            if (file_exists(storage_path('app/public/admin-assets/images/coverimage/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/coverimage/' . $image);
            }
        }
        if (Str::contains($image, 'subscribe_bg')) {
            if (file_exists(storage_path('app/public/admin-assets/images/subscribe/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/subscribe/' . $image);
            }
        }
        if (Str::contains($image, 'maintenance') || Str::contains($image, 'store_unavailable') || Str::contains($image, 'auth') || Str::contains($image, 'whoweare') || Str::contains($image, 'order_success') || Str::contains($image, 'no_data') || Str::contains($image, 'faq') || Str::contains($image, 'book_table')) {
            if (file_exists(storage_path('app/public/admin-assets/images/index/' . $image))) {
                $path = asset('storage/app/public/admin-assets/images/index/' . $image);
            }
        }
        return $path;
    }

    public static function currency_formate($price, $vendor_id)
    {
        if (helper::appdata($vendor_id)->currency_position == "left") {
            if (helper::appdata($vendor_id)->decimal_separator == 1) {
                if (helper::appdata($vendor_id)->currency_space == 1) {
                    return helper::appdata($vendor_id)->currency . ' ' . number_format((float)$price, helper::appdata($vendor_id)->currency_formate, '.', ',');
                } else {
                    return helper::appdata($vendor_id)->currency . number_format((float)$price, helper::appdata($vendor_id)->currency_formate, '.', ',');
                }
            } else {
                if (helper::appdata($vendor_id)->currency_space == 1) {
                    return helper::appdata($vendor_id)->currency . ' ' . number_format((float)$price, helper::appdata($vendor_id)->currency_formate, ',', '.');
                } else {
                    return helper::appdata($vendor_id)->currency . number_format((float)$price, helper::appdata($vendor_id)->currency_formate, ',', '.');
                }
            }
        }
        if (helper::appdata($vendor_id)->currency_position == "right") {
            if (helper::appdata($vendor_id)->decimal_separator == 1) {
                if (helper::appdata($vendor_id)->currency_space == 1) {
                    return number_format((float)$price, helper::appdata($vendor_id)->currency_formate, '.', ',') . ' ' . helper::appdata($vendor_id)->currency;
                } else {
                    return number_format((float)$price, helper::appdata($vendor_id)->currency_formate, '.', ',') . helper::appdata($vendor_id)->currency;
                }
            } else {
                if (helper::appdata($vendor_id)->currency_space == 1) {
                    return number_format((float)$price, helper::appdata($vendor_id)->currency_formate, ',', '.') . ' ' . helper::appdata($vendor_id)->currency;
                } else {
                    return number_format((float)$price, helper::appdata($vendor_id)->currency_formate, ',', '.') . helper::appdata($vendor_id)->currency;
                }
                return number_format((float)$price, helper::appdata($vendor_id)->currency_formate, ',', '.') . helper::appdata($vendor_id)->currency;
            }
        }
        return $price;
    }
    public static function vendortime($vendor)
    {
        date_default_timezone_set(@helper::appdata($vendor)->timezone);
        $t = date('d-m-Y');
        $time = Timing::select('close_time')->where('vendor_id', $vendor)->where('day', date("l", strtotime($t)))->first();
        $txt = "Opened until " . date("D", strtotime($t)) . " " . $time->close_time . "";
        return $txt;
    }
    public static function date_format($date, $vendor_id)
    {
        return date(helper::appdata($vendor_id)->date_format, strtotime($date));
    }
    public static function time_format($time, $vendor_id)
    {
        if (helper::appdata($vendor_id)->time_format == 1) {
            return $time->format('H:i');
        } else {
            return $time->format('h:i A');
        }
    }

    public static function get_city()
    {
        $city =  City::where('is_deleted', '2')->where('is_available', '1')->get();
        return $city;
    }

    public static function get_plan_exp_date($duration, $days)
    {
        date_default_timezone_set(@helper::appdata('')->timezone);
        $purchasedate = date("Y-m-d h:i:sa");
        $exdate = "";
        if (!empty($duration) && $duration != "") {
            if ($duration == "1") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 30 days'));
            }
            if ($duration == "2") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 90 days'));
            }
            if ($duration == "3") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 180 days'));
            }
            if ($duration == "4") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 365 days'));
            }
            if ($duration == "5") {
                $exdate = "";
            }
        }
        if (!empty($days) && $days != "") {
            $exdate = date('Y-m-d', strtotime($purchasedate . ' + ' . $days . 'days'));
        }
        return $exdate;
    }
    public static function timings($vendor)
    {
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vdata = $vendor;
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $storeinfo = Settings::where('custom_domain', $host)->first();
            $vdata = $storeinfo->vendor_id;
        }
        $timings = Timing::where('vendor_id', @$vdata)->get();
        return $timings;
    }
    public static function storeinfo($vendor)
    {
        $vendorinfo = User::where('slug', $vendor)->first();
        return $vendorinfo;
    }

    public static function getcartcount($vendor_id, $user_id)
    {
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vdata = $vendor_id;
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $storeinfo = Settings::where('custom_domain', $host)->first();
            $vdata = $storeinfo->vendor_id;
        }
        $session_id = Session::getId();

        if ($user_id != "" && Auth::user()->type == 3) {

            $cnt = Cart::where('vendor_id', $vdata)->where('user_id', $user_id)->where('buynow', 0)->count();
        } else {
            $cnt = Cart::where('vendor_id', $vdata)->where('session_id', $session_id)->where('buynow', 0)->count();
        }

        return $cnt;
    }


    public static function checkplan($id, $type)
    {
        $check = SystemAddons::where('unique_identifier', 'subscription')->first();

        if (@$check->activated != 1) {
            return response()->json(['status' => 1, 'message' => '', 'expdate' => "", 'showclick' => "0", 'plan_message' => '', 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
        }
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $data = Settings::where('vendor_id', $id)->first();
            date_default_timezone_set(@helper::appdata($data->vendor_id)->timezone);
            $vendorinfo = User::where('id', $id)->first();
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $storeinfo = Settings::where('custom_domain', $host)->first();
            date_default_timezone_set(helper::appdata($storeinfo->vendor_id)->timezone);
            $vendorinfo = User::where('id', $storeinfo->vendor_id)->first();
        }

        $checkplan = Transaction::where('plan_id', $vendorinfo->plan_id)->where('vendor_id', $vendorinfo->id)->where('transaction_type', null)->orderByDesc('id')->first();
        $totalservice = Item::where('vendor_id', $vendorinfo->id)->count();
        if ($vendorinfo->allow_without_subscription != 1) {
            if (!empty($checkplan)) {
                if ($vendorinfo->is_available == 2) {
                    return response()->json(['status' => 2, 'message' => trans('messages.account_blocked_by_admin'), 'showclick' => "0", 'plan_message' => '', 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                }
                if ($checkplan->payment_type == 1) {
                    if ($checkplan->status == 1) {
                        return response()->json(['status' => 2, 'message' => trans('messages.cod_pending'), 'showclick' => "0", 'plan_message' => trans('messages.cod_pending'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => '1'], 200);
                    } elseif ($checkplan->status == 3) {
                        return response()->json(['status' => 2, 'message' => trans('messages.cod_rejected'), 'showclick' => "1", 'plan_message' => trans('messages.cod_rejected'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                    }
                }
                if ($checkplan->payment_type == '6') {
                    if ($checkplan->status == 1) {
                        return response()->json(['status' => 2, 'message' => trans('messages.bank_request_pending'), 'showclick' => "0", 'plan_message' => trans('messages.bank_request_pending'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => '1'], 200);
                    } elseif ($checkplan->status == 3) {
                        return response()->json(['status' => 2, 'message' => trans('messages.bank_request_rejected'), 'showclick' => "1", 'plan_message' => trans('messages.bank_request_rejected'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                    }
                }
                if ($checkplan->expire_date != "") {
                    if (date('Y-m-d') > $checkplan->expire_date) {

                        return response()->json(['status' => 2, 'message' => trans('messages.plan_expired'), 'expdate' => $checkplan->expire_date, 'showclick' => "1", 'plan_message' => trans('messages.plan_expired'), 'plan_date' => $checkplan->expire_date, 'checklimit' => '', 'bank_transfer' => ''], 200);
                    }
                }
                if (Str::contains(request()->url(), 'admin')) {
                    if ($checkplan->service_limit != -1) {
                        if ($totalservice >= $checkplan->service_limit) {
                            if (Auth::user()->type == 1) {
                                return response()->json(['status' => 2, 'message' => trans('messages.products_limit_exceeded'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                            }
                            if (Auth::user()->type == 2) {
                                if ($checkplan->expire_date != "") {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_products_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service', 'bank_transfer' => ''], 200);
                                } else {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_products_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.lifetime_subscription'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service', 'bank_transfer' => ''], 200);
                                }
                            }
                        }
                    }
                    if ($checkplan->appoinment_limit != -1) {
                        if ($checkplan->appoinment_limit <= 0) {
                            if (Auth::user()->type == 1) {
                                return response()->json(['status' => 2, 'message' => trans('messages.order_limit_exceeded'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                            }
                            if (Auth::user()->type == 2) {
                                if ($checkplan->expire_date != "") {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_order_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'booking', 'bank_transfer' => ''], 200);
                                } else {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_order_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.lifetime_subscription'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service', 'bank_transfer' => ''], 200);
                                }
                            }
                        }
                    }
                }
                if ($type == 3) {
                    if ($checkplan->appoinment_limit != -1) {
                        if ($checkplan->appoinment_limit <= 0) {
                            return response()->json(['status' => 2, 'message' => trans('messages.front_store_unavailable'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => 'booking', 'bank_transfer' => ''], 200);
                        }
                    }
                }
                if ($checkplan->expire_date != "") {

                    return response()->json(['status' => 1, 'message' => trans('messages.plan_expires'), 'expdate' => $checkplan->expire_date, 'showclick' => "0", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => $checkplan->expire_date, 'checklimit' => '', 'bank_transfer' => ''], 200);
                } else {

                    return response()->json(['status' => 1, 'message' => trans('messages.lifetime_subscription'), 'expdate' => $checkplan->expire_date, 'showclick' => "0", 'plan_message' => trans('messages.lifetime_subscription'), 'plan_date' => $checkplan->expire_date, 'checklimit' => '', 'bank_transfer' => ''], 200);
                }
            } else {
                if (Auth::user()->type == 1) {
                    return response()->json(['status' => 2, 'message' => trans('messages.doesnot_select_any_plan'), 'expdate' => '', 'showclick' => "0", 'plan_message' => '', 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                }
                if (Auth::user()->type == 2 || Auth::user()->type == 4) {
                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_plan_purchase_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => '', 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                }
            }
        } else {
            return response()->json(['status' => 1, 'message' => trans('messages.success'), 'plan_date' => ''], 200);
        }
    }

    public static function createorder($vendor, $user_id, $session_id, $payment_type_data, $payment_id, $customer_email, $customer_name, $customer_mobile, $stripeToken, $grand_total, $delivery_charge, $address, $building, $landmark, $postal_code, $discount_amount, $offer_type, $sub_total, $tax, $tax_name, $delivery_time, $delivery_date, $delivery_area, $couponcode, $order_type, $notes, $table_id, $filename, $buynow)
    {
        try {
            $host = $_SERVER['HTTP_HOST'];
            if ($host  ==  env('WEBSITE_HOST')) {
                $vendorinfo = @helper::vendordata($vendor);
            }
            // if the current host doesn't contain the website domain (meaning, custom domain)
            else {
                $vendorinfo = Settings::where('custom_domain', $host)->first();
            }
            date_default_timezone_set(@helper::appdata($vendor)->timezone);
            if ($user_id != "" || $user_id != null) {
                if ($buynow == 1) {
                    $data = Cart::where('user_id', $user_id)->where('vendor_id', $vendor)->where('buynow', 1)->get();
                } else {
                    $data = Cart::where('user_id', $user_id)->where('vendor_id', $vendor)->where('buynow', 0)->get();
                }
            } else {
                if ($buynow == 1) {
                    $data = Cart::where('session_id', $session_id)->where('vendor_id', $vendor)->where('buynow', 1)->get();
                } else {
                    $data = Cart::where('session_id', $session_id)->where('vendor_id', $vendor)->where('buynow', 0)->get();
                }
            }

            $defaultsatus = CustomStatus::where('vendor_id', $vendor)->where('type', 1)->where('order_type', $order_type)->where('is_available', 1)->where('is_deleted', 2)->first();
            if (empty($defaultsatus) && $defaultsatus == null) {
                return "false";
            }
            if ($data->count() > 0) {
                //payment_type = COD : 1,RazorPay : 2, Stripe : 3, Flutterwave : 4, Paystack : 5, Mercado Pago : 7, PayPal : 8, MyFatoorah : 9, toyyibpay : 10, phonepe : 11, paytab : 12

                if ($order_type == "2" || $order_type == "3") {
                    $delivery_charge = "0.00";
                    $address = "";
                    $building = "";
                    $landmark = "";
                    $postal_code = "";
                } else {
                    $delivery_charge = $delivery_charge;
                    $address = $address;
                    $building = $building;
                    $landmark = $landmark;
                    $postal_code = $postal_code;
                }
                if ($discount_amount == "NaN") {
                    $discount_amount = 0;
                } else {
                    $discount_amount = $discount_amount;
                }

                $getordernumber = Order::select('order_number', 'order_number_digit', 'order_number_start')->where('vendor_id', $vendor)->orderBy('id', 'DESC')->first();

                if (empty($getordernumber->order_number_digit)) {
                    $n = helper::appdata($vendor)->order_number_start;
                    $newbooking_number = str_pad($n, 0, STR_PAD_LEFT);
                } else {
                    if ($getordernumber->order_number_start == helper::appdata($vendor)->order_number_start) {
                        $n = (int)($getordernumber->order_number_digit);
                        $newbooking_number = str_pad($n + 1, 0, STR_PAD_LEFT);
                    } else {
                        $n = helper::appdata($vendor)->order_number_start;
                        $newbooking_number = str_pad($n, 0, STR_PAD_LEFT);
                    }
                }

                $order = new Order;
                $order_number = helper::appdata($vendor)->order_prefix . $newbooking_number;
                $order->order_number = $order_number;
                $order->order_number_digit = $newbooking_number;
                $order->order_number_start = helper::appdata($vendor)->order_number_start;

                $order->vendor_id = $vendor;
                $order->user_id = $user_id;
                $order->order_number = $order_number;
                $order->payment_type = $payment_type_data;
                $order->payment_id = @$payment_id;
                $order->sub_total = $sub_total;
                $order->tax = $tax;
                $order->tax_name = $tax_name;
                $order->grand_total = $grand_total;
                $order->status = $defaultsatus->id;
                $order->status_type = $defaultsatus->type;
                $order->address = $address;
                $order->delivery_time = $delivery_time;
                $order->delivery_date = $delivery_date;
                $order->delivery_area = $delivery_area;
                $order->delivery_charge = $delivery_charge;
                $order->discount_amount = $discount_amount;
                $order->offer_type = $offer_type;
                $order->couponcode = $couponcode;
                $order->order_type = $order_type;
                $order->table_id = $table_id;
                $order->building = $building;
                $order->landmark = $landmark;
                $order->pincode = $postal_code;
                $order->customer_name = $customer_name;
                $order->customer_email = $customer_email;
                $order->mobile = $customer_mobile;
                $order->order_notes = $notes;
                $order->loyalty_amount = '20';
                if ($payment_type_data == '1') {
                    $order->payment_status = 1;
                } elseif ($payment_type_data == '6') {
                    $order->screenshot = $filename;
                    $order->payment_status = 1;
                } else {
                    $order->payment_status = 2;
                }

                if ($order->save()) {
                    $order_id = DB::getPdo()->lastInsertId();
                    if ($payment_type_data == 16) {
                        $checkuser = User::where('is_available', 1)->where('vendor_id', $vendor)->where('id', @Auth::user()->id)->first();
                        $checkuser->wallet = $checkuser->wallet - $grand_total;
                        $transaction = new Transaction();
                        $transaction->vendor_id = @$vendor;
                        $transaction->user_id = @$checkuser->id;
                        $transaction->order_id = $order_id;
                        $transaction->order_number = $order_number;
                        $transaction->payment_type = 16;
                        $transaction->transaction_type = 2;
                        $transaction->amount = $grand_total;
                        if ($transaction->save()) {
                            $checkuser->save();
                        }
                    }

                    foreach ($data as $value) {

                        $OrderPro = new OrderDetails;
                        $OrderPro->order_id = $order_id;
                        $OrderPro->item_id = $value['item_id'];
                        $OrderPro->item_name = $value['item_name'];
                        $OrderPro->item_image = $value['item_image'];
                        $OrderPro->extras_id = $value['extras_id'];
                        $OrderPro->extras_name = $value['extras_name'];
                        $OrderPro->extras_price = $value['extras_price'];
                        if ($value['variants_id'] == "") {
                            $product = Item::where('id', $value['item_id'])->first();
                            if ($product->stock_management == 1) {
                                $product->qty = (int)$product->qty - (int)$value['qty'];
                            }
                            $product->update();
                        } else {
                            $variant = Variants::where('item_id', $value['item_id'])->where('id', $value['variants_id'])->first();
                            if ($variant->stock_management == 1) {
                                $variant->qty = (int)$variant->qty - (int)$value['qty'];
                            }
                            $variant->update();
                        }
                        $OrderPro->price = $value['price'];
                        $OrderPro->variants_price = $value['item_price'];
                        $OrderPro->variants_id = $value['variants_id'];
                        $OrderPro->variants_name = $value['variants_name'];
                        $OrderPro->qty = $value['qty'];
                        $OrderPro->save();
                    }

                    if ($user_id != "" || $user_id != null) {
                        if ($buynow == 1) {
                            $data = Cart::where('user_id', $user_id)->where('buynow', 1)->delete();
                        } else {
                            $data = Cart::where('user_id', $user_id)->where('buynow', 0)->delete();
                        }
                    } else {
                        if ($buynow == 1) {
                            $data = Cart::where('session_id', $session_id)->where('buynow', 1)->delete();
                        } else {
                            $data = Cart::where('session_id', $session_id)->where('buynow', 0)->delete();
                        }
                    }

                    session()->forget(['offer_amount', 'offer_code', 'offer_type']);

                    if ($user_id != "" || $user_id != null) {
                        $count = Cart::where('user_id', $user_id)->count();
                    } else {
                        $count = Cart::where('session_id', $session_id)->count();
                    }

                    session()->put('cart', $count);

                    $trackurl = URL::to(@$vendorinfo->slug . '/track-order/' . $order_number);
                    $emaildata = @helper::emailconfigration($vendor);
                    Config::set('mail', $emaildata);
                    @helper::create_order_invoice($customer_email, $customer_name, $vendorinfo->email, $vendorinfo->name, $vendor, $order_number, $order_type, @helper::date_format($delivery_date, $vendor), $delivery_time, @helper::currency_formate($grand_total, $vendor), $trackurl);

                    $title = trans('labels.order_update');
                    $body = "Congratulations! Your store just received a new order " . $order_number;

                    @helper::push_notification($vendorinfo->token, $title, $body, "order", $order->id);

                    $checkplan = Transaction::where('vendor_id', $vendor)->where('transaction_type', null)->orderByDesc('id')->first();


                    if ($offer_type == "" || $offer_type == "promocode") {
                        loyaltyhelper::savepoints($vendor, $user_id, $order_number, 1, '');
                    } else {
                        if ($offer_type == "loyalty") {
                            loyaltyhelper::savepoints($vendor, $user_id, $order_number, 2, $couponcode);
                        }
                    }
                    if (!empty($checkplan)) {
                        if ($checkplan->appoinment_limit != -1) {
                            $checkplan->appoinment_limit -= 1;
                            $checkplan->save();
                        }
                    }

                    session()->forget('table_id');

                    return $order_number;
                } else {
                    return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
                }
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.cart_empty')], 200);
            }
        } catch (\Throwable $th) {
            dd($th);
            return $th;
        }
    }

    public static function get_plan($vendor_id)
    {
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vendorinfo = @helper::storeinfo($vendor_id);
            $vdata = $vendor_id;
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendorinfo = Settings::where('custom_domain', $host)->first();
            $vdata = $vendorinfo->vendor_id;
        }
        $vendorinfo = Transaction::where('vendor_id', $vdata)->orderByDesc('id')->first();;
        return $vendorinfo;
    }

    public static function push_notification($token, $title, $body, $type, $order_id)
    {
        if (Auth::user()->type == 1) {
            $firebase = helper::appdata('')->firebase;
        } else {
            $firebase = @helper::appdata(Auth::user()->id)->firebase;
        }
        $customdata = array(
            "type" => $type,
            "order_id" => $order_id,
        );

        $msg = array(
            'body' => $body,
            'title' => $title,
            'sound' => 1/*Default sound*/
        );
        $fields = array(
            'to'           => $token,
            'notification' => $msg,
            'data' => $customdata
        );
        $headers = array(
            'Authorization: key=' . $firebase,
            'Content-Type: application/json'
        );
        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $firebaseresult = curl_exec($ch);
        curl_close($ch);

        return $firebaseresult;
    }

    public static function vendor_register($vendor_name, $vendor_email, $vendor_mobile, $vendor_password, $firebasetoken, $slug, $google_id, $facebook_id, $city_id, $area_id, $store_id)
    {
        try {
            if (!empty($slug)) {
                $check = User::where('slug', $slug)->first();
                if ($check != "") {
                    $last = User::select('id')->orderByDesc('id')->first();
                    $slug =   Str::slug($slug . " " . ($last->id + 1), '-');
                } else {
                    $slug = $slug;
                }
            } else {
                $check = User::where('slug', Str::slug($vendor_name, '-'))->first();
                if ($check != "") {
                    $last = User::select('id')->orderByDesc('id')->first();
                    $slug =   Str::slug($vendor_name . " " . ($last->id + 1), '-');
                } else {
                    $slug = Str::slug($vendor_name, '-');
                }
            }
            $rec = Settings::where('vendor_id', '1')->first();

            date_default_timezone_set($rec->timezone);
            $logintype = "normal";
            if ($google_id != "") {
                $logintype = "google";
            }

            if ($facebook_id != "") {
                $logintype = "facebook";
            }

            $user = new User;
            $user->name = $vendor_name;
            $user->email = $vendor_email;
            $user->password = $vendor_password;
            $user->google_id = $google_id;
            $user->facebook_id = $facebook_id;
            $user->mobile = $vendor_mobile;
            $user->slug = $slug;
            $user->login_type = $logintype;
            $user->type = 2;
            $user->token = $firebasetoken;
            $user->city_id = $city_id;
            $user->area_id = $area_id;
            $user->is_verified = 2;
            $user->is_available = 1;
            $user->store_id = $store_id;
            $user->save();

            $vendor_id = \DB::getPdo()->lastInsertId();

            $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

            foreach ($days as $day) {

                $timedata = new Timing;
                $timedata->vendor_id = $vendor_id;
                $timedata->day = $day;
                $timedata->open_time = '09:00 AM';
                $timedata->break_start = '01:00 PM';
                $timedata->break_end = '02:00 PM';
                $timedata->close_time = '09:00 PM';
                $timedata->is_always_close = '2';
                $timedata->save();
            }

            $status_name = CustomStatus::where('vendor_id', '1')->get();

            foreach ($status_name as $name) {
                $customstatus = new CustomStatus;
                $customstatus->vendor_id = $vendor_id;
                $customstatus->name = $name->name;
                $customstatus->type = $name->type;
                $customstatus->order_type = $name->order_type;
                $customstatus->is_available = $name->is_available;
                $customstatus->is_deleted = $name->is_deleted;
                $customstatus->save();
            }
            $paymentlist = Payment::select('unique_identifier', 'payment_name', 'currency', 'image', 'is_activate', 'payment_type')->where('vendor_id', '1')->get();
            foreach ($paymentlist as $payment) {
                $gateway = new Payment;
                $gateway->vendor_id = $vendor_id;
                $gateway->unique_identifier = $payment->unique_identifier;
                $gateway->payment_name = $payment->payment_name;
                $gateway->payment_type = $payment->payment_type;
                $gateway->currency = $payment->currency;
                $gateway->image = $payment->image;
                $gateway->public_key = '-';
                $gateway->secret_key = '-';
                $gateway->encryption_key = '-';
                $gateway->environment = '1';
                $gateway->is_available = '1';
                $gateway->is_activate = $payment->is_activate;
                $gateway->save();
            }

            $messagenotification = "Hi, 
I would like to place an order 👇
*{delivery_type}* Order No: {order_no}
---------------------------
{item_variable}
---------------------------
👉Subtotal : {sub_total}
{total_tax}
👉Delivery charge : {delivery_charge}
👉Discount : - {discount_amount}
---------------------------
📃 Total : {grand_total}
---------------------------
📄 Comment : {notes}

✅ Customer Info

Customer name : {customer_name}
Customer phone : {customer_mobile}

📍 Delivery Details

Address : {address}, {building}, {landmark}, {postal_code}

---------------------------
Date : {date}
Time : {time}
---------------------------
💳 Payment type :
{payment_type}

{store_name} will confirm your order upon receiving the message.

Track your order 👇
{track_order_url}

Click here for next order 👇
{store_url}";

            $vendorcontactemailmessage = "Dear {vendorname},

You have received new inquiry

Full Name : {username}

Email : {useremail}

Mobile : {usermobile}

Message : {usermessage}";

            $neworderinvoicemailmessage = "Dear {customername},

We are pleased to confirm that we have received your Order.

Order details

Order number : #{ordernumber}
Date : {date}
Time : {time}
Grand Total : {grandtotal}

Click Here : {track_order_url}

Thank you for choosing.

Sincerely,
{vendorname}";

            $vendorneworderemailmessage = "Dear {vendorname},

We are writing to confirm that you have received new Order.

Order details

Order number : #{ordernumber}
Date : {date}
Time : {time}
Grand Total : {grandtotal}

Sincerely,
{customername}";

            $orderstatusemailmessage = "Dear {customername},
                
I am writing to inform you that {status_message}

Sincerely
{vendorname}";

            $data = new Settings();
            $data->vendor_id = $vendor_id;
            $data->currency = $rec->currency;

            // logo===================================================
            $data->logo = $rec->logo;
            // favicon=============
            $data->favicon = $rec->favicon;
            // og_image
            $data->og_image = $rec->favicon;
            $data->banner = "default-banner.png";
            $data->currency_position = $rec->currency_position;
            $data->timezone = $rec->timezone;
            $data->address = "Your address";
            $data->contact = "-";
            $data->email = "youremail@gmail.com";
            $data->description = "Your description";
            $data->copyright = $rec->copyright;
            $data->website_title = "Your store name";
            $data->decimal_separator = $rec->decimal_separator;
            $data->currency_formate = $rec->currency_formate;
            $data->meta_title = "Your store name";
            $data->meta_description = "Description";
            $data->firebase = '-';
            $data->delivery_type = "1,2";
            $data->item_message = "🔵 {qty} X {item_name} {variantsdata} - {item_price}";
            $data->interval_time = 1;
            $data->interval_type = 2;
            $data->primary_color = '#181D31';
            $data->secondary_color = '#6096B4';
            $data->contact_email_message = $vendorcontactemailmessage;
            $data->new_order_invoice_email_message = $neworderinvoicemailmessage;
            $data->vendor_new_order_email_message = $vendorneworderemailmessage;
            $data->order_status_email_message = $orderstatusemailmessage;
            $data->time_format = $rec->time_format;
            $data->date_format = $rec->date_format;
            $data->order_prefix = 'PITS';
            $data->order_number_start = 1001;
            $data->whatsapp_message = $messagenotification;
            $data->telegram_message = $messagenotification;
            $data->save();

            return $vendor_id;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public static function plandetail($plan_id)
    {
        $planinfo = PricingPlan::where('id', $plan_id)->first();
        return $planinfo;
    }

    public static function footer_features($vendor_id)
    {
        return Footerfeatures::select('id', 'icon', 'title', 'description')->where('vendor_id', $vendor_id)->get();
    }

    //Send email 

    public static function send_subscription_email($vendor_email, $vendor_name, $plan_name, $duration, $price, $payment_method, $transaction_id)
    {
        $admininfo = User::where('id', '1')->first();
        $vendorvar = ["{vendorname}", "{payment_type}", "{subscription_duration}", "{subscription_price}", "{plan_name}", "{adminname}", "{adminemail}"];
        $vendornewvar = [$vendor_name, $payment_method, $duration, $price, $plan_name, $admininfo->name, $admininfo->email];
        $vendormessage = str_replace($vendorvar, $vendornewvar, nl2br(helper::appdata('')->subscription_success_email_message));

        $adminvar = ["{adminname}", "{vendorname}", "{vendoremail}", "{plan_name}", "{subscription_duration}", "{subscription_price}", "{payment_type}"];
        $adminnewvar = [$admininfo->name, $vendor_name, $vendor_email, $plan_name, $duration, $price, $payment_method];
        $adminmessage = str_replace($adminvar, $adminnewvar, nl2br(helper::appdata('')->admin_subscription_success_email_message));

        $data = ['title' => "Subscription Purchase Confirmation", 'vendor_email' => $vendor_email, 'vendormessage' => $vendormessage];

        $adminemail = ['title' => "New Subscription Purchase Notification", 'admin_email' => $admininfo->email, 'adminmessage' => $adminmessage];

        try {
            Mail::send('email.subscription', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });

            Mail::send('email.adminsubscription', $adminemail, function ($message) use ($adminemail) {
                $message->to($adminemail['admin_email'])->subject($adminemail['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function bank_transfer_request($vendor_email, $vendor_name, $plan_name, $duration, $price, $payment_method, $transaction_id)
    {
        $admininfo = User::where('id', '1')->first();

        $vendorvar = ["{vendorname}", "{adminname}", "{adminemail}"];
        $vendornewvar = [$vendor_name, $admininfo->name, $admininfo->email];
        $vendormessage = str_replace($vendorvar, $vendornewvar, nl2br(helper::appdata('')->banktransfer_request_email_message));

        $adminvar = ["{adminname}", "{vendorname}", "{vendoremail}", "{plan_name}", "{subscription_duration}", "{subscription_price}", "{payment_type}"];
        $adminnewvar = [$admininfo->name, $vendor_name, $vendor_email, $plan_name, $duration, $price, $payment_method];
        $adminmessage = str_replace($adminvar, $adminnewvar, nl2br(helper::appdata('')->admin_subscription_request_email_message));

        $data = ['title' => "Bank transfer", 'vendor_email' => $vendor_email, 'vendormessage' => $vendormessage];
        $adminemail = ['title' => "Bank transfer", 'admin_email' => $admininfo->email, 'adminmessage' => $adminmessage,];
        try {
            Mail::send('email.banktransfervendor', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });

            Mail::send('email.banktransferadmin', $adminemail, function ($message) use ($adminemail) {
                $message->to($adminemail['admin_email'])->subject($adminemail['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function subscription_rejected($vendor_email, $vendor_name, $plan_name, $payment_method)
    {
        $admindata = User::select('name', 'email')->where('id', '1')->first();
        $var = ["{vendorname}", "{payment_type}", "{plan_name}", "{adminname}", "{adminemail}"];
        $newvar = [$vendor_name, $payment_method, $plan_name, $admindata->name, $admindata->email];
        $rejectmessage = str_replace($var, $newvar, nl2br(helper::appdata('')->subscription_reject_email_message));

        $data = ['title' => "Bank transfer rejected", 'vendor_email' => $vendor_email, 'rejectmessage' => $rejectmessage];
        try {
            Mail::send('email.banktransferreject', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function vendor_contact_data($id, $vendor_name, $vendor_email, $full_name, $useremail, $usermobile, $usermessage)
    {
        $var = ["{vendorname}", "{username}", "{useremail}", "{usermobile}", "{usermessage}"];
        $newvar = [$vendor_name, $full_name, $useremail, $usermobile, $usermessage];
        $vendorcontactmessage = str_replace($var, $newvar, nl2br(helper::appdata($id)->contact_email_message));

        $data = ['title' => "Inquiry", 'vendor_email' => $vendor_email, 'vendorcontactmessage' => $vendorcontactmessage];
        try {
            Mail::send('email.vendorcontcatform', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function create_order_invoice($customer_email, $customer_name, $companyemail, $companyname, $vendorid, $order_number, $order_type, $delivery_date, $delivery_time, $grand_total, $trackurl)
    {
        $orderinvoicevar = ["{customername}", "{ordernumber}", "{date}", "{time}", "{grandtotal}", "{track_order_url}", "{vendorname}"];
        $orderinvoicenewvar = [$customer_name, $order_number, $delivery_date, $delivery_time, $grand_total, $trackurl, $companyname];
        $neworderinvoicemessage = str_replace($orderinvoicevar, $orderinvoicenewvar, nl2br(helper::appdata($vendorid)->new_order_invoice_email_message));

        $orderemailvar = ["{customername}", "{ordernumber}", "{date}", "{time}", "{grandtotal}", "{vendorname}"];
        $orderemailnewvar = [$customer_name, $order_number, $delivery_date, $delivery_time, $grand_total, $companyname];
        $vendorneworderemailmessage = str_replace($orderemailvar, $orderemailnewvar, nl2br(helper::appdata($vendorid)->vendor_new_order_email_message));

        $data = ['title' => "Order Invoice", 'customer_email' => $customer_email, 'company_email' => $companyemail, 'neworderinvoicemessage' => $neworderinvoicemessage, 'vendorneworderemailmessage' => $vendorneworderemailmessage];

        try {
            Mail::send('email.customerorderemail', $data, function ($message) use ($data) {
                $message->to($data['customer_email'])->subject($data['title']);
            });

            Mail::send('email.vendororderemail', $data, function ($companymessage) use ($data) {
                $companymessage->to($data['company_email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function order_status_email($email, $name, $title, $message_text, $vendor)
    {
        $var = ["{customername}", "{status_message}", "{vendorname}"];
        $newvar = [$name, $message_text, $vendor->name];
        $orderstatusmessage = str_replace($var, $newvar, nl2br(helper::appdata($vendor->id)->order_status_email_message));

        $data = ['email' => $email, 'title' => $title, 'orderstatusmessage' => $orderstatusmessage, 'logo' => @helper::image_path(@helper::appdata($vendor_id)->logo)];
        try {
            Mail::send('email.orderemail', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function send_pass($email, $name, $password, $id)
    {
        $var = ["{user}", "{password}"];
        $newvar = [$name, $password];
        $forpasswordmessage = str_replace($var, $newvar, nl2br(helper::appdata('')->forget_password_email_message));

        $data = ['title' => "New Password", 'email' => $email, 'forpasswordmessage' => $forpasswordmessage, 'logo' => @helper::appdata($id)->logo];
        try {
            Mail::send('email.sendpassword', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function cancel_order($email, $name, $title, $message_text, $vendor)
    {
        $var = ["{customername}", "{status_message}", "{vendorname}"];
        $newvar = [$name, $message_text, $vendor->customer_name];
        $orderstatusmessage = str_replace($var, $newvar, nl2br(helper::appdata($vendor->vendor_id)->order_status_email_message));

        $data = ['email' => $email, 'title' => $title, 'orderstatusmessage' => $orderstatusmessage, 'logo' => Helper::image_path(@Helper::appdata($vendor->id)->logo)];
        try {
            Mail::send('email.orderemail', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_mail_delete_account($vendor)
    {
        $var = ["{vendorname}"];
        $newvar = [$vendor->name];
        $userdeletemessage = str_replace($var, $newvar, nl2br(helper::appdata('')->delete_account_email_message));

        $data = ['title' => trans('labels.account_deleted'), 'userdeletemessage' => $userdeletemessage, 'email' => $vendor->email];
        try {
            Mail::send('email.accountdeleted', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    // Email end

    public static function language($vendor_id)
    {
        if (session()->get('locale') == null) {
            $layout = Languages::select('name', 'layout', 'image', 'is_default', 'code')->where('code', helper::appdata($vendor_id)->default_language)->first();
            App::setLocale(@$layout->code);
            session()->put('locale', @$layout->code);
            session()->put('language', @$layout->name);
            session()->put('flag', @$layout->image);
            session()->put('direction', @$layout->layout);
        } else {
            $layout = Languages::select('name', 'layout', 'image', 'is_default', 'code')->where('code', session()->get('locale'))->first();
            App::setLocale(session()->get('locale'));
            session()->put('locale', @$layout->code);
            session()->put('language', @$layout->name);
            session()->put('flag', @$layout->image);
            session()->put('direction', @$layout->layout);
        }
    }


    // get language list vendor side.
    public static function available_language($vendor_id)
    {
        if ($vendor_id == "") {
            $listoflanguage = Languages::where('is_available', '1')->where('is_deleted', 2)->get();
        } else {
            $listoflanguage = Languages::where('is_available', '1')->where('is_deleted', 2)->get();
        }
        return $listoflanguage;
    }

    // get language list in atuh pages.
    public static function listoflanguage()
    {
        $listoflanguage = Languages::where('is_available', '1')->get();
        return $listoflanguage;
    }
    public static function whatsappmessage($order_number, $vdata, $vendordata)
    {
        $pagee[] = "";
        $orderdata = Order::where('order_number', $order_number)->where('vendor_id', $vdata)->first();
        $data = OrderDetails::where('order_id', $orderdata->id)->get();
        foreach ($data as $value) {
            if ($value['variants_id'] != "") {
                $item_p = $value['qty'] * $value['price'];
                $variantsdata = '(' . $value['variants_name'] . ')';
            } else {
                $variantsdata = "";
                $item_p = $value['qty'] * $value['price'];
            }
            $extras_id = explode("|", $value['extras_id']);
            $extras_name = explode("|", $value['extras_name']);
            $extras_price = explode("|", $value['extras_price']);
            $item_message = @helper::appdata($vdata)->item_message;
            $itemvar = ["{qty}", "{item_name}", "{variantsdata}", "{item_price}"];
            $newitemvar = [$value['qty'], $value['item_name'], $variantsdata, @helper::currency_formate($item_p, $vdata)];
            $pagee[] = str_replace($itemvar, $newitemvar, $item_message);
            if ($value['extras_id'] != "") {
                foreach ($extras_id as $key => $addons) {
                    @$pagee[] .= "👉" . $extras_name[$key] . ':' . @helper::currency_formate($extras_price[$key], $vdata);
                }
            }
        }
        $items = implode("|", $pagee);
        $tax = explode("|", $orderdata['tax']);
        $tax_name = explode("|", $orderdata['tax_name']);

        $tax_data[] = "";
        if ($tax != "") {
            foreach ($tax as $key => $tax_value) {
                @$tax_data[] .= "👉" . $tax_name[$key] . ' : ' . helper::currency_formate((float)$tax[$key], $vdata);
            }
        }
        $tdata = implode("|", $tax_data);
        $tax_val = str_replace('|', '%0a', $tdata);
        $itemlist =  str_replace('|', '%0a', $items);
        if ($orderdata->order_type == 1) {
            $order_type = trans('labels.delivery');
        } else {
            $order_type = trans('labels.pickup');
        }
        //payment_type = COD : 1,RazorPay : 2, Stripe : 3, Flutterwave : 4, Paystack : 5, Mercado Pago : 7, PayPal : 8, MyFatoorah : 9, toyyibpay : 10, phonepe : 11, paytab : 12

        $var = ["{delivery_type}", "{order_no}", "{item_variable}", "{sub_total}", "{total_tax}", "{delivery_charge}", "{discount_amount}", "{grand_total}", "{notes}", "{customer_name}", "{customer_mobile}", "{address}", "{building}", "{landmark}", "{postal_code}", "{date}", "{time}", "{payment_type}", "{store_name}", "{track_order_url}", "{store_url}"];
        $newvar = [$order_type, $order_number, $itemlist, @helper::currency_formate($orderdata->sub_total, $vdata), $tax_val, @helper::currency_formate($orderdata->delivery_charge, $vdata), @helper::currency_formate($orderdata->discount_amount, $vdata), helper::currency_formate($orderdata->grand_total, $vdata), $orderdata->order_notes, $orderdata->customer_name, $orderdata->mobile, $orderdata->address, $orderdata->building, $orderdata->landmark, $orderdata->postal_code, $orderdata->delivery_date, $orderdata->delivery_time, @helper::getpayment($orderdata->payment_type, $vdata)->payment_name, $vendordata->name, URL::to($vendordata->slug . "/track-order/" . $order_number), URL::to($vendordata->slug)];
        $whmessage = str_replace($var, $newvar, str_replace("\n", "%0a", @helper::appdata($vdata)->whatsapp_message));

        return $whmessage;
    }

    // dynamic email configration
    public static function emailconfigration($vendor_id)
    {


        if ($vendor_id == "" && $vendor_id == null) {
            $vendor_id = 1;
        } else {
            $vendor_id = $vendor_id;
        }
        $mailsettings = Settings::where('vendor_id', $vendor_id)->first();

        if ($mailsettings) {
            $emaildata = [
                'driver' => $mailsettings->mail_driver,
                'host' => $mailsettings->mail_host,
                'port' => $mailsettings->mail_port,
                'encryption' => $mailsettings->mail_encryption,
                'username' => $mailsettings->mail_username,
                'password' => $mailsettings->mail_password,
                'from'     => ['address' => $mailsettings->mail_fromaddress, 'name' => $mailsettings->mail_fromname]
            ];
        }
        return $emaildata;
    }

    public static function getcouponcodecount($offer_code, $vendor_id)
    {
        $count = Order::select('couponcode')->where('couponcode', $offer_code)->where('vendor_id', $vendor_id)->count();
        return $count;
    }

    public static function imageresize($file, $directory_name)
    {
        $reimage = 'item-' . uniqid() . "." . $file->getClientOriginalExtension();

        $new_width = 1000;

        // create image manager with desired driver      

        $manager = new ImageManager(new Driver());

        // read image from file system
        $image = $manager->read($file);


        // Get Height & Width
        list($width, $height) = getimagesize("$file");

        // Get Ratio
        $ratio = $width / $height;

        // Create new height & width
        $new_height = $new_width / $ratio;

        // resize image proportionally to 200px width
        $image->scale(width: $new_width, height: $new_height);

        $extension = File::extension($reimage);

        $exif = @exif_read_data("$file");

        $degrees = 0;
        if (isset($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 8:
                    $degrees = 90;
                    break;
                case 3:
                    $degrees = 180;
                    break;
                case 6:
                    $degrees = -90;
                    break;
            }
        }

        // $image->rotate($degrees);
        $convert = $image;
        if (Str::endsWith($reimage, '.jpeg')) {
            $convert = $convert->toJpeg();
        } else if (Str::endsWith($reimage, '.jpg')) {
            $convert = $convert->toJpeg();
        } else if (Str::endsWith($reimage, '.webp')) {
            $convert = $convert->toWebp();
        } else if (Str::endsWith($reimage, '.gif')) {
            $convert = $convert->toGif();
        } else if (Str::endsWith($reimage, '.png')) {
            $convert = $convert->toPng();
        } else if (Str::endsWith($reimage, '.avif')) {
            $convert = $convert->toAvif();
        } else if (Str::endsWith($reimage, '.bmp')) {
            $convert = $convert->toBitmap();
        }

        $convertimg = str_replace($extension, 'webp', $reimage);

        $convert->save("$directory_name/$convertimg");

        return $convertimg;
    }

    public static function checklowqty($item_id, $vendor_id)
    {
        $item = Item::where('id', $item_id)->where('vendor_id', $vendor_id)->first();
        if ($item->has_variants == 1) {
            $qty = Variants::select('item_id', 'qty')->where('item_id', $item_id)->get();
            $array = [];

            foreach ($qty as $qty) {
                array_push($array, $qty->qty);
            }
            if (in_array(0, $array)) {
                return 2;
            }
            if (count(array_filter($array)) == 0) {
                return 3;
            }
            foreach ($array as $qty) {
                if ($qty != null && $qty != "") {
                    if ($qty <= $item->low_qty) {
                        return 1;
                    }
                }
            }
        } else {

            if ($item->qty == null && $item->qty == "") {
                return 3;
            }
            if ((string)$item->qty != null && (string)$item->qty != "") {
                if ((string)$item->qty == 0) {
                    return 2;
                }
                if ($item->qty <= $item->low_qty) {
                    return 1;
                }
            }
        }
    }
    public static function gettax($tax_id)
    {
        $taxArr = explode('|', $tax_id);
        $taxes = [];
        foreach ($taxArr as $tax) {
            $taxes[] = Tax::find($tax);
        }
        return $taxes;
    }

    public static function taxRate($taxRate, $price, $quantity, $tax_type)
    {
        if ($tax_type == 1) {
            return $taxRate * $quantity;
        }

        if ($tax_type == 2) {
            return ($taxRate / 100) * ($price * $quantity);
        }
    }
    // display dynamic paymant name
    public static function getpayment($payment_type, $vendor_id)
    {
        $payment = Payment::select('payment_name')->where('payment_type', $payment_type)->where('vendor_id', $vendor_id)->first();
        return $payment;
    }
    public static function getsociallinks($vendor_id)
    {
        $links = SocialLinks::where('vendor_id', $vendor_id)->get();
        return $links;
    }
    public static function imagesize()
    {
        $imagesize  = (int)1024 * (int)helper::appdata('')->image_size;
        return $imagesize;
    }
    public static function imageext()
    {
        $imageext = 'mimes:jpeg,jpg,png,webp';
        return $imageext;
    }
    public static function customstauts($vendor_id, $order_type)
    {
        $status = CustomStatus::where('vendor_id', $vendor_id)->where('order_type', $order_type)->where('is_available', 1)->where('is_deleted', 2)->orderBy('reorder_id')->get();
        return $status;
    }
    public static function gettype($status, $type, $order_type, $vendor_id)
    {
        $status = CustomStatus::where('vendor_id', $vendor_id)->where('order_type', $order_type)->where('type', $type)->where('id', $status)->first();
        return $status;
    }
    public static function top_deals($vendor_id)
    {
        date_default_timezone_set(helper::appdata($vendor_id)->timezone);
        $current_date  = Carbon::now()->format('Y-m-d');
        $current_time  = Carbon::now()->format('H:i:s');
        $topdeal = TopDeals::where('vendor_id', $vendor_id)->first();
        $topdeals = null;
        if (SystemAddons::where('unique_identifier', 'top_deals')->first() != null && SystemAddons::where('unique_identifier', 'top_deals')->first()->activated == 1) {
            if (isset($topdeal) && $topdeal->top_deals_switch == 1) {
                $startDate = $topdeal['start_date'];
                $starttime = $topdeal['start_time'];
                $endDate = $topdeal['end_date'];
                $endtime = $topdeal['end_time'];
                // Checking validity of top deal offer
                if ($topdeal->deal_type == 1) {
                    if ($current_date > $startDate) {
                        if ($current_date < $endDate) {
                            $topdeals = TopDeals::where('vendor_id', $vendor_id)->first();
                        } elseif ($current_date == $endDate) {
                            if ($current_time < $endtime) {
                                $topdeals = TopDeals::where('vendor_id', $vendor_id)->first();
                            }
                        }
                    } elseif ($current_date == $startDate) {
                        if ($current_date < $endDate && $current_time >= $starttime) {
                            $topdeals = TopDeals::where('vendor_id', $vendor_id)->first();
                        } elseif ($current_date == $endDate) {
                            if ($current_time >= $starttime && $current_time <= $endtime) {
                                $topdeals = TopDeals::where('vendor_id', $vendor_id)->first();
                            }
                        }
                    }
                } else if ($topdeal->deal_type == 2) {
                    if ($current_time >= $starttime && $current_time <= $endtime) {
                        $topdeals = TopDeals::where('vendor_id', $vendor_id)->first();
                    }
                }
            }
        }
        return $topdeals;
    }
    public static function getagedetails($vendor_id)
    {
        $agedetails = AgeVerification::where('vendor_id', $vendor_id)->first();
        return $agedetails;
    }
    public static function getpixelid($vendor_id)
    {
        $pixcel = Pixcel::where('vendor_id', $vendor_id)->first();
        return $pixcel;
    }
    public static function role($id)
    {
        $role = RoleManager::select('role')->where('id', $id)->first();
        return $role;
    }
    public static function checkthemeaddons($addons)
    {
        if (session()->get('demo') == "free-addon") {
            $check = SystemAddons::where('unique_identifier', 'LIKE', '%' . $addons . '%')->where('activated', 1)->where('type', 1)->get();
        } elseif (session()->get('demo') == "free-with-extended-addon") {
            $check = SystemAddons::where('unique_identifier', 'LIKE', '%' . $addons . '%')->where('activated', 1)->whereIn('type', ['1', '2'])->get();
        } elseif (session()->get('demo') == "all-addon") {
            $check = SystemAddons::where('unique_identifier', 'LIKE', '%' . $addons . '%')->where('activated', 1)->whereIn('type', ['1', '2', '3'])->get();
        } else {
            $check = SystemAddons::where('unique_identifier', 'LIKE', '%' . $addons . '%')->where('activated', 1)->get();
        }
        return $check;
    }
    public static function check_menu($role_id, $slug)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        if ($role_id == "" || $role_id == null || $role_id == 0) {
            return 1;
        } else {
            $module = RoleManager::where('id', $role_id)->where('vendor_id', $vendor_id)->first();
            $module = explode('|', $module->module);
            if (in_array($slug, $module)) {
                return 1;
            } else {

                return 0;
            }
        }
    }
    public static function check_access($module, $role_id, $vendor_id, $action)
    {

        $module = RoleAccess::where('module_name', $module)->where('role_id', $role_id)->where('vendor_id', $vendor_id)->first();
        if (!empty($module) && $module != null) {
            if ($action == 'add' && $module->add == 1) {
                return 1;
            } elseif ($action == 'edit' && $module->edit == 1) {
                return 1;
            } elseif ($action == 'delete' && $module->delete == 1) {
                return 1;
            } elseif ($action == 'manage' && $module->manage == 1) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
    public static function getplantransaction($vendor_id)
    {
        $plan = Transaction::where('vendor_id', $vendor_id)->orderbyDesc('id')->first();
        return $plan;
    }
    public static function getallpayment($vendor_id)
    {
        $payment = Payment::where('vendor_id', $vendor_id)->where('is_available', 1)->get();
        return $payment;
    }
    public static function storecategory()
    {
        $storecategory = StoreCategory::where('is_available', 1)->where('is_deleted', 2)->get();
        return $storecategory;
    }

    public static function app_settings($vendor_id)
    {
        $app = AppSettings::where('vendor_id',  $vendor_id)->first();
        return $app;
    }
}
