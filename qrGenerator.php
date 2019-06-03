<?php
    require_once("../phpqrcode/qrlib.php");

    function generateQR($qrurl) {
        $qr = QRcode::png($qrurl);
        echo $qr;
    }
?>