$(function(){
    // disable twice send a form
    var stopajax=0;

    $('#new-number').submit(function(event){
        event.preventDefault(); 
        event.stopImmediatePropagation();
        if (!stopajax) {
            stopajax=1;
            var msg=$(this).serialize();
            $.ajax({
                type:'POST',
                url:'phone-number/create',
                data:msg,
                //async: false,
                success:function(data){
                    stopajax=0;
                    console.log(data);
                    switch (data) {
                        case 'success create':
                            $('h4.modal-title').html('<h2 style="color:green">Success!</h2>');
                            setTimeout(function(){
                                $('#modal-create').modal('hide');
                                location.reload();
                            },2000);
                            break;
                        default:
                            var errors = data.split('//');
                            $('h4.modal-title').html('<span style="color:red">'+errors[0]+'</span>');
                        // errors.forEach(function(item,i,arr){
                        //     console.log(item);
                        // });
                    }
                },
                error:function(xhr,str){
                    stopajax=0;
                    alert('Error! Look at the console ( press f12 )');
                    console.log(xhr);
                    console.log(str);
                }
            });
        }
    });

    $('a[title="Delete"]').css('color','red');
});