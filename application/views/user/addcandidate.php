<div class="container">

    <!-- Include Flash Data File -->
    <?php $this->load->view('_FlashAlert\flash_alert.php') ?>
    
    <?= form_open_multipart('user/add_candidate'); ?>
       
        <div class="form-group">
            <label>Candidate Name</label>
            <input type="text" name="candidate_name" value="<?= set_value('candidate_name'); ?>" class="form-control <?= (form_error('candidate_name') == "" ? '':'is-invalid') ?>" placeholder="Enter Candidate Name">  
            <?= form_error('candidate_name'); ?>           
        </div>
        <div class="form-group">
            <label>Experience</label>
            <input type="text" name="exp" value="<?= set_value('exp'); ?>" class="form-control <?= (form_error('exp') == "" ? '':'is-invalid') ?>" placeholder="Enter Experince"> 
            <?= form_error('exp'); ?>            
        </div>
        <div class="form-group">
            <label>CTC</label>
            <input type="text" name="ctc" value="<?= set_value('ctc'); ?>" class="form-control <?= (form_error('ctc') == "" ? '':'is-invalid') ?>" placeholder="Enter CTC"> 
            <?= form_error('ctc'); ?>            
        </div>
        <div class="form-group">
            <label>Expected CTC</label>
            <input type="text" name="expected_ctc" value="<?= set_value('expected_ctc'); ?>" class="form-control <?= (form_error('expected_ctc') == "" ? '':'is-invalid') ?>" placeholder="Enter Expected CTC"> 
            <?= form_error('expected_ctc'); ?>            
        </div>
        <div class="form-group">
            <label>Designation</label>
            <select name="Designation"  class="form-control <?= (form_error('Designation') == "" ? '':'is-invalid') ?>" >
               <option value="">Selct Designation</option>  
               <option value="SF" <?php if(set_value('Designation')=="SF"){ echo "selected"; }  ?>>Softwear Developer</option>
               <option value="FD" <?php if(set_value('Designation')=="FD"){ echo "selected"; }  ?>>Fronted Developer</option>
               <option value="jd" <?php if(set_value('Designation')=="jd"){ echo "selected"; }  ?>>Java Developer</option>
               <option value="st" <?php if(set_value('Designation')=="st"){ echo "selected"; }  ?> >Softwear Tester</option>
               <option value="ux" <?php if(set_value('Designation')=="ux"){ echo "selected"; }  ?>>UX Developer</option>
            </select>
            <?= form_error('Designation'); ?> 
        </div>    
        <div class="form-group">
            <label>Upload Resume</label>
            <input type='file' name='userfile' size='20' value="<?= set_value('userfile'); ?>" class="form-control <?= (form_error('userfile') == "" ? '':'is-invalid') ?>"  />
            <?= form_error('userfile'); 
             if(isset($erroruserfile)){
                echo $erroruserfile;
             }
            ?>            
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    <?= form_close() ?>
</div>
<br>

<script>


$("document").ready(function(){
   window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).remove();
         window.location.href = '/user/panel';
    });
  }, 1000);
});

</script>