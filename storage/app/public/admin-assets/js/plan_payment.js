var api_key = "";
var payment_type = "";
var currency = "";
var price = $('#price').val();
var plan_id = $('#plan_id').val();
var user_name = $('#user_name').val();
var user_email = $('#user_email').val();
var user_mobile = $('#user_mobile').val();
var grand_total = $('#grand_total').val();
console.log(price);

if ($('#stripe_public_key').val() != null) {
    var stripe_public_key = $('#stripe_public_key').val();
    var stripe = Stripe(stripe_public_key);
    var card = stripe.elements().create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
            },
        },
    });
    card.mount('#card-element');
    $('.__PrivateStripeElement iframe').removeAttr('style');
}
$('input[name=paymentmode]').on('click', function (e) {
    "use strict";
    $(".payment_error").addClass('d-none');
    api_key = $('input[name=paymentmode]:checked').val();
    currency = $('input[name=paymentmode]:checked').attr('data-currency');
    payment_type = $('input[name=paymentmode]:checked').attr('data-transaction-type');
    if (payment_type == '3') {
        $('.stripe-form').removeClass('d-none');
    } else {
        $('.stripe-form').addClass('d-none');
    }
});
$('.buy_now').on('click', function (e) {
    "use strict";
    if ($('input[name=paymentmode]:checked').length == 0) {
        $(".payment_error").removeClass('d-none');
        return false;
    } else {
        $(".payment_error").addClass('d-none');
    }
    $('.buy_now').prop("disabled", true);
    if (payment_type == '1') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: buyurl,
            type: 'post',
            data: {
                amount: grand_total,
                plan_id: plan_id,
                payment_type: payment_type,
                payment_id: '',
                discount: discount,
                offer_code: offer_code,

            },
            success: function (response) {
                if (response.status == 0) {
                    $('.buy_now').prop("disabled", false);
                    toastr.error(response.message);
                    return false;
                } else {
                    window.location.href = planlisturl;
                }
            },
            error: function (error) {
                $('.buy_now').prop("disabled", false);
                toastr.error(wrong);
                return false;
            }
        });
    }
    // RazorPay
    if (payment_type == '2') {
        var options = {
            "key": api_key,
            "amount": parseFloat(grand_total * 100),
            "name": title,
            "description": description,
            "image": 'https://badges.razorpay.com/badge-light.png',
            "handler": function (response) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: buyurl,
                    type: 'post',
                    data: {
                        amount: grand_total,
                        plan_id: plan_id,
                        payment_type: payment_type,
                        payment_id: response.razorpay_payment_id,
                        discount: discount,
                        offer_code: offer_code,
                    },
                    success: function (response) {
                        if (response.status == 0) {
                            $('.buy_now').prop("disabled", false);
                            toastr.error(response.message);
                            return false;
                        } else {
                            window.location.href = planlisturl;
                        }
                    },
                    error: function (error) {
                        $('.buy_now').prop("disabled", false);
                        toastr.error(wrong);
                        return false;
                    }
                });
            },
            "modal": {
                "ondismiss": function () {
                    $('.buy_now').prop("disabled", false);
                }
            },
            "prefill": {
                "name": user_name,
                "email": user_email,
                "contact": user_mobile,
            },
            "theme": {
                "color": "#528FF0"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
        e.preventDefault();
    }
    // Stripe
    if (payment_type == '3') {

        stripe.createToken(card).then(function (result) {
            if (result.error) {
                $('.buy_now').prop("disabled", false);
                $('.stripe_error').html(result.error.message);
                return false;
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: buyurl,
                    type: 'post',
                    data: {
                        amount: grand_total,
                        plan_id: plan_id,
                        currency: currency,
                        payment_type: payment_type,
                        payment_id: result.token.id,
                        discount: discount,
                        offer_code: offer_code,
                    },
                    success: function (response) {
                        if (response.status == 0) {
                            $('.buy_now').prop("disabled", false);
                            toastr.error(response.message);
                            return false;
                        } else {
                            window.location.href = planlisturl;
                        }
                    },
                    error: function (error) {
                        $('.buy_now').prop("disabled", false);
                        toastr.error(wrong);
                        return false;
                    }
                });
            }
        });
    }
    // Flutterwave
    if (payment_type == '4') {
        FlutterwaveCheckout({
            public_key: api_key,
            tx_ref: user_name,
            amount: price,
            currency: currency,
            payment_options: "",
            customer: {
                email: user_email,
                phone_number: user_mobile,
                name: user_name,
            },
            callback: function (response) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: buyurl,
                    type: 'post',
                    data: {
                        amount: grand_total,
                        plan_id: plan_id,
                        payment_type: payment_type,
                        payment_id: response.flw_ref,
                        discount: discount,
                        offer_code: offer_code,
                    },
                    success: function (response) {
                        if (response.status == 0) {
                            $('.buy_now').prop("disabled", false);
                            toastr.error(response.message);
                            return false;
                        } else {
                            window.location.href = planlisturl;
                        }
                    },
                    error: function (error) {
                        $('.buy_now').prop("disabled", false);
                        toastr.error(wrong);
                        return false;
                    }
                });
            },
            onclose: function () {
                $('.buy_now').prop("disabled", false);
            },
            customizations: {
                title: title,
                description: description,
                logo: "https://flutterwave.com/images/logo/logo-mark/full.svg",
            },
        });
    }
    // Paystack
    if (payment_type == '5') {
        var handler = PaystackPop.setup({
            key: api_key,
            email: user_email,
            amount: grand_total * 100,
            currency: currency, // Use GHS for Ghana Cedis or USD for US Dollars
            callback: function (response) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: buyurl,
                    type: 'post',
                    data: {
                        amount: grand_total,
                        plan_id: plan_id,
                        payment_type: payment_type,
                        payment_id: response.reference,
                        discount: discount,
                        offer_code: offer_code,
                    },
                    success: function (response) {
                        if (response.status == 0) {
                            $('.buy_now').prop("disabled", false);
                            toastr.error(response.message);
                            return false;
                        } else {
                            window.location.href = planlisturl;
                        }
                    },
                    error: function (error) {
                        $('.buy_now').prop("disabled", false);
                        toastr.error(wrong);
                        return false;
                    }
                });
            },
            onClose: function () {
                $('.buy_now').prop("disabled", false);
            },
        });
        handler.openIframe();
    }
    // Banktransfer
    if (payment_type == '6') {
        $('#payment_description').html($('#bank_payment').val());
        $('#modal_plan_id').val(plan_id);
        $('#modal_payment_type').val(payment_type);
        $('#modal_amount').val(grand_total);
        $('#modal_offer_code').val(offer_code);
        $('#modal_discount').val(discount);
        $('#modalbankdetails').modal('show');
        $("#modalbankdetails").on('hidden.bs.modal', function (e) {
            $('.buy_now').prop("disabled", false);
        });
    }
    // Mercado pago
    if (payment_type == '7') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: buyurl + '/mercadorequest',
            data: {
                amount: grand_total,
                plan_id: plan_id,
                plan_name: plan_name,
                plan_description: plan_description,
                payment_type: payment_type,
                payment_id: "",
                successurl: buyurl + '/paymentsuccess/success',
                failureurl: location.href,
                discount: discount,
                offer_code: offer_code,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    $('.buy_now').prop("disabled", false);
                    toastr.error(response.message);
                    return false;
                }
            },
            error: function (error) {
                $('.buy_now').prop("disabled", false);
                toastr.error(wrong);
                return false;
            }
        });
    }
    // PayPal
    if (payment_type == '8') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: buyurl + '/paypalrequest',
            data: {
                amount: grand_total,
                plan_id: plan_id,
                plan_name: plan_name,
                plan_description: plan_description,
                payment_type: payment_type,
                payment_id: "",
                successurl: buyurl + '/paymentsuccess/success',
                failureurl: location.href,
                return: '1',
                discount: discount,
                offer_code: offer_code,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    $(".callpaypal").trigger("click")
                } else {
                    $('.buy_now').prop("disabled", false);
                    toastr.error(response.message);
                    return false;
                }
            },
            error: function (error) {
                $('.buy_now').prop("disabled", false);
                toastr.error(wrong);
                return false;
            }
        });
    }

    // myfatoorah
    if (payment_type == '9') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: buyurl + '/myfatoorahrequest',
            data: {
                amount: grand_total,
                plan_id: plan_id,
                plan_name: plan_name,
                plan_description: plan_description,
                payment_type: payment_type,
                payment_id: "",
                successurl: buyurl + '/paymentsuccess/success',
                failureurl: location.href,
                return: '1',
                discount: discount,
                offer_code: offer_code,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    $('.buy_now').prop("disabled", false);
                    toastr.error(response.message);
                    return false;
                }
            },
            error: function (error) {
                $('.buy_now').prop("disabled", false);
                toastr.error(wrong);
                return false;
            }
        });
    }

    //toyyibpay
    if (payment_type == '10') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: buyurl + '/toyyibpay',
            data: {
                amount: grand_total,
                plan_id: plan_id,
                plan_name: plan_name,
                plan_description: plan_description,
                payment_type: payment_type,
                payment_id: "",
                successurl: buyurl + '/paymentsuccess/success',
                failureurl: location.href,
                discount: discount,
                offer_code: offer_code,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    $('.buy_now').prop("disabled", false);
                    toastr.error(response.message);
                    return false;
                }
            },
            error: function (error) {
                $('.buy_now').prop("disabled", false);
                toastr.error(wrong);
                return false;
            }
        });
    }

    //phonepe
    if (payment_type == '11') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: buyurl + '/phonepe',
            data: {
                amount: grand_total,
                plan_id: plan_id,
                plan_name: plan_name,
                plan_description: plan_description,
                payment_type: payment_type,
                payment_id: "",
                successurl: buyurl + '/paymentsuccess/success',
                failureurl: location.href,
                discount: discount,
                offer_code: offer_code,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    $('.buy_now').prop("disabled", false);
                    toastr.error(response.message);
                    return false;
                }
            },
            error: function (error) {
                $('.buy_now').prop("disabled", false);
                toastr.error(wrong);
                return false;
            }
        });
    }

    //paytab
    if (payment_type == '12') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: buyurl + '/paytab',
            data: {
                amount: grand_total,
                plan_id: plan_id,
                plan_name: plan_name,
                plan_description: plan_description,
                payment_type: payment_type,
                payment_id: "",
                successurl: buyurl + '/paymentsuccess/success',
                failureurl: location.href,
                discount: discount,
                offer_code: offer_code,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    $('.buy_now').prop("disabled", false);
                    toastr.error(response.message);
                    return false;
                }
            },
            error: function (error) {
                $('.buy_now').prop("disabled", false);
                toastr.error(wrong);
                return false;
            }
        });
    }

    //mollie
    if (payment_type == '13') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: buyurl + '/mollie',
            data: {
                amount: grand_total,
                plan_id: plan_id,
                plan_name: plan_name,
                plan_description: plan_description,
                payment_type: payment_type,
                payment_id: "",
                successurl: buyurl + '/paymentsuccess/success',
                failureurl: location.href,
                discount: discount,
                offer_code: offer_code,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    $('.buy_now').prop("disabled", false);
                    toastr.error(response.message);
                    return false;
                }
            },
            error: function (error) {
                $('.buy_now').prop("disabled", false);
                toastr.error(wrong);
                return false;
            }
        });
    }

    //khalti
    if (payment_type == '14') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: buyurl + '/khalti',
            data: {
                amount: grand_total,
                plan_id: plan_id,
                plan_name: plan_name,
                plan_description: plan_description,
                payment_type: payment_type,
                payment_id: "",
                successurl: buyurl + '/paymentsuccess/success',
                failureurl: location.href,
                discount: discount,
                offer_code: offer_code,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    $('.buy_now').prop("disabled", false);
                    toastr.error(response.message);
                    return false;
                }
            },
            error: function (error) {
                $('.buy_now').prop("disabled", false);
                toastr.error(wrong);
                return false;
            }
        });
    }

    //xendit
    if (payment_type == '15') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: buyurl + '/xendit',
            data: {
                amount: grand_total,
                plan_id: plan_id,
                plan_name: plan_name,
                plan_description: plan_description,
                payment_type: payment_type,
                payment_id: "",
                successurl: buyurl + '/paymentsuccess/success',
                failureurl: location.href,
                discount: discount,
                offer_code: offer_code,
            },
            method: 'POST',
            success: function (response) {
                if (response.status == 1) {
                    window.location.href = response.redirecturl;
                } else {
                    $('.buy_now').prop("disabled", false);
                    toastr.error(response.message);
                    return false;
                }
            },
            error: function (error) {
                $('.buy_now').prop("disabled", false);
                toastr.error(wrong);
                return false;
            }
        });
    }
});
function applyCopon() {
    $('#couponmodal').modal('hide');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: applycouponurl,
        method: 'post',
        data: {
            promocode: $('#promocode').val(),
            sub_total: sub_total,
        },
        success: function (response) {
            if (response.status == 1) {
                location.reload();
            } else {
                toastr.error(response.message);
                $('#couponmodal').modal('hide');
            }
        }
    });
}
function removecoupon() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: removecouponurl,
        method: 'post',
        data: {
            promocode: $('#promocode').val()
        },
        success: function (response) {
            if (response.status == 1) {
                location.reload();
            }
            else {
                toastr.error(response.message);
            }
        }
    });
}
function copy(offer_code) {
    $('#couponmodal').modal('hide');
    $('#promocode').val(offer_code);
}