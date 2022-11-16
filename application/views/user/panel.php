<div class="container">

    <!-- Include Flash Data File -->
    <?php $this->load->view('_FlashAlert\flash_alert.php') ?>
    
    <a href="<?= base_url('User/showcandiate') ?>" class="btn btn-primary my-2 my-sm-0">Add Candidate </a> &nbsp;

    <div class="jumbotron">
        <p>CodeIgnier 3 login and registration full application.</p>
        <div class="alert1" style="color:green;font:bold;"></div>
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
    <th>Assign Team Leader</th>
  </tr>
  <?php $i=1; if($data !='No Data'){ foreach($data as $row)
  { ?>
  <tr>
  <td><?php echo  $i;?></td>
  <td><?php echo  $row->candidate_name ?></td>
  <td><?php echo  $row->exp ?></td>
  <td><?php echo  $row->Designation ?></td>
  <td><select width="100%" class="form-control teamleader" data-id="<?php echo $row->id;?>"  id="tl_<?php echo $i?>">
     <option>Select TL</option>
     <?php foreach($TLData as $tld){?>
       <option value="<?php echo $tld->id; ?>" <?php if($row->tl_id==$tld->id){ echo "selected"; }else{ echo ""; } ?>><?php echo $tld->name ?></option>
      <?php } ?>
    </select>
   </td>
  </tr>
<?php 
     $i++;
    }
  } ?>

</table>

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
</script>


