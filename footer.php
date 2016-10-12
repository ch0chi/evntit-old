<div class="container-fluid footerWrapper">
    <div class="row">
        <div class="col-md-12">

            <?php
            $relPath = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));

            echo"<p>Copyright © 2016 <a href=$relPath/index\" target=\"blank\">Evntit</a> / All rights reserved.</p>";
            ?>




        </div>

    </div>
</div>



<?php
$relPath = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));



echo"<script src=\"$relPath/bower_components/jquery/dist/jquery.min.js\"></script>";
echo"<script src=\"$relPath/bower_components/masonry/dist/masonry.pkgd.js\"></script>";

echo"<script src=\"$relPath/bower_components/bootstrap/dist/js/bootstrap.min.js\"></script>";
echo"<script src=\"$relPath/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js\"></script>";
echo"<script src=\"$relPath/bower_components/clipboard/dist/clipboard.min.js\"></script>";
echo"<script language=\"JavaScript\" src=\"http://www.geoplugin.net/javascript.gp\" type=\"text/javascript\"></script>";
echo"<script src=\"$relPath/js/colors.js\"></script>";
echo"<script src=\"$relPath/js/navbar.js\"></script>";
echo"<script src=\"$relPath/js/IEWorkaround.js\"></script>";
echo"<script src=\"$relPath/js/Functions.js\"></script>";
echo"<script src=\"$relPath/js/Search.js\"></script>";
echo"<script src=\"$relPath/js/Map.js\"></script>";




echo"</body>";
echo"</html>";
?>

