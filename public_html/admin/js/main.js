//TINYMCE
tinymce.init({
    selector: ".tinymce",
    forced_root_block: false,
    language: "ru"

});

function tinymceInit(){
    tinymce.init({
        selector: ".tinymce-2",
        forced_root_block: false,
        language: "ru",
        menubar: false,
        statusbar: false,
        toolbar: false
    });
}
tinymceInit();
$(".dynamicform_wrapper_goods").on("afterInsert", function(e, item) {
    tinymceInit();
});

//DATEPICKER
$(document).ready(function(){
    $('.datepicker').pickadate({
        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd'
    });
});
//DATEPICKER REFRESH
$(".dynamicform_wrapper_payments, .dynamicform_wrapper_warranty, .dynamicform_wrapper_purchasing, .dynamicform_wrapper_delivery").on("afterInsert", function(e, item) {
    $(item).find("[type=checkbox]").prop('checked', false)
    $('.datepicker').pickadate({
        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd'
    });
    $(item).find('.order-file-link, .order-file-delete').remove();
    $(item).find('.order-file-input').removeClass('hidden');
});
$(document).ready(function(){
    function hide(val){
        if (val == 0){
            $('.add-delivery').fadeIn('fast');
        }else{
            $('.add-delivery').fadeOut('fast');
        }
    }
    var dropDown = $("#orders-delivery");
    hide(dropDown.val());
    dropDown.on('change', function(){
        hide(dropDown.val());
    });
});
//CONFIRM
$('.btn-danger, .confirm-msg').on('click', function(e){
    if(confirm('Вы точно хотите удалить?')){
        return true;
    }else{
        return false;
    }
});


$(document).ready(function(){
    $(document).on('keyup change click', "td", function(){
        var taxT;
        var totalT;

        var allT = 0;
        var allN = 0;

        var allTotal =      $("[data-name='all-total']");
        var allTax =        $("[data-name='all-nds']");

        var parent =        $(this).parent();
        var cost =          $(parent).find("[data-name='cost']");
        var quantity =      $(parent).find("[data-name='quantity']");
        var discount =      $(parent).find("[data-name='discount']");
        var tax =           $(parent).find("[data-name='tax']");
        var taxInclude =    $(parent).find("[data-name='taxInclude']");
        var taxTotal =      $(parent).find("[data-name='tax-total']");
        var total =         $(parent).find("[data-name='total']");


        if(taxInclude.prop('checked')){
            taxT = (( cost.val() * quantity.val() ) - discount.val()) * tax.val() / (100 - (-tax.val()));
            totalT = ( cost.val() * quantity.val() ) - discount.val();
        }else{
            taxT = (( cost.val() * quantity.val() ) - discount.val()) / 100 * tax.val();
            totalT = ( cost.val() * quantity.val() ) - discount.val() + taxT;
        }

        taxTotal.val(taxT.toFixed(2));
        total.val(totalT.toFixed(2));


        $("[data-name='total']").each(function(){
            allT = allT -(-$(this).val());
        });

        $("[data-name='tax-total']").each(function(){
            allN = allN -(-$(this).val());
        });

        allTotal.val(allT.toFixed(2));
        allTax.val(allN.toFixed(2));
    });
});