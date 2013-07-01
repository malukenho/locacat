<?php
 
class Phergie_Plugin_LocaCat extends Phergie_Plugin_Abstract
{
    public function onPrivmsg()
    {
        $event = $this->getEvent();
        $message = $event->getText();
        
        if (preg_match('/^!locacat/i', $message)) {
            $nick = $this->event->getNick();
            $this->doNotice($nick, "Comando locacat foi executado...\n");
        }
    }
}