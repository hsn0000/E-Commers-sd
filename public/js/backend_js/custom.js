   /*  --- */    
   $('.price-input').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: ',',
        centsLimit: 2
    });
    
    $('.price-input-Rp').priceFormat({
        prefix: 'Rp ',
        centsSeparator: '.',
        thousandsSeparator: ',',
        centsLimit:2
    });
    
    $('.price-input-usd').priceFormat({
        prefix: '$',
        centsSeparator: '.',
        thousandsSeparator: ',',
        centsLimit: 2
    });

    $('.price-input-no-cent').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: ',',
        centsLimit: 0
    }); 

    // @error 
    $('#is-invalid-title').keyup(function(keys) {
        var val = this.value
        if(val == '') {
            $('#is-invalid-title').attr('style','border-color:red')
            $('.invalid-feedback').attr('style','display:visible');
        } else {
            $('#is-invalid-title').attr('style','border-color:white')
            $('.invalid-feedback').attr('style','display:none');
        }
    });
    // @enderror 

/*df*/ 
    
(function($) {
    $.fn.inputFilter = function(inputFilter) {
      return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        }
      });
    };
  }(jQuery));

function numberFormat(number, decPlaces, decSep, thouSep) {
    decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
    decSep = typeof decSep === "undefined" ? "." : decSep;
    thouSep = typeof thouSep === "undefined" ? "," : thouSep;
    var sign = number < 0 ? "-" : "";
    var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
    var j = (j = i.length) > 3 ? j % 3 : 0;

    return sign +
        (j ? i.substr(0, j) + thouSep : "") +
        i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
        (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
}

function random_string(length=7){
    let randomStr = Math.random().toString(36).substring(7);
    return randomStr;
}

$(function(){
    
    $('.actions > .btn-add').click(function(){
        var $this=$(this),link=$this.data('link');
        window.location.href = link;
    });


    $('.actions > .btn-save').click(function(){
        var $this=$(this),form=$('#form-table');
        form.submit();
    });


    $('.actions > .btn-edit').click(function(){
        var $this=$(this),form=$('#form-table');
        if($('.child-check:checked').length == 0){
            new PNotify({
                title: ' Caution !',
                text: 'Please select at least one data for process',
                type: 'warning',
                icon: 'icon icon-exclamation-sign'
            });
            return
        } 
        form.attr('action', $this.data('link')).submit();
    });


    $('.actions > .btn-cancel').click(function(){
        var $this=$(this),link=$this.data('link');
        window.location.href = link;
    });


    $('.actions > .btn-delete').click(function(){
        var $this=$(this),link=$this.data('link'),form=$('#form-table');
        if($('.child-check:checked').length > 0){

            Swal.fire({
                title: 'Confirm Delete',
                text: "Are you sure want to delete this data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
              }).then((result) => {
                if (result.value) {

                    let timerInterval
                    Swal.fire({
                        title: 'Waiting !',
                        html: 'the process will be finished <b></b> milliseconds.',
                        timer: 1000,
                        timerProgressBar: true,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {
                            const content = Swal.getContent()
                            if (content) {
                                const b = content.querySelector('b')
                                if (b) {
                                b.textContent = Swal.getTimerLeft()
                                }
                            }
                        }, 200)
                    },
                        onClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            form.attr('action', link).submit();
                        }
                    })

                }
            })
        }
        else{
            new PNotify({
                title: 'Caution !',
                text: 'Please select at least one data for process',
                type: 'warning',
                icon: 'icon icon-exclamation-sign'
            });
            return
        }
    });


    $('.action > .btn-add-image').click(function() {
        var id = $('.child-check:checked').attr('id'),$this=$(this),link=$this.data('link');
        if($('.child-check:checked').length == 0) {
            if($('.child-check:checked').length == 0){
                new PNotify({
                    title: ' Caution !',
                    text: 'Please select at least one data for process',
                    type: 'warning',
                    icon: 'icon icon-exclamation-sign'
                });
                return
            } 
        }
        var ids = id.split("-")
        window.location.href = link+ids[1]
        return
    })


    $('.action > .btn-add-attribute').click(function() {
        var id = $('.child-check:checked').attr('id'),$this=$(this),link=$this.data('link');
        if($('.child-check:checked').length == 0) {
            if($('.child-check:checked').length == 0){
                new PNotify({
                    title: ' Caution !',
                    text: 'Please select at least one data for process',
                    type: 'warning',
                    icon: 'icon icon-exclamation-sign'
                });
                return
            } 
        }
        var ids = id.split("-")
        window.location.href = link+ids[1]
        return
    })


    $('.action > .btn-order-invoice').click(function() {
    var id = $('.child-check:checked').attr('id'),$this=$(this),link=$this.data('link');
    if($('.child-check:checked').length == 0) {
        if($('.child-check:checked').length == 0){
            new PNotify({
                title: ' Caution !',
                text: 'Please select at least one data for process',
                type: 'warning',
                icon: 'icon icon-exclamation-sign'
            });
            return
        } 
    }
        var ids = id.split("-")
        window.open(link+'/'+ids[1], '_blank');
        return
    })


    $('.action > .btn-order-details').click(function() {
    var id = $('.child-check:checked').attr('id'),$this=$(this),link=$this.data('link');
    if($('.child-check:checked').length == 0) {
        if($('.child-check:checked').length == 0){
            new PNotify({
                title: ' Caution !',
                text: 'Please select at least one data for process',
                type: 'warning',
                icon: 'icon icon-exclamation-sign'
            });
            return
        } 
    }
        var ids = id.split("-")
        window.open(link+'/'+ids[1], '_blank');
        return
    })


    $('.input-daterange').datepicker({
        format: "mm-yyyy",
        startDate: "-1m",
        endDate: "0m",
        minViewMode: 1,
        multidate: false
    });
    

        // $('.date-period').flatpickr({
    //     maxDate: new Date().fp_incr(0),
    //     plugins: [
    //         new monthSelectPlugin({
    //             shorthand: true,
    //             dateFormat: "m-Y",
    //             altFormat: "F Y",
    //             theme: "dark"
    //         })
    //     ]
    // });

    $('label.required').each(function(){
        $(this).html($(this).text()+' <span class="required-text">*</span>')
    });


    $(".numeric").inputFilter(function(value) {
        return /^\d*$/.test(value); 
    });


    $(".alphabetic").inputFilter(function(value) {
        return /^[a-z]*$/i.test(value);
    });


    $('body').delegate('.toupper', 'keyup', function(){
    	this.value = this.value.toUpperCase();
    });


    $('body').delegate('.detail-link', 'click', function(){
        var $this=$(this);
        if($this.attr('data-href'))
        document.location.href = $this.attr('data-href');
    });


    if($('.table').is('table'))
    {           
        $('#data-table_wrapper').prepend('<div class="dataTables__top"></div>');
        $('#data-table_filter').appendTo('.dataTables__top');
        $('#data-table_length').appendTo('.dataTables__top');
    }


    $('body').delegate('.main-check', 'click', function(){
        var $this=$(this);
        if($this.prop('checked')){
            $('.main-check').prop('checked',true);
            $('.child-check').prop('checked',true);
        }
        else{
            $('.main-check').prop('checked',false);
            $('.child-check').prop('checked',false);
        }
    });


    $('body').delegate('.child-check', 'click', function(){
        var $this=$(this),child=$('.child-check').length,checked_child=$('.child-check:checked').length;
        if($this.prop('checked')){
            if(child==checked_child){
                $('.main-check').prop('checked',true);
            }
        }
        else{
            $('.main-check').prop('checked',false);
        }
    });


    /*
        Add atribute multiple upload
    */ 
	var maxField = 10; //Input fields increment limitation
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.field_wrapper'); //Input field wrapper
	var fieldHTML = '<div><div class="control-group"><label class="control-label"></label><input type="text" name="sku[]" id="sku" value="" placeholder="SKU" style="width:130px; margin:7px 0;" required/><input type="text" name="size[]" id="size" value="" placeholder="Size" style="width:130px; margin:7px 3px;" required/><input type="text" class="price-input-Rp" name="price[]" id="price" value="" placeholder="Price" style="width:130px; margin:7px 0;" required/><input type="text" class="numeric" name="stock[]" id="stock" value="" placeholder="Stock" style="width:130px; margin:7px 3px;" required/><a href="javascript:void(0);" class="remove_button"><i class="icon-minus" style="margin: 0 0 0 10px;"></i></a></div></div></div>'; //New input field html 
	var x = 1; //Initial field counter is 1
	
	//Once add button is clicked
	$(addButton).click(function()
	{
		//Check maximum number of input fields
		if(x < maxField){ 
			x++; //Increment field counter
			$(wrapper).append(fieldHTML); //Add field html
		}
	});	
	//Once remove button is clicked
	$(wrapper).on('click', '.remove_button', function(e){
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		x--; //Decrement field counter
    });
    
    /*
        end
    */ 



});


