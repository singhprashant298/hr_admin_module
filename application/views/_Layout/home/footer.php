</body>
<script src="<?= base_url("assets/js/popper.min.js"); ?>"></script>
<script src="<?= base_url("assets/js/bootstrap.min.js"); ?>"></script>

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
</html>
