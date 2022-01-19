/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */

"use strict";

// Below Function Executes On Form Submit

$(document).on('click', '.addtocart', function() {
    var commodityID = $(this).val();
    var qty = $('#qty' + commodityID).val();
    if (qty.match(/^\d+$/)) {

        $.ajax({
            type: 'POST',
            url: '../scripts/scripts',
            data: {
                commodityID: commodityID,
                qty: qty,
                addtocart: 1
            },
            dataType: 'json',

            success: function(response) {
                if (response.error) {
                    swal('Error', 'Commodity already in your purchase cart', 'error');
                } else {
                    swal('Successful. Commodity successfully added to your purchase cart.', {
                        buttons: false,
                        timer: 3000,
                    });
                    showCart();
                }

            }


        });

    } else if (qty == "") {
        swal('Error', 'Enter a quantity', 'error');
    } else {
        swal('Error', 'Enter a numeric value', 'error');
    }
});

$('#loanpaymentform').submit(function(e) {
    e.preventDefault();
    var loanpaymentform = $(this).serialize();
    var amount = $('#amount').val();

    if (amount.match(/^\d+$/)) {
        iziToast.success({
            title: 'Hold tight!',
            message: 'Processing payment',
            position: 'topRight'
        });
        $.ajax({
            type: 'POST',
            url: '../scripts/scripts',
            data: loanpaymentform,
            dataType: 'json',

            success: function(response) {
                if (response.error) {
                    swal('Error', 'Sorry an error occured', 'error');
                } else {
                    swal('Successful. Loan repayment successful!.', {
                        buttons: true,
                        timer: 2000,
                    });
                    setTimeout(function() {
                        window.location.replace("loans");
                    }, 3000);
                }

            }


        });

    } else if (qty == "") {
        swal('Error', 'Enter a quantity', 'error');
    } else {
        swal('Error', 'Enter a numeric value', 'error');
    }
});


$('#loanrequestform').submit(function(e) {
    e.preventDefault();
    var loanrequestform = $(this).serialize();
    var amount = $('#amount').val();

    if (amount.match(/^\d+$/)) {
        iziToast.success({
            title: 'Hold tight!',
            message: 'Processing request',
            position: 'topRight'
        });
        $.ajax({
            type: 'POST',
            url: '../scripts/scripts',
            data: loanrequestform,
            dataType: 'json',

            success: function(response) {
                if (response.error) {
                    swal('Error', 'Sorry an error occured', 'error');
                } else {
                    swal('Successful. Loan request submitted!.', {
                        buttons: true,
                        timer: 2000,
                    });
                    setTimeout(function() {
                        window.location.replace("loans");
                    }, 3000);
                }

            }


        });

    } else if (qty == "") {
        swal('Error', 'Enter a quantity', 'error');
    } else {
        swal('Error', 'Enter a numeric value', 'error');
    }
});

$('#depositform').submit(function(e) {
    var depositform = $(this).serialize();
    var amount = $('#amount').val();
    swal('Successful. You payment has been initiated successfully.', {
        buttons: true,
    });
    if (amount.match(/^\d+$/)) {

        $.ajax({
            type: 'POST',
            url: '../scripts/scripts',
            data: depositform,
            dataType: 'json',

            success: function(response) {
                if (response.error) {
                    swal('Error', 'Sorry an error occured', 'error');
                } else {
                    swal('Successful. Payment initiated.', {
                        buttons: false,
                        timer: 3000,
                    });
                    setTimeout(function() {
                        window.location.replace("my-transactions");
                    }, 3000);
                }

            }


        });

    } else if (qty == "") {
        swal('Error', 'Enter a quantity', 'error');
    } else {
        swal('Error', 'Enter a numeric value', 'error');
    }
});

$('#withdrawform').submit(function(e) {
    e.preventDefault();
    var withdrawform = $(this).serialize();
    var amount = $('#amount').val();
    swal('Successful. You payment has been initiated successfully.', {
        buttons: true,
    });
    if (amount.match(/^\d+$/)) {

        $.ajax({
            type: 'POST',
            url: '../scripts/scripts',
            data: withdrawform,
            dataType: 'json',

            success: function(response) {
                if (response.error) {
                    swal('Error', 'Sorry an error occured', 'error');
                } else {
                    swal('Successful. Payment initiated.', {
                        buttons: false,
                        timer: 3000,
                    });
                    e.currentTarget.submit();
                    setTimeout(function() {
                        window.location.replace("my-transactions");
                    }, 3000);
                }

            }


        });

    } else if (qty == "") {
        swal('Error', 'Enter a quantity', 'error');
    } else {
        swal('Error', 'Enter a numeric value', 'error');
    }
});

$('#callback').submit(function(e) {
    e.preventDefault();
    var callback = $(this).serialize();
    var amount = $('#amount').val();

    $.ajax({
        type: 'POST',
        url: '../coinpayments/callback',
        data: callback,
        dataType: 'json',

        success: function(response) {
            if (response.error) {

                setTimeout(function() {
                    iziToast.error({
                        title: 'Sorry!',
                        message: 'An error occured',
                        position: 'topRight'
                    });
                }, 3000);
            } else {
                swal('Done', 'Your payment has been confirmed!', 'success');
                setTimeout(function() {
                    e.currentTarget.submit();
                }, 3000);


            }

        }


    });


});


$(document).on('click', '.sell', function() {
    var commodityID = $(this).val();
    var qty = $('#qty' + commodityID).val();
    if (qty.match(/^\d+$/)) {

        $.ajax({
            type: 'POST',
            url: '../scripts/scripts',
            data: {
                commodityID: commodityID,
                qty: qty,
                sell: 1
            },
            dataType: 'json',

            success: function(response) {
                if (response.error) {
                    swal('Error', 'Commodity already in your purchase cart', 'error');
                } else {
                    swal('Successful. Commodity successfully added to your cart.', {
                        buttons: false,
                        timer: 3000,
                    });
                    showCart();
                }

            }


        });

    } else if (qty == "") {
        swal('Error', 'Enter a quantity', 'error');
    } else {
        swal('Error', 'Enter a numeric value', 'error');
    }
});



$('#checkout_form').submit(function(e) {
    e.preventDefault();
    var checkout_data = $(this).serialize();
    $("#button").addClass("disabled btn-progress");
    // Storing Field Values In Variables
    swal('Hold tight, Processing payment!', {
        buttons: false,
        timer: 20000,
    });
    $.ajax({
        type: 'POST',
        url: '../scripts/scripts',
        data: checkout_data,
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                swal('Sorry!', 'An error occured. Please try again another time.', 'error');
            } else {
                swal('Successful. You payment has been processed successfully.', {
                    buttons: true,
                });

                setTimeout(function() {
                    window.location.replace("transactions");
                }, 5000);

            }

        }
    });
});

$('#sell_form').submit(function(e) {
    e.preventDefault();
    var sell_data = $(this).serialize();
    $("#button").addClass("disabled btn-progress");
    // Storing Field Values In Variables
    swal('Hold tight, Processing payment!', {
        buttons: false,
        timer: 20000,
    });
    $.ajax({
        type: 'POST',
        url: '../scripts/scripts',
        data: sell_data,
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                swal('Sorry!', 'An error occured. Please try again another time.', 'error');
            } else {
                swal('Successful. Your request has been submitted.', {
                    buttons: true,
                });

                setTimeout(function() {
                    window.location.replace("transactions");
                }, 5000);

            }

        }
    });
});






function showCart() {
    $.ajax({
        url: "../scripts/fetch",
        method: "POST",
        data: {
            fetchcart: 1,
        },
        success: function(response) {
            $('#cart_area').html(response);
        }
    });
}