<!DOCTYPE html>
<html>

<?php 
        $segment1 = strtolower($this->uri->segment(1));
        $segment2 = strtolower($this->uri->segment(2));
        $segments_arr['segment1']= $segment1;
        $js_file = $segment1;

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>RPTAS</title>

    <link href="<?php echo base_url()?>/assets/MDB/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="<?php echo base_url()?>/assets/MDB/css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="<?php echo base_url()?>/assets/MDB/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url()?>/assets/MDB/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>/assets/MDB/css/addons/datatables.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>/assets/MDB/css/addons/datatables-select.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/CustomSidebar/sidenav.css">
    <link rel="stylesheet" href="<?php echo base_url()?>/assets/fontawesome-5.9.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/assets/datepicker/calendar/lib/bootstrap-datepicker.css" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/assets/CustomSidebar/customscroll.css" >
    <link href="<?php echo base_url()?>assets/css/sweetalert.css" rel="stylesheet" />

    <style media="screen">
    html {
  scroll-behavior: smooth;
  }
  body{
    width: auto;
    height: auto;
    background-image: url(<?php echo base_url().'assets/img/concrete_seamless.png'?>) ;
    overflow:auto;
  }
  .form-rounded {
border-radius: 5rem;
}

.navbar{

z-index: 1;

}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance:textfield;
}

.modal-dialog-fs {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
}

.modal-content-fs {
  height: auto;
  min-height: 100%;
  border-radius: 0;
}


    </style>

</head>

       
          

  

        

        <?php 
         switch ($segment1) {



                    case '':
                      
                      $this->load->view('login/index');
                      $js_file = 'Login';
                      break;
                    case 'login':
                      $this->load->view('login/index');
                      $js_file = 'Login';
                    break;

                    case 'dashboard':
                        $this->load->view('nav/sidenav',$segments_arr);
                        echo '<div class="main-panel">';
                         $this->load->view('pages/dashboard');
                        break; 

                    case 'user_management':
                      $this->load->view('nav/sidenav',$segments_arr);
                      echo '<div class="main-panel">';
                      $this->load->view('pages/user_management');
                      break; 

                      case 'payment':
                        $this->load->view('nav/sidenav',$segments_arr);
                        echo '<div class="main-panel">';
                        $this->load->view('pages/payment');
                        break;

                      case 'compromise':
                        $this->load->view('nav/sidenav',$segments_arr);
                        echo '<div class="main-panel">';
                        $this->load->view('pages/compromise');
                        break;

                      case 'land_and_owners':
                        $this->load->view('nav/sidenav',$segments_arr);
                        echo '<div class="main-panel">';
                        $this->load->view('pages/land_and_owners');
                        break;

                        case 'tax_order_assessment':
                          $this->load->view('nav/sidenav',$segments_arr);
                          echo '<div class="main-panel">';
                          $this->load->view('pages/tax_order_assessment');
                          break;

                      case 'clearance':
                        $this->load->view('nav/sidenav',$segments_arr);
                        echo '<div class="main-panel">';
                        $this->load->view('pages/clearance');
                        break;

                        case 'audit_trail':
                          $this->load->view('nav/sidenav',$segments_arr);
                          echo '<div class="main-panel">';
                          $this->load->view('pages/audit_trail');
                          break;
                    
                    
                   
                        


                    default:
                        echo $segment2;
                        break;
                }
        ?>

            
        </div>
   






</div>
    </div>
    <div class="overlay"></div>
    <script src="<?php echo base_url()?>assets/js/sweetalert2@9.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> -->
<script type="text/javascript" src="<?php echo base_url()?>/assets/MDB/js/jquery-3.4.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="<?php echo base_url()?>/assets/MDB/js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?php echo base_url()?>/assets/MDB/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="<?php echo base_url()?>/assets/MDB/js/mdb.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/datepicker/calendar/lib/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/global.js"></script>


<!-- Custom JS HERE -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/'.ucwords($js_file)?>.js"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/nav.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/function.js'?>"></script>




<script type="text/javascript" src="<?php echo base_url()?>/assets/js/inputmask.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/MDB/js/addons/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/MDB/js/addons/datatables-select.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/charts/charts.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/js/jquery.num2words.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/CustomSidebar/customscroll.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/CustomSidebar/growl.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/js/jquery.json.min.js"></script>


 
 



<script type="text/javascript">

    //
    // document.getElementById('ceno').onchange = function() {
		// 		document.getElementById('Cenro').disabled = !this.checked;
		// };
		// document.getElementById('zoning').onchange = function() {
		// 		document.getElementById('Zoning').disabled = !this.checked;
		// };
    //
		// document.getElementById('checkvet').onchange = function() {
		// 		document.getElementById('Veteran').disabled = !this.checked;
		// };


    $(document).ready(function () {


    $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });
                $('#dismiss, .overlay').on('click', function () {
                    $('#sidebar').removeClass('active');
                    $('.overlay').removeClass('active');
                });
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').addClass('active');
                    $('.overlay').addClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });

  $('#approvaltable').DataTable();
  $('.dataTables_length').addClass('bs-select');




  $('.money2').mask("#,##0.00", {reverse: true});
  $('.money3').mask("#,##0.00", {reverse: true});
  $('.pin').mask('0000');
  $('.cell').mask('0000-000-0000' );
  $('.tel').mask('(000)000' );
  $('.postcode').mask('0000' );
  $('.date').mask('yyyy/dd/mm' );
  $('.tin').mask('0000-0000-0000-0000' );
 })

 
 $('#click_advance_appr').click(function() {
    $('#display_advance_appr').toggle('1000');
    $("i", this).toggleClass("fa-angle-down fa-angle-up");
});

$('#click_advance_form').click(function() {
    $('#display_advance_form').toggle('1000');
    $("i", this).toggleClass("fa-angle-down fa-angle-up");
});

$('#click_advance_btax').click(function() {
    $('#display_advance_btax').toggle('1000');
    $("i", this).toggleClass("fa-angle-down fa-angle-up");
});

$('#click_advance_pay').click(function() {
    $('#display_advance_pay').toggle('1000');
    $("i", this).toggleClass("fa-angle-down fa-angle-up");
  });

$('#click_advance_realease').click(function() {
    $('#display_advance_realease').toggle('1000');
    $("i", this).toggleClass("fa-angle-down fa-angle-up");
  });

$('#click_advance_ammend').click(function() {
    $('#display_advance_ammend').toggle('1000');
    $("i", this).toggleClass("fa-angle-down fa-angle-up");
});
$('.dates #usr1').datepicker({
      'format': 'yyyy-mm-dd',
      'autoclose': true
    });

    $('.dates #date_appltn').datepicker({
      'format': 'yyyy-mm-dd',
      'autoclose': true
    });


$("#menu-toggle").click(function(e) {
   e.preventDefault();
   $("#wrapper").toggleClass("toggled");
 });

</script>
</body>

</html>
