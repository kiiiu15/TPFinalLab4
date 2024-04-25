<script>
    $('#qrModal').on('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = $(event.relatedTarget);
        var qrUrl = button.data('qr');
        var modal = $(this)
        modal.find('#qr-img').attr("src", qrUrl);
    })
</script>