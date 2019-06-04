<?php
    require_once("/home/jmmalouf/public_html/SIAttendence/phpqrcode/qrlib.php");

    function generateQR($qrurl) {
        $qr = QRcode::png($qrurl);
        echo $qr;
    }
?>
