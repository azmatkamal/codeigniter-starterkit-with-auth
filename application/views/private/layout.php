<?php $this->load->view('private/common/header_includes', $options); ?>

<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        
        <?php $this->load->view('private/common/aside', $options); ?>
        
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            
        <?php  $this->load->view('private/common/top_bar', $options); ?>
        
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

                <?php  $this->load->view('private/common/sub_header', $options); ?>

                <!-- begin:: Content -->
                <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

                    <?php $this->load->view('private/' . $file_name, $data); ?>

                </div>
                <!-- end:: Content -->
            </div>
            
            <?php $this->load->view('private/common/footer', $options); ?>
            
        </div>
    </div>
</div>
<!-- end:: Page -->`;

<?php $this->load->view('private/common/footer_includes', $options); ?>