<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                  
                        <h4 class="card-title "></h4>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                           

                        <!-- TABLE ROW -->
                        <div class="row">
                          <div class = "col-md-12 col-xs-12">
                            <table id="posts" class="table table-bordered" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width = "20%">Owner</th>
                                        <th width = "20%">Location</th>
                                        <th width = "15%">Pin</th>
                                        <th width = "15%">ARP No.</th>
                                        <th width = "10%">Date Assessed</th>
                                        <th width = "20%" class="disabled-sorting text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th width = "20%">Owner</th>
                                        <th width = "20%">Location</th>
                                        <th width = "15%">Pin</th>
                                        <th width = "15%">ARP No.</th>
                                        <th width = "10%">Date Assessed</th>
                                        <th width = "20%" class="disabled-sorting text-left">Actions</th>
                                    </tr>
                                </tfoot>
                                
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
<div class="modal fade" id="addAssessment">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      
      <div class="modal-header">
       
        <h4 class="modal-title text-primary" id= "h4user">ASSESSMENT</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      
      <div class="modal-body">
        <!-- Modal body -->
        <form id = "add_assessment">
            <h5 class = "text-primary text-center">Owner's Information</h5>
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
                    <input type="number" class="form-control payment payment_decimal" name="assessed_value" id="assessed_value" readonly>
                </div>  
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Status of tax:</label>
                    <input type="text" class="form-control payment" name="status_of_tax" id="status_of_tax" readonly>
                </div>  
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Assessment effectivity:</label>
                    <input type="text" class="form-control payment" name="assess_effectivity" id="assess_effectivity" readonly required>
                </div>  
            </div>

        </div>
        
        <hr>
        <h5 class = "text-primary text-center">Payment Information</h5>
        <hr>

        <div class="row">

            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Mode of Payment:</label>
                    <select class = "form-control payment" name="mode_of_payment" id="mode_of_payment" required>
                        <option value="Annually">ANNUALLY</option>
                        <option value="Semi Annually">SEMI ANNUALLY</option>
                        <option value="Quarterly">QUARTERLY</option>
                    </select>
                </div>  
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Year:</label>
                    <select class = "form-control payment" name="tax_year" id="tax_year">
                        
                    </select>
                </div>  
            </div>

        </div>

        <hr>
        <h5 class = "text-primary text-center">Payment</h5>
        <hr>

        <div class="row">
        
            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Basic:</label>
                    <input type="number" class="form-control payment due_payment_decimal due_payment_add" name="basic" id="basic" step=".01" readonly>
                </div>  
            </div>
            
            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Penalty:</label>
                    <input type="number" class="form-control payment due_payment_decimal due_payment_add" name="penalty" id="penalty" step=".01">
                </div>  
            </div>

            
            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Discount:</label>
                    <input type="number" class="form-control payment due_payment_decimal " name="discount" id="discount" step=".01">
                </div>  
            </div>

            
            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Total with(S.E.F):</label>
                    <input type="number" class="form-control payment payment_decimal" name="sub_total" id="sub_total" readonly step=".01">
                </div>  
            </div>
        
        </div>

     
          
      </div>
        
     
        
      <input type="hidden" name = "idd" id = "idd">   
         <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id = "paymentbtn">Submit</button>
      </div>
        </form>
    </div>
  </div>
</div>



























