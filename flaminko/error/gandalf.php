<?php
	require_once('../layout/header.php');
?>
<?php
session_start();
?>

<div class="content">
    <h1>THOU SHALL NOT PASS!</h1>
    <div class="error-message">
    No seriously. Please <a href='../main/login.php'>login</a> to continue.<br/>
    Interested in joining? <a href='../main/register.php'>Register now!</a></div>
</div>

<?php
	require_once('../layout/footer.php');
?>