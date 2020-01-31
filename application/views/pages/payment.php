<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb rgba-blue-grey-light py-3 ">
			<li class="breadcrumb-item"><a href="<?php echo base_url() ?>/Dashboard"><i
						class="fas fa-tachometer-alt"></i> Dashboard</a></li>
			<li class="breadcrumb-item active" aria-current="page">Payment</li>
		
		</ol>
	</nav>
</div>


<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                  
                  
                        </div>
                        <div class="card-body">
                           

                        <!-- TABLE ROW -->
                        <div class="row">

                        <div class="col-md-3">
                               
                               <!-- <div class="form-group" style="margin-top:10px;">
                               <label class = "form-label"for="">Year</label>
                                  <select class = "form-control" id = "yearyear">
                                      <option value = "">Please Select</option>
                                  </select>
                               </div>    -->
                           </div>
                          <div class = "col-md-12 col-xs-12">
                            <table id="posts" class="table table-bordered" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width = "15%">Owner</th>
                                        <th width = "15%">Location</th>
                                        <th width = "15%">Pin</th>
                                        <th width = "7%">ARP No.</th>
                                        <th width = "7%">Year Assessed</th>
                                        <th width = "20%" class="disabled-sorting text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                               
                                
                            </table>
                          </div>

                        </div>
                        <!-- END OF TABLE ROW -->

                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
        </div>

    </div>
</div>




<!-- The Modal -->      
<div class="modal fade" id="addPayment">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      
      <div class="modal-header bg-primary">
       
        <h4 class="modal-title text-white" id= "h4user">PAYMENT</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      
      <div class="modal-body">
        <!-- Modal body -->
        <form id = "">
            <h5 class = "text-primary text-center">Owner and Land Information</h5>
            <hr>
            <div class="row">
        

            <div class="col-sm-12">
                <label class = "bmd-label-floating">Owner/s</label>
                <div id ="owners">
                   
                </div>  
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class = "bmd-label-floating">Pin</label>
                    <input type="text" class="form-control payment" name="pin" id="pin" readonly>
                </div>  
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class = "bmd-label-floating">ARP No.</label>
                    <input type="text" class="form-control payment" name="arp" id="arp" readonly>
                </div>  
            </div>

            <div class="col-sm-8">
                <div class="form-group">
                    <label class = "bmd-label-floating">Location</label>
                    <input type="text" class="form-control payment" name="location" id="location" readonly>
                </div>  
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Assessed Value:</label>
                    <input type="text" class="form-control payment payment_decimal" name="assessed_value" id="assessed_value" readonly>
                </div>  
            </div>

        </div>

        
        <hr>
        <h5 class = "text-primary text-center">Payment Information</h5>
        <hr>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <select name="" id="payment_method" name = "payment_method" class = "form-control">
                        <option value="">Select Payment Method</option>
                        <option value="cash">Cash</option>
                        <option value="check">Check</option>
                        <option value="cashandcheck">Cash and Check</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row" id = "name_of_payer">

        <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">First name:</label>
                    <input type="text" class="form-control payment" name="first_name" id="first_name" >
                </div>  
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Middle name:</label>
                    <input type="text" class="form-control payment" name="middle_name" id="middle_name" >
                </div>  
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Last name:</label>
                    <input type="text" class="form-control payment" name="last_name" id="last_name" >
                </div>  
            </div>

            <input type="hidden" id = "payment_id" name = "payment_id">
        
        </div>


    <div class="payment_info">

        <div class="row">

            <div class="col-sm-6">
                <div class="form-group">
                    <label class = "bmd-label-floating">OR Number:</label>
                    <input type="text" class="form-control payment" name="or_number" id="or_number" >
                </div>  
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class = "bmd-label-floating">Date:</label>
                    <input type="date" class="form-control payment" name="or_date" id="or_date" >
                </div>  
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Mode of Payment:</label>
                    <select class = "form-control payment" name="mode_of_payment" id="mode_of_payment" readonly>
                        <option value="Annually">ANNUALLY</option>
                        <option value="Semi Annually">SEMI ANNUALLY</option>
                        <option value="Quarterly">QUARTERLY</option>
                        <option value="Compromise">COMPROMISE</option>
                    </select>
                </div>  
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Tax Year:</label>
                    <input type="text" id = "tax_year" name = "tax_year" class = "form-control payment" readonly>
                </div>  
            </div>


        </div>

        <hr>
        <h5 class = "text-primary text-center">Due Payment</h5>
        <hr>

        <div class="row">
        
            <div class="col-sm-3">
                <div class="form-group">
                    <label class = "bmd-label-floating">Due Basic:</label>
                    <input type="text" class="form-control payment due_payment_decimal due_payment_add" name="due_basic" id="due_basic" readonly >
                </div>  
            </div>

            
            <div class="col-sm-3">
                <div class="form-group">
                    <label class = "bmd-label-floating">Due SEF:</label>
                    <input type="text" class="form-control payment due_payment_decimal due_payment_add" name="due_sef" id="due_sef"  readonly >
                </div>  
            </div>
            
            <div class="col-sm-3">
                <div class="form-group">
                    <label class = "bmd-label-floating">Penalty:</label>
                    <input type="text" class="form-control payment due_payment_decimal due_payment_add" name="due_penalty" id="due_penalty" readonly >
                </div>  
            </div>

            
            <div class="col-sm-3">
                <div class="form-group">
                    <label class = "bmd-label-floating">Discount:</label>
                    <input type="text" class="form-control payment due_payment_decimal " name="due_discount" id="due_discount"  readonly >
                </div>  
            </div>

            
            <div class="col-sm-4" >
                <div class="form-group">
                    <label class = "bmd-label-floating">Total:</label>
                    <input type="text" class="form-control payment payment_decimal" name="due_total" id="due_total" readonly >
                </div>  
            </div>
            <div class="col-sm-4">
                 
            </div>

            <div class="col-sm-4" >
                <div class="form-group">
                    <label class = "bmd-label-floating">Balance:</label>
                    <input type="text" class="form-control payment payment_decimal" name="balance" id="balance" readonly >
                </div>  
            </div>
           
           
           

            <div class="col-sm-4 paymentcash">
                <div class="form-group">
                    <label for="bmb-label-floating">Cash Payment:</label>
                    <input type="text" class = "form-control payment payment_decimal money2" name = "cash_payment" id = "cash_payment" step =".01" required>
                </div>
            </div>
            <div class="col-sm-4">
            </div>

            <div class="col-sm-4 paymentcash change">
                <div class="form-group">
                    <label for="bmb-label-floating">Change:</label>
                    <input type="text" class = "form-control payment payment_decimal" name = "cash_change" id = "cash_change" readonly step =".01">
                </div>
            </div>

        
            
        
        </div>

        </div>


        <div class = "paymentcash">

        <!-- <hr>
        <h5 class = "text-primary text-center">Collected Payment</h5>
        <hr>

        <div class="row">
        
            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Collected Basic:</label>
                    <input type="number" class="form-control payment collected_payment_decimal collected_payment_add" name="collected_basic" id="collected_basic" step=".01">
                </div>  
            </div>

            
            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Collected SEF:</label>
                    <input type="number" class="form-control payment collected_payment_decimal collected_payment_add" name="collected_sef" id="collected_sef" step=".01">
                </div>  
            </div>

            
            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Collected Penalty:</label>
                    <input type="number" class="form-control payment collected_payment_decimal collected_payment_add" name="collected_penalty" id="collected_penalty" step=".01">
                </div>  
            </div>

            
            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Collected Discount:</label>
                    <input type="number" class="form-control payment collected_payment_decimal" name="collected_discount" id="collected_discount" step=".01">
                </div>  
            </div>

            
            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Collected Total:</label>
                    <input type="number" class="form-control payment payment_decimal" name="collected_total" id="collected_total" disabled step=".01">
                </div>  
            </div>
        
        </div> -->

        </div>
        <!-- payment cash end -->
    
        <div class="paymentcheque">
        <hr>
            <h5 class = "text-primary text-center">Check Payment</h5>
            <hr>
            <div class="row">

           


                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class = "bmd-label-floating">Bank</label>
                            <input type="text" class="form-control payment check_pay" name="bank" id="bank">
                        </div> 
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class = "bmd-label-floating">Cheque No.</label>
                            <input type="text" class="form-control payment check_pay" name="cheque_no" id="cheque_no">
                        </div> 
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class = "bmd-label-floating">Cheque Amount</label>
                            <input type="text" class="form-control payment payment_decimal check_pay money2" name="cheque_amount" id="cheque_amount">
                        </div> 
                    </div> 
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class = "bmd-label-floating">Date</label>
                            <input type="date" class="form-control payment check_pay" name="cheque_date" id="cheque_date">
                        </div> 
                    </div>

                <div class="col-md-12">
                    <button class="btn btn-danger btn-block" id = "add_cheque">ADD</button>
                </div>

                    

                <div class="col-sm-12">
                    <table class="table table-bordered" id = "table_cheque">
                       <thead>
                            <tr>
                                <td>Bank name</td>
                                <td>Cheque No.</td>
                                <td>Cheque Amount</td>
                                <td>Cheque Date</td>
                                <td>Delete</td>
                            </tr>
                       </thead>
                       <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                       </tbody>
                        
                    </table>
                </div>
                
            </div>
        </div>
          
      </div>
        
     
        
      <input type="hidden" name = "idd" id = "idd">   
         <!-- Modal footer -->
      <div class="modal-footer">
      <div class="col-12 text-center">
      <button type="submit" class="btn btn-primary" id = "paymentbtn">Submit</button>
      </div>
       
      </div>
        </form>
    </div>
  </div>
</div>


<div class="modal fade" id="recieptmodal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header h-10 bg-info">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Receipt</h5>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <!-- src="<?php echo base_url()?>/pages/reciept#view=FitW&toolbar=0" -->
                            
                            <iframe id="myframe2" width='100%' height="450"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button onclick="printmodalshow2()" type="button" class="btn btn-sm btn-primary">Print</button>
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="recieptmodal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header h-10 bg-info">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Receipt</h5>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <!-- src="<?php echo base_url()?>/pages/reciept#view=FitW&toolbar=0" -->
                            
                            <iframe id="framedis2" width='100%' height="450"></iframe>
                        </div>
                        <div class="modal-footer">
                            <!-- <button onclick="printmodalshow()" type="button" class="btn btn-sm btn-primary">Print</button> -->
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


<!-- resibo modal -->
<div class="modal fade" id="recieptmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header h-10 bg-info">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Receipt</h5>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <!-- src="<?php echo base_url()?>/pages/reciept#view=FitW&toolbar=0" -->
                            
                            <iframe id="myframe" width='100%' height="450"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button onclick="printmodalshow()" type="button" class="btn btn-sm btn-primary">Print</button>
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
      <!-- end of resibo modal -->


<!-- resibo modal -->
<div class="modal fade" id="recieptmodal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header h-10 bg-info">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Receipt</h5>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <!-- src="<?php echo base_url()?>/pages/reciept#view=FitW&toolbar=0" -->
                            
                            <iframe id="framedis" width='100%' height="450"></iframe>
                        </div>
                        <div class="modal-footer">
                            <!-- <button onclick="printmodalshow()" type="button" class="btn btn-sm btn-primary">Print</button> -->
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
      <!-- end of resibo modal -->


<!-- PAYMENT HISTORY MODAL -->

         <!-- The Modal -->      
<div class="modal fade" id="viewPayment">
  <div class="modal-dialog modal-xl">
    <div class="modal-content modal-content-fs">

      <!-- Modal Header -->
      
      <div class="modal-header bg-primary">
       
        <h4 class="modal-title text-white" id= "h4user">Payment History</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      
      <div class="modal-body">
        <!-- Modal body -->
        <div class="row">
        </div>
        <input type="hidden" class = "" id = "idpin" name = "idpin"> 
      <div class="row">

        <div class="col-md-6" id = "paymenthistory_owners">
            
        </div>
        
        <div class="col-md-6">
            <label for="">Location: </label>
           <input type="text" class = "form-control phistory" id = "paymenthistory_location" name = "paymenthistory_location" readonly>
        </div>
        

      </div>
    <!-- PAYMENT INFO -->
      <div class="row">
          
                <div class="col-md-3">
                    <label for="">Pin: </label>
                    <input type="text" class = "form-control phistory" id = "paymenthistory_pin" name = "paymenthistory_pin" readonly>
                </div>
                <div class="col-md-3">
                    <label for="">Tax Declaration No.: </label>
                    <input type="text" class = "form-control phistory" id = "paymenthistory_tax_dec_no" name = "paymenthistory_tax_dec_no" readonly>
                </div>
                <div class="col-md-3">
                    <label for="">Assessed Value: </label>
                    <input type="text" class = "form-control phistory" id = "paymenthistory_assessed_val" name = "paymenthistory_assessed_val" readonly>
                </div>

                <div class="col-md-3">
                    <label for="">Mode of Payment: </label>
                    <input type="text" class = "form-control phistory" id = "paymenthistory_mode_of_payment" name = "paymenthistory_mode_of_payment" readonly>
                </div>

      </div>
    <!-- PAYMENT -->
      <div class="row">

                <div class="col-md-2">
                    <label for="">Basic: </label>
                    <input type="text" class = "form-control phistory" id = "paymenthistory_basic" name = "paymenthistory_basic" readonly>
                </div>
                <div class="col-md-2">
                    <label for="">SEF: </label>
                    <input type="text" class = "form-control phistory" id = "paymenthistory_sef" name = "paymenthistory_sef" readonly>
                </div>
                <div class="col-md-2">
                    <label for="">Penalty: </label>
                    <input type="text" class = "form-control phistory" id = "paymenthistory_penalty" name = "paymenthistory_penalty" readonly>
                </div>

                <div class="col-md-2">
                    <label for="">Discount: </label>
                    <input type="text" class = "form-control phistory" id = "paymenthistory_discount" name = "paymenthistory_discount" readonly>
                </div>
                <div class="col-md-2">
                    <label for="">Total: </label>
                    <input type="text" class = "form-control phistory" id = "paymenthistory_total" name = "paymenthistory_total" readonly>
                </div>

      </div>
      <br>
 <!-- table -->
      <div class="row">
           <div class="col-md-12">
               <table class ="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>Payor</td>
                            <td>OR number</td>
                            <td>Basic</td>
                            <td>SEF</td>
                            <td>Penalty</td>
                            <td>Discount</td>
                            <td>Total</td>
                            <td>Cash </td>
                            <td>Check</td>
                            <td>Total</td>
                            <td>Date</td> 
                            <td>Cancel O.R</td> 
                        <tr/>
                    </thead>
                    <tbody id = "paymenthistorydata">

                    </tbody>
               </table>
           </div>

      </div>

      
      </div>
        
         <!-- Modal footer -->
      <div class="modal-footer">
        
      </div>
        
    </div>
  </div>
</div>





        <!-- END OF PAYMENT HISTORY MODAL -->

                <!-- clearance modal -->
                <div class="modal fade" id="clearancePayment">
                    <div class="modal-dialog">
                        <div class="modal-content">

                    <!-- Modal Header -->
                    
                        <div class="modal-header">
                    
                        <h4 class="modal-title text-primary" id= "h4user">Clearance Payment</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                    
                            <div class="modal-body">
                                    <!-- Modal body -->
                            <form id = "clearance_payment">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="clearance_ornumber">OR No:</label>
                                            <input type="text" class = "form-control clearance_payment" id = "clearance_ornumber" name = "clearance_ornumber" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="clearance_ornumber">Clearance fee:</label>
                                            <input type="text" class = "form-control clearance_payment" id = "clearance_fee" name = "clearance_fee" step=".01" required>
                                        </div>
                                    </div>
                                    <input type="hidden" id = "land_id" name = "land_id" >
                        
                                
                            </div>
                            </div>
                        <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id = "addbtn">Submit</button>
                    </div>
                        </form>
                    </div>
                </div>
                </div>


                <!-- end of clearance modal -->



                  <!-- Change MOP modal -->
                  <div class="modal fade" id="changeModeOfPayment">
                    <div class="modal-dialog">
                        <div class="modal-content">

                    <!-- Modal Header -->
                            
                                <div class="modal-header bg-primary">
                            
                                <h4 class="modal-title text-white" id= "h4user">Change Mode of Payment</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                    
                            <div class="modal-body">
                                    <!-- Modal body -->
                                    <form id = "change_mode_of_payment">
                                        <div class="row" id = "payment_here">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="clearance_ornumber">Total Payment:</label>
                                                    <input type="text" class = "form-control" id = "mop_total_payment" name = "mop_total_payment" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="clearance_ornumber">Balance:</label>
                                                    <input type="text" class = "form-control" id = "mop_balance" name = "mop_balance" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="clearance_ornumber">Mode Of Payment:</label>
                                                    <input type="text" class = "form-control" id = "payment_mode" name = "payment_mode" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="bmb-label-floating">Mode of Payment</label>
                                                    <select name="mode_of_payment1" id="mode_of_payment1" class = "form-control" required>
                                                        
                                                    </select>
                                                </div> 

                                                <div class="form-group" id = "compromise">
                                                    <label class = "bmd-label-floating">Number of Payment:</label>
                                                    <select name="number_of_payment" id="number_of_payment" class = "form-control">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                </div> 
                                            </div>
                                            <!-- <div class="col-md-12" id = "payment_here">
                                            
                                          
                                            </div> -->
                                                
                                        
                                            <input type="hidden" id = "tax_order_id" name = "tax_order_id">
                                            <input type="hidden" id = "mop_land_id" name = "mop_land_id">
                                        </div>

                                        
                            </div>
                                
                                <!-- Modal footer -->
                            <div class="modal-footer">
                            <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary" id = "changebutton">Submit</button>
                       
                            </div>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>


                <!-- end of Change MOP modal -->


  

        



      



























