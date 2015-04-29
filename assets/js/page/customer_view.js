require(['order!jquery','order!apppath','order!bootstrap'], function($,apppath){


    $('.error').popover({ trigger: "hover" });

    $('.fix').click(function(e){
        e.preventDefault();

        clearTransactionNote(this.id);
        //console.log('id: '+this.id+' value: '+ this.value);
    });

    $('.removeTransaction').on('mouseenter',function(){
        $(this).removeClass('btn-default');
        $(this).addClass('btn-warning');
    });
    $('.removeTransaction').on('mouseout',function(){
        $(this).addClass('btn-default');
        $(this).removeClass('btn-warning');
    });

    $('.removeTransaction').click(function(){

        var tran_sn = $(this).val();
        $('#tran_row_'+tran_sn).addClass('danger');

        var q = confirm("Are you sure to delete the Transaction");
        if(q==true){
            //delete the transaction
            removeTransaction(tran_sn);
        }else{
            $('#tran_row_'+tran_sn).removeClass('danger');

        }
    });

    /**
     * Delete the transaction from database
     * @param _tran_sn
     */
    var removeTransaction=function(_tran_sn)
    {

        $.ajax({
            type: "POST",
            url:apppath+'/transaction/removeTransactionAjax',
            processData:false,
            data:'_tran_sn='+_tran_sn,
            success:function(_result){
                //console.log("Result: "+_result);
                if(_result==1){
                    $('#tran_row_'+_tran_sn).remove();
                }else{
                    $('#tran_row_'+_tran_sn).removeClass('warning');
                }


            },
            error:function(_error){

                alert('Error in performing the operation.');
                console.log("Error: "+_error);
            }//end error

        });//end ajax

    };//end function


    /**
     *  clearTransactionNote Function
     *
     *  Call Transaction Controller function to clear note for the _tran_sn
     */
    var clearTransactionNote=function(_tran_sn)
    {

        $.ajax({
            type: "POST",
            url:apppath+'/transaction/clearNoteAjax',
            processData:false,
            data:'_tran_sn='+_tran_sn,
            success:function(_result){

                var res = JSON.parse(_result);

                var data = $.map(res, function(value, index)
                {
                    if(index=='result' && value == true){
                        //PASSED
                        $('#error_'+_tran_sn).fadeOut(400,function(){
                            $(this).remove();
                        });
                        $('#'+_tran_sn).fadeOut(500,function(){
                            $(this).remove();
                        });

                    }else if(index=='result' && value == false){
                        alert("Operation not successful");
                    }

                });

            },
            error:function(_error){

                alert('Error in performing the operation.');
                console.log("Error: "+_error);
            }
        });//end ajax

    };//end function

});