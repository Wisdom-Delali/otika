/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */

"use strict";

// Below Function Executes On Form Submit
function addtocart(commodityID) {
    var commodityID = commodityID;
    $.ajax({
        type: 'POST',
        url: '../scripts/scripts',
        data: { commodityID: commodityID, },
        dataType: 'json',
        addtocart: 1,
        success: function(response) {
            if (response.error) {
                swal('Error', 'Commodity already in your cart', 'error');
            } else {
                swal('Successful. Commodity successfully added to your cart.', {
                    buttons: false,
                    timer: 3000,
                });
                showCart();
            }

        }
    });


}


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