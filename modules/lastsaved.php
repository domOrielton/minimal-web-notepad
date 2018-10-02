<link rel="stylesheet" href="modules/css/lastsaved.min.css">
<div class="savedStatus" id="savedStatus" datetime="<?php if (file_exists($path)) {
    echo gmdate("Y-m-d\TH:i:s\Z", filemtime($path));
} ?>"></div>
<script src="modules/js/tinyago.min.js"></script>
<script src="modules/js/lastsaved.min.js"></script>
