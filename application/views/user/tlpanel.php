<div class="container">

    <!-- Include Flash Data File -->
    <?php $this->load->view('_FlashAlert\flash_alert.php') ?>
    

    <div class="jumbotron">
        <p>Mr <?php echo $USERNAME; ?>, Team Leader Assigend Candidate.</p>
        <div class="alert2" style="color:green;font:bold;"></div>
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/toastr.css">

<style>
    
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
 
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr style="background:#CCC">
    <th>Sr No</th>
    <th>Candidate Name</th>
    <th>Experience</th>
    <th>Designation</th>
    <th>Feedback</th>
    <th>Status</th>
    <th>Action</th>
  </tr>
  <?php $i=1; if($data !='No Data'){ foreach($data as $row)
  { ?>
  <tr>
  <td><?php echo  $i;?></td>
  <td><?php echo  $row->candidate_name ?></td>
  <td><?php echo  $row->exp ?></td>
  <td><?php echo  $row->Designation ?></td>
  <td><?php echo  $row->feedback ?></td>
  <td><?php echo  $row->status ?></td>
  <td><button type="button "class="form-control feedback"  id="<?php echo $row->id;?>">Add feedback</button></td>
  </tr>
<?php 
     $i++;
    }
  } ?>

</table>

    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Details</h4>
        </div>
        <div class="modal-body">
        <div class="form-group">
            <label>Candidate Name</label>
            <input type="text"  name="candidate_name" id="candidate_name" class="form-control" disabled>  
        </div>
        <div class="form-group">
            <label>Experience</label>
            <input type="text" name="exp" id="exp" class="form-control" disabled> 
        </div>
        <div class="form-group">
            <label>CTC</label>
            <input type="text" name="ctc" id="ctc" class="form-control" disabled> 
        </div>
        <div class="form-group">
            <label>Expected CTC</label>
            <input type="text" name="expected_ctc" id="expected_ctc" class="form-control" disabled> 
        </div>
        <div class="form-group">
            <label>Designation</label>
            <select name="Designation" id="Designation"  class="form-control" disabled>
               <option value="">Selct Designation</option>  
               <option value="SF" >Softwear Developer</option>
               <option value="FD" >Fronted Developer</option>
               <option value="jd" >Java Developer</option>
               <option value="st" >Softwear Tester</option>
               <option value="ux" >UX Developer</option>
            </select>
        </div>
        <div class="form-group">
            <label>File </label>
            <input type="file" name="file" id="file" class="form-control" disabled> 
            File Name : <a href="" target="_blank" id="filename"></a>
        </div>

        <div class="form-group">
            <label>Feedback</label>
            <input type="text" name="feedback" id="feedback" class="form-control"> 
        </div>

        <input type="hidden" id="candidate_id" name="candidate_id" >

        <div class="form-group">
            <label>Status</label>
            <select name="status" id="status"  class="form-control">
               <option value="">Selct status</option>  
               <option value="Approved" >Approved</option>
               <option value="Rejected" >Rejected</option>
            </select>
        </div>
        </div>

        <div class="modal-footer">
          <button type="button" id="savefeedback" class="btn btn-default savefeedback" >Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>public/js/toastr.js"></script>

<script>

CI_ROOT="<?= base_url();?>";

$(".teamleader").change(function(e) {
    $(".alert1").removeAttr( 'style' );
  e.preventDefault();
  var candidate_id = $(this).attr('data-id'); 
  var tlid = $(this).val();
  var dataString = 'candidate_id='+candidate_id+'&tl_id='+tlid;;
  $.ajax({
    type:'POST',
    data:dataString,
    url:CI_ROOT+'/user/saveasigntl',
    success:function(data) {
      $(".alert1").text("Assign Team Leader Successfully!");
      window.setTimeout(function() {
    $(".alert1").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).text('');
         //window.location.href = '/web-register';
    });
  }, 1000);
    }
});
});

$(".feedback").click(function(e) {
     
    $("#myModal").modal('show');

  e.preventDefault();
  var candidate_id = $(this).attr('id'); 
  var dataString = 'candidate_id='+candidate_id;
  $.ajax({
    type:'POST',
    data:dataString,
    url:CI_ROOT+'/user/getCandidateDetails',
    dataType: "json",
    success:function(data) {
        console.log(data[0].candidate_name);
        $('#candidate_name').val(data[0].candidate_name);
        $('#exp').val(data[0].exp);
        $('#candidate_id').val(data[0].id)
        $('#ctc').val(data[0].ctc);
        $('#Designation').val(data[0].Designation);
        $('#expected_ctc').val(data[0].expected_ctc);
        $('#resume_name').val(data[0].resume_name);
        $('#filename').attr('href', CI_ROOT+"uploads/"+data[0].resume_name);
        $('#filename').text(data[0].resume_name);
        $('#feedback').val(data[0].feedback);
        $('#status').val(data[0].status);
    }
});
     
});

$(".savefeedback").click(function(e) {
     
  $(".alert2").removeAttr( 'style' );
  e.preventDefault();
  var feedback = $('#feedback').val(); 
  var status = $('#status').val();
  var candidate_id = $('#candidate_id').val();

  var dataString = 'feedback='+feedback+'&status='+status+'&candidate_id='+candidate_id;
  $.ajax({
    type:'POST',
    data:dataString,
    url:CI_ROOT+'/user/saveremark',
    success:function(data) {
      toastr.success("Status Updated By Team Leader  Successfully!");
      $(".alert2").text("");
      window.setTimeout(function() {
    $(".alert2").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).text('');
        $('#myModal').modal('hide');
        window.location.href = CI_ROOT+'user/TLpanel';

    });

  }, 1000);

    }
});
 });
 
</script>


