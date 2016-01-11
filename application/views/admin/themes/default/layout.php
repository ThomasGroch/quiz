<?php if (!isAjax()) : ?>
    <?php $this->load->view($this->config->item('ci_my_admin_template_dir_admin').'header', $data); ?>
<?php endif; ?>

<?php $this->load->view($content, $data); ?>

<?php if (!isAjax()) : ?>
  <?php if (isset($data['pagination']) ) : ?>
    <?php echo $data['pagination']; ?>
  <?php endif; ?>
    <?php $this->load->view($this->config->item('ci_my_admin_template_dir_admin').'footer', $data); ?>
<?php endif; ?>
