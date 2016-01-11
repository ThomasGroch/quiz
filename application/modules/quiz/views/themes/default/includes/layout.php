<?php if (!isAjax()) : ?>
    <?php $this->load->view($this->config->item('ci_my_admin_template_dir_quiz').'/includes/header', $data); ?>
<?php endif; ?>

<?php $this->load->view($content, $data); ?>

<?php if (!isAjax()) : ?>
  <?php if (isset($data['pagination']) ) : ?>
    <?php echo $data['pagination']; ?>
  <?php endif; ?>
    <?php $this->load->view($this->config->item('ci_my_admin_template_dir_quiz').'/includes/footer', $data); ?>
<?php endif; ?>
