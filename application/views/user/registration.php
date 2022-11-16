<div class="container">

    <!-- Include Flash Data File -->
    <?php $this->load->view('_FlashAlert\flash_alert.php') ?>
    
    <?= form_open() ?>
       
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?= set_value('username'); ?>" class="form-control <?= (form_error('username') == "" ? '':'is-invalid') ?>" placeholder="Enter Userame">  
            <?= form_error('username'); ?>           
        </div>
        <div class="form-group">
            <label>Email address</label>
            <input type="email" name="email" value="<?= set_value('email'); ?>" class="form-control <?= (form_error('email') == "" ? '':'is-invalid') ?>" placeholder="Enter Email"> 
            <?= form_error('email'); ?>            
        </div>
        
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" value="<?= set_value('password'); ?>" class="form-control <?= (form_error('password') == "" ? '':'is-invalid') ?>" placeholder="Password">
            <?= form_error('password'); ?> 
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role" value="<?= set_value('role'); ?>" class="form-control <?= (form_error('role') == "" ? '':'is-invalid') ?>" >
               <option value="">Selct name</option>  
               <option value="HR">HR</option>
               <option value="TL">Team leader</option>
            </select>
            <?= form_error('role'); ?> 
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    <?= form_close() ?>
</div>
<br>

<script>


$("document").ready(function(){
   window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).remove();
         //window.location.href = '/web-register';
    });
  }, 1000);
});

</script>