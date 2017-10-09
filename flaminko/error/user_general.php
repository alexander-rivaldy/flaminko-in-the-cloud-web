<div class="content">
    <h1>Ops...something went wrong</h1>
    <p class="error-message">
    <?php
    //print var_dump($_SESSION);
    if(!isset($_SESSION['userDetails'])){
        echo "Seems like you are not log in?<br/>";
        echo "Try <a href='../main/login.php'>login here</a>";
    }
    ?>
    </p>
</div>