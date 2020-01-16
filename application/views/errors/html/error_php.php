<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- <div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;"> -->
<div class="row card">
	<div class=" col-sm-4 offset-md-4 alert alert-warning">

		<p class="text-center"><b>[<?php echo $severity; ?>]</b></p>

		<p class="text-center"> <?php echo $message; ?> on <b><?php echo $filepath; ?>, Line Number: <?php echo $line; ?></b></p>
		<!-- <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

			<p>Backtrace:</p>
			<?php foreach (debug_backtrace() as $error): ?>

				<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

					<p style="margin-left:10px">
					File: <?php echo $error['file'] ?><br />
					Line: <?php echo $error['line'] ?><br />
					Function: <?php echo $error['function'] ?>
					</p>

				<?php endif ?>

			<?php endforeach ?>

		<?php endif ?> -->

	</div>
</div>