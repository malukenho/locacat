<?php

/**
* Phergie_Plugin_LocaCat
*
* @uses     Phergie_Plugin_Abstract
*
* @category Phergie Plugin
* @package  Phergie
* @author   Jefersson Nathan <malukenho@phpse.net>
* @license  GNU
*
*/
class Phergie_Plugin_LocaCat extends Phergie_Plugin_Abstract
{

    /**
     * onPrivmsg
     * 
     * @access public
     *
     * @return void Value.
     */
    public function onPrivmsg()
    {
        $event = $this->getEvent();
        $message = $event->getText();
        
        if (preg_match('/^!locacat/i', $message)) {
            $message = ltrim($message, '!locacat');
            $this->defineAction($message);
        }
    }

    /**
     * defineAction
     * 
     * @param mixed $commands passed to the locacat.
     *
     * @access protected
     *
     * @return bool Value.
     */
    protected function defineAction($commands)
    {
        
        $nick = $this->event->getNick();
        
        $action = array(
            '-ls' => 'list',
            '-ta' => 'talk',
            '-hp' => 'help' 
           // '-ad' => 'add'    @TODO: Adciona um texto a uma categoria
        );
        
        $command = substr(trim($commands), 0, 3);
        $params  = str_replace($command, '', $commands);
                
        if (! $commands or ! array_key_exists($command, $action)) {
            $this->displayHelp($nick);
            return true;
        }

        $this->getCommand($command, $params);	

       return true;
    }
    
    /**
     * getValue
     * 
     * @param mixed $params pass a list of Params to the method.
     *
     * @access private
     *
     * @return mixed Value.
     */
    private function getValue($params)
    {
    	$nick = $this->event->getNick();

    	if(! $params)
    	{
    		$this->doNotice($nick, 'COMMAD: -ta expects a parameter <category_name>');
    		return true;
    	}
    	
    	$listOfCategories = $this->categories();

    	$max = count($listOfCategories[$params]);

    	$this->doNotice($nick, $listOfCategories[$params][rand(0, ($max - 1))]);
    }

    /**
     * help
     * 
     * @access private
     *
     * @return array
     */
    private function help()
    {
        $output[] = "Bem vindo ao LocaCat Boot v0.1";
        $output[] = "Comandos:";
        $output[] = " ";
        $output[] = "-ls                  : Exibi lista de categorias cadastradas no boot";
        $output[] = "-ta <category_name>  : Exibe um texto aleatorio quando seguido da categoria";
        $output[] = "-hp                  : Exibe esta tela";
        return $output;
    }

    /**
     * categories
     * 
     * Return a array with the categories 
     *
     * @access private
     *
     * @return mixed Value.
     */
    private function categories()
    {
    	return array(
    		'gif'   => array('cat.gif', 'cat2.gif'),
    		'p'     => array('Lorem ipsum', 'Lorem lorem y'),
    		'fun'   => array('Casiudis !!!', 'Shungary'),
    		'sites' => array('catgifpage.com', 'anotherpage.php')
	    );
    }

    /**
     * getCommand
     * 
     * @param mixed $command.
     * @param mixed $params.
     * 
     * @access private
     *
     * @return mixed Value.
     */
    private function getCommand($command, $params)
    {
    	switch($command)
        {
        	case '-ls':
        		$this->listCategories();
        		break;

        	case '-ta':
        		$this->getValue(trim($params));
        		break;
        }

        return true;
    }

    /**
     * listCategories
     * 
     * List all categories in self::categories() method
     * 
     * @access public
     *
     * @return mixed Value.
     */
    public function listCategories()
    {
    	$nick       = $this->event->getNick();
    	$categories = array_keys($this->categories());

    	$this->doNotice($nick, '[ Categories ]');
    	$this->doNotice($nick, implode(', ', $categories));
    	$this->doNotice($nick, ' ');
        
        return true;
    }

    /**
     * displayHelp
     * 
     * @param string $nick of user.
     *
     * @access public
     *
     * @return mixed Value.
     */
    public function displayHelp($nick)
    {
        foreach($this->help() as $value) {
            $this->doNotice($nick, $value);
        }
        return true;
    }
    
}
