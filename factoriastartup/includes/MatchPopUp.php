<?php
namespace es\ucm\fdi\aw;

class MatchPopUp extends AbstractPopup {
    private $popup;
    private $variable1;//BORRAR
    private $variable2;//BORRAR

    public function __construct($title, $message, $variable1, $variable2) {
        parent::__construct($title, $message);
        $this->variable1 = $variable1;
        $this->variable2 = $variable2;
    }

    public function show() {

        $this->popup = "<div id='popup' class='popup'>";
        $this->popup .= "<div class='popup-content'>";
        $this->popup .= "<button onclick='location.href=\"negociadorindex.php\";'><i class='fas fa-times' ></i></button>";
        $this->popup .= "<h2>{$this->getTitle()}</h2>";
        $this->popup .= "<p>{$this->getMessage()}</p>";
        $this->popup .= "<button id='buttonn' onclick='location.href=\"perfilMisMatches.php\";'>Ir a mis matches</button>";
        $this->popup .= "</div>";
        $this->popup .= "</div>";
        echo $this->popup;
    }

    public function hide() {
        unset($this->popup);
    }
}
?>
