<?php

class Message {

    private $url;

    public function __construct ($url) {
        $this->url = $url;
    }

    // Inserir mensagem no sistema
    public function setMessage($msg, $type, $redirect = "index.php") {
        
        $_SESSION["msg"] = $msg;
        $_SESSION["type"] = $type;

        // Saber se o usuário voltará para a página anterior ou não
        if ($redirect != "back") {
            header("Location: $this->url" . $redirect);
        } else {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    
    }

    // Pegar uma mensagem no sistema
    public function getMessage() {}

    // Limpar a mensagem do sistema
    public function clearMessage() {}

}

?>