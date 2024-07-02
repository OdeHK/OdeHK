<!--container footer-->
<!-- jQuery core - the newest version 3.7.1-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootbox library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

<!-- Deleting product -->
<script>
// JavaScript for deleting product
$(document).on('click', '.delete-object', function(){
    var id = $(this).attr('delete-id');
    bootbox.confirm({
		title: 'Delete Product',
        message: '<h4>Are you sure?</h4>',
        buttons: {
            confirm: {
                label: '<i class="bi bi-check"></i> Yes',
                className: 'btn-danger'
            },
            cancel: {
                label: '<i class="bi bi-x"></i> No',
                className: 'btn-primary'
            }
        },
        callback: function (result) {
            if(result==true){
                $.post('delete_product.php', {
                    object_id: id
                }, function(data){
                    location.reload();
                }).fail(function() {
                    alert('Unable to delete.');
                });
            }
        }
    });
  
    return false;
});
</script> 
</body>
</html>