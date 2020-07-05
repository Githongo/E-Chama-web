$(document).ready(function(){
    if($('#checkout-id').val().trim() != ''){
        window.alert('Empty for real');
    }else{
        $.ajax({
            url: "/payment/status",
            type: "get",
            success: function(data){
                if(data['ResultCode'] == "0"){
                    //setting key in textarea
                    console.log('Payment request successfull');
                    $('#responseData').val(data['ResultDesc']);

                }
                if(data['ResultCode'] == "17"){
                    //setting key in textarea
                    console.log('Payment request limited');
                    $('#responseData').val(data['ResultDesc']);

                }
                if(data['ResultCode'] == "1032"){
                    //setting key in textarea
                    console.log('Payment request cancelled');
                    $('#responseData').val(data['ResultDesc']);

                }
                if(data['errorCode'] == "500.001.1001"){
                    //setting key in textarea
                    console.log('Payment request successfull');
                    $('#responseData').val(data['errorMessage']);

                }
            }
        });
    }
    

        
        
        
});