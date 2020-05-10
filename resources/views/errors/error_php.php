<style type="text/css">
    #container-error a {
    	color: #003399;
    	background-color: transparent;
    	font-weight: normal;
    }
    
    #container-error h1 {
    	color: #444;
    	background-color: transparent;
    	border-bottom: 1px solid #D0D0D0;
    	font-size: 19px;
    	font-weight: normal;
    	margin: 0 0 14px 0;
    	padding: 14px 15px 10px 15px;
    }
    
    #container-error {
    	margin: 10px;
    	border: 1px solid #D0D0D0;
    	box-shadow: 0 0 8px #D0D0D0;
    }
    
    #container-error p {
    	margin: 12px 15px 12px 15px;
    }
</style>

<div id="container-error" style="padding-left: 20px; margin: 0 0 10px 0;">
	<h1>A PHP Error was encountered</h1>
	<p>Severity: <?php echo $severity; ?></p>
	<p>Message:  <?php echo $message; ?></p>
	<p>Filename: <?php echo $filepath; ?></p>
	<p>Line Number: <?php echo $line; ?></p>
    <?php if (defined('EM_SHOW_DEBUG_BACKTRACE') && EM_SHOW_DEBUG_BACKTRACE === TRUE): ?>
        <p>Backtrace:</p>
    	<?php foreach (debug_backtrace() as $error): ?>
    		<?php if (isset($error['file']) && strpos($error['file'], realpath(em_basepath)) !== 0): ?>
    			<p style="margin-left: 10px">
    			File: <?php echo $error['file'] ?><br />
    			Line: <?php echo $error['line'] ?><br />
    			Function: <?php echo $error['function'] ?>
    			</p>
    		<?php endif ?>
    	<?php endforeach ?>
    <?php endif ?>
</div>

