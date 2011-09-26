<?php
define( '_JEXEC', 1 );

include_once ( '../libraries/import.php' );
jimport( 'joomla.application.cli' );

class HelloWorld extends JCli
{

public function execute( )
    {
        $this->out( 'Hello World 2' );
    }
}

JCli::getInstance( 'HelloWorld' )->execute( );