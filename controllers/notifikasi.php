<?php
if (session_status() == PHP_SESSION_NONE) session_start();

if (isset($_SESSION['flash'])):
  $icon = $_SESSION['flash']['icon'];
  $title = $_SESSION['flash']['title'];
  $text = $_SESSION['flash']['text'];
  $redirect = isset($_SESSION['flash_redirect']) ? $_SESSION['flash_redirect'] : null;
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    icon: '<?= $icon; ?>',
    title: '<?= $title; ?>',
    text: '<?= $text; ?>',
    timer: 1800,
    showConfirmButton: false,
    customClass: {
        popup: 'swal-font-custom',
        title: 'swal-font-custom',
        content: 'swal-font-custom'
    }
}).then(() => {
    <?php if ($redirect): ?>
    window.location.href = '<?= $redirect ?>';
    <?php endif; ?>
});
</script>
<style>
.swal-font-custom,
.swal2-title,
.swal2-content,
.swal2-html-container,
.swal2-popup {
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important;
}
</style>
<?php
unset($_SESSION['flash']);
unset($_SESSION['flash_redirect']);
endif;
?>