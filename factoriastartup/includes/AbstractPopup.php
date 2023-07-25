<?php
namespace es\ucm\fdi\aw;
abstract class AbstractPopup {
    protected $title;
    protected $message;

    public function __construct($title, $message) {
        $this->title = $title;
        $this->message = $message;
    }

    /**
     * Muestra el pop up en pantalla
     * @return void
     */
    abstract public function show();

    /**
     * Oculta el pop up de la pantalla
     * @return void
     */
    abstract public function hide();

    /**
     * Establece el título del pop up
     * @param string $title El título del pop up
     * @return void
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Obtiene el título del pop up
     * @return string El título del pop up
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Establece el mensaje del pop up
     * @param string $message El mensaje del pop up
     * @return void
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * Obtiene el mensaje del pop up
     * @return string El mensaje del pop up
     */
    public function getMessage() {
        return $this->message;
    }
}