<?php
namespace es\ucm\fdi\aw;
class MyPopup extends AbstractPopup {
    private $popup;

    public function show() {
        $this->popup = "<div id='popup' class='popup'>";
        $this->popup .= "<h2>{$this->getTitle()}</h2>";
        $this->popup .= "<p>{$this->getMessage()}</p>";
        $this->popup .= "<button onclick='hidePopup()'>Cerrar</button>";
        $this->popup .= "</div>";
        echo $this->popup;
    }

    public function hide() {
        unset($this->popup);
    }
}


?>
<script>
    function showPopup() {
        var popup = document.getElementById("popup");
        popup.style.display = "block";
    }

    function hidePopup() {
        var popup = document.getElementById("popup");
        popup.style.display = "none";
    }

    window.onload = showPopup;
</script>