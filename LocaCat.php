<?php

class Phergie_Plugin_LocaCat extends Phergie_Plugin_Abstract
{
    public function onPrivmsg()
    {
        $event = $this->getEvent();
        $message = $event->getText();
        
        if (preg_match('/^!locacat/i', $message)) {
            $message = ltrim($message, '!locacat');
            $this->defineAction($message);
        }
    }
    
     
    protected function defineAction($commands)
    {
        
        $nick = $this->event->getNick();
        
        $action = array(
            '-ls' => 'list', //@TODO: lista categorias
            '-ta' => 'talk', //@TODO: texto aleatório de alguam categoria
            '-hp' => 'help', // @TODO: apresenta o help
            '-ad' => 'add'   // @TODO: Adciona um texto a uma categoria
        );
        
        $command = substr(trim($commands), 0, 3);
        
        if (! $commands or ! array_key_exists($command, $action)) {
            $this->displayHelp($nick);
            return true;
        }
        
        
        $nick = $this->event->getNick();
        $this->doNotice($nick, $command);
    }
    
    private function help()
    {
        $output[] = "Bem vindo ao LocaCat Boot v0.1";
        $output[] = "Comandos:";
        $output[] = " ";
        $output[] = "-ls: Exibi lista de categorias cadastradas no boot";
        $output[] = "-ta: Exibe um texto aleatorio quando seguido da categoria";
        $output[] = "-hp: Exibe esta tela";
        return $output;
    }
    
    public function displayHelp($nick)
    {
        foreach($this->help() as $value) {
            $this->doNotice($nick, $value);
        }
        return true;
    }
    
}
