<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-subheader__main">
        <h3 class="kt-subheader__title">
            <?php echo $title ?? 'Dashboard'; ?> </h3>
        <span class="kt-subheader__separator kt-hidden"></span>
    </div>
</div>
<?php 
    if ($this->session->flashdata('notification')) {
        echo $this->session->flashdata('notification');
    }
?>

<!-- end:: Subheader -->