<?php
define("_EXECPERMIT_WNV", true);
require_once ("start.php");
if(!$user->logged_in){redirect_to(SITEURL . "login/");}
$pageTitle = Lang::$say->_GNL_CALENDARS.' - '.$gist->pptname;
include("header.tpl.php");
?>
<div class="rowspan calheading yearly"><h1><?php echo Lang::$say->_GNL_CALENDARS ?><a target="_blank" class="float-end printmodebutton" href="printmode.php"><span class="glyphicon glyphicon-print"></span></a></h1></div>
<div class="rowspan"><div class="msg_bookingdel"></div></div>
<div class="row">

    <div id="yearcalendar" class="cals panel_yearcalendar listpanel_bookingadd listpanel_bookingedit listpanel_bookingdel listpanel_bookinginfo panel_bookingdel">
      <?php $cal->renderCalendar();?>
    </div>
</div>
<?php $cal->modalBlockForms();?>



<script>
    $(document).on('change', 'select[name="category"]', function () {
        $.ajax({
            url: "http://localhost/calendar//controller/controller.php?r=get-vehicle&cat="+this.value,
            method: "GET",
            dataType: "JSON",
            success: function (response) {
                var option = '';
                $.each(response, function (key, value){
                    option  += '<option value="'+value.id+'" data-tokens="'+value.name+'">'+value.name+'</option>';
                })
                $('.changetype').selectpicker('destroy').empty().append(option).selectpicker();
                // console.log(response);
            },
            error: function (error){
                console.log(error);
            }
        })
    })
</script>


<?php include("footer.tpl.php");?>

