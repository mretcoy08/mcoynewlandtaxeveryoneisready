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

    <style type="text/css">
    body
    {
        background-color: white;
    }
    table
    {
        width: 100%;
    }
    .header{
        font-family: Old-English;
        font-size: 18px;
        text-align: center;
    }
    .tg  {border-collapse:collapse;border-spacing:0;}
    .tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg .tg-baqh{text-align:center;vertical-align:top}
    .tg .tg-yw4l{vertical-align:top}
    @media print {
      @page { margin: 0; }
      body { margin: 1.6cm; }
    }
    @page { margin: 0; }
    .sub_text{
        text-align: center;
        font-size: 16px;
    }
    .title_text{
        text-align: center;
        font-size: 16px;
    }
    .date{
        font-size: 16px;
    }
    th
    {
        font-weight: bold;
    }
    td
    {
        text-align: center;
    }
    .gray
    {
        background-color:#dedede;
    }
    @media print {
.gray {
    background-color: #dedede !important;
    -webkit-print-color-adjust: exact; 
}}

    </style>
      

</head>

       
          

  

        

        <?php 
         switch ($segment1) {



                    case 'clearance_print':
                      
                      $this->load->view('pages/clearance_print');
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
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
<!-- <script type="text/javascript" src="<?php echo base_url().'assets/js/'.$js_file?>.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url().'assets/js/nav.js'?>"></script>





<script type="text/javascript" src="<?php echo base_url()?>/assets/js/inputmask.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/MDB/js/addons/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/MDB/js/addons/datatables-select.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/charts/charts.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/CustomSidebar/customscroll.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/CustomSidebar/growl.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/js/jquery.json.min.js"></script> -->


 
 



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


  $(document).ready(function(){
    window.print();
  });
</script>
</body>

</html>
