<?php
if (isset($_GET["weather"])) {
    // Echo the widget HTML and JavaScript inside the PHP block
    echo '
    <div class="weatherwidget-io" data-label_1="BANTAYAN" data-label_2="WEATHER" data-theme="original" data-mode="Current" data-font="Sans-serif"></div>
    <script>
        !function(d,s,id){
            var js,fjs=d.getElementsByTagName(s)[0];
            if(!d.getElementById(id)){
                js=d.createElement(s);js.id=id;
                js.src="https://weatherwidget.io/js/widget.min.js";
                fjs.parentNode.insertBefore(js,fjs);
            }
        }(document, "script", "weatherwidget-io-js");
    </script>
    ';
}
?>
