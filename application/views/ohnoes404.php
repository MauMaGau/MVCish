<?php
    include($config['header']);
    // Send log message
?>
    <div id="main" role="main" class='clearfix'>

        <article id='pageNotFound'>
            MySpaPro Logo
            <h2>Page not found</h2>
            <h3>We're very sorry, but the page you're looking for can't be found.</h3>
            <br>
            <h4>Suggestions:</h4>
            <ul>
                <li><a href='index.php'>Home</a></li>
                <li><a href='javascript: history.go(-1)'>Back</a></li>
                <li><a onClick="window.location.reload( true );">Refresh</a></li>
            </ul>
        </article>

    </div>

<?php
    include($config['footer']);
?>