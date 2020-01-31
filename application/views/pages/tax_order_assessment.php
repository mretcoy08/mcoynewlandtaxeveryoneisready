<div class="content">
    <div class="container-fluid">
        <!-- container fluid -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                  
                        <h4 class="card-title "></h4>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Search by: [PIN,NAME,TAX DECLARATION NO]</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id ="assessment_search" name = "assessment_search">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary btn-sm" type="button" id = "assessment_search_btn">Search!</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="row">
                          <div class = "col-12 col-md-12 col-xs-12">
                            <table id="posts" class="table  table-sm table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Owner</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Pin</th>
                                        <th scope="col">ARP No.</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                                
                                
                            </table>
                          </div>

                        </div>

                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
        </div>

        <br>
            
       <div class="row" id = "payment_info">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                  
                        <h5 class="card-title text-center text-primary"><STRONG>Payment Information</STRONG></h5>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-3">
                                    <label class = "bmd-label-floating">Owner/s</label>
                                    <div id ="owners"></div>
                                </div>
                                
                                <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="" class="bmb-label-floating">Mode of Payment</label>
                                    <select name="mode_of_payment" id="mode_of_payment" class = "form-control" required>
                                        <option value="Annually">ANNUALLY</option>
                                        <option value="Semi Annually">SEMI ANNUALLY</option>
                                        <option value="Quarterly">QUARTERLY</option>
                                        <option value="Compromise">COMPROMISE</option>
                                    </select>
                                </div> 
                                <div id = "compromise">
                                <div class="form-group" >
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
                                <div class="form-group">
                                    <label class = "bmd-label-floating">Down Payment:</label>
                                    <input type="text" class="form-control payment money2" name="down_payment" id="down_payment">
                                </div>  
                                </div>
                               
                              
                            

                                </div>
                                <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class = "bmd-label-floating">Pin</label>
                                            <input type="text" class="form-control payment" name="pin" id="pin" readonly>
                                        </div>  
                                    

                                        <div class="form-group">
                                            <label class = "bmd-label-floating">ARP No.</label>
                                            <input type="text" class="form-control payment" name="arp" id="arp" readonly>
                                        </div>  
                                        
                                        <div class="form-group">
                                            <label class = "bmd-label-floating">Last Paid Year</label>
                                            <input type="text" class="form-control payment" name="last_paid_assessed" id="last_paid_assessed" readonly>
                                         </div> 
                                        
                                       

                                    
                                       
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                            <label class = "bmd-label-floating">Location</label>
                                            <input type="text" class="form-control payment" name="location" id="location" readonly>
                                        </div>  

                                    <div class="form-group">
                                        <label class = "bmd-label-floating">Assessed Value:</label>
                                        <input type="text" class="form-control payment payment_decimal" name="assessed_value" id="assessed_value" readonly>
                                    </div>  

                                    <div class="form-group">
                                            <label class = "bmd-label-floating">Year of Effectivity</label>
                                            <select class="form-control payment" name="year_of_effectivity" id="year_of_effectivity">
                                                
                                            </select>
                                        </div>  
                            
                                    <div class="form-group">
                                        <label class = "bmd-label-floating">Status of tax:</label>
                                        <input type="text" class="form-control payment" name="status_of_tax" id="status_of_tax" readonly>
                                    </div>  

                                    <input type="hidden" name = "idd" id = "idd">
                                    <button class = "btn btn-primary float-right" id = "compute">COMPUTE</button>
                           
                                </div>

                                  

                                </div>

                            </div>

                        </div>
                    </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
                </div>
            
   
        <br>

       <div class="row" id = "real_tax_order_of_payment">
            <div class="col-md-12">

                <div class="card">
                        <div class="card-header card-header-primary">
                  
                            <h5 class="card-title text-center text-primary"><STRONG>REALTY TAX ORDER OF PAYMENT</STRONG></h5>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <table class = "table table-striped" id ="tax_order_table">
                                            <thead>
                                            <tr>
                                                <td>ARP NO.</td>
                                                <td>ASSESSED VALUE</td>
                                                <td>YEAR</td>
                                                <td>BASIC</td>
                                                <td>PEN/DISC</td>
                                                <td>TOTAL</td>
                                            </tr>
                                            </thead>
                                            
                                        </table>
                                        </div>
                                        
                                        <div class="col-md-3">
                                        <label for="" id = "mop">Mode of Payment:</label>
                                            <div class="paymentsmop"></div>
                                        </div>
                                        <div class="col-md-6"></div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Basic Fee:</label>
                                                <input type="text" class ="form-control" id = "basic_fee" name = "basic_fee">
                                            </div>
                                            <div class="form-group">
                                                <label for="">S.E.F:</label>
                                                <input type="text" class ="form-control" id = "special_education_fee" name = "special_education_fee">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Total Fee:</label>
                                                <input type="text" class ="form-control" id = "total_fee" name = "total_fee">
                                            </div>


                                            <input type="hidden" id = "total_penalty" name = "total_penalty">
                                            <input type="hidden" id = "total_discount" name = "total_discount">
                                            <input type="hidden" id = "total_basic" name = "total_basic">
                                            <button class="btn btn-primary float-right" id = "viewTaxOrder">View Tax Order</button>
                                        </div>
                                        
                                    
                                    
                                </div>
                            
                        </div>
                        
                        
                    </div>
                </div>
                
            </div>
        </div>

   
    <!-- end of container fluid -->
    </div>

</div>


<div class="modal fade" id="printtaxorder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header h-10 bg-info">
                            <h5 class="modal-title text-white" id="exampleModalLabel"></h5>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                           
                            
                            <iframe id="taxorder" width='100%' height="450"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button id = "print" type="button" class="btn btn-sm btn-primary">Print</button>
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
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
                    <select class = "form-control" name="tax_year" id="tax_year">
                        
                    </select>
                </div>  
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Last Payment</label>
                    <input type="date" id = "last_payment" name = "last_payment" class = "form-control">
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






























