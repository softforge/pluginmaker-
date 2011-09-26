<?php

define('_JEXEC', 1);

define('JPATH_BASE', '..');

define('JPATH_SITE', JPATH_BASE);


//echo JPATH_BASE;

include_once ( JPATH_BASE.'/libraries/import.php' );

jimport( 'joomla.application.cli' );

jimport( 'joomla.database.database' );

jimport( 'joomla.database.table' );

jimport( 'joomla.database.table.extension' );

jimport( 'joomla.filesystem.file' );

jimport( 'joomla.filesystem.folder' );



class SetupModule extends JCli

{

	function writeFiles($name,$group,$copyright,$author,$authoremail,$authorurl,$joomlaversion,$pluginversion,$description,$fieldsetname)

    {

        $date = JFactory::getDate();

        $blankBuffer = '';



        $xmlBuffer = 
'<?xml version="1.0" encoding="utf-8"?>

<extension type="plugin" version="'.$joomlaversion.'" method="new" group="'.$group.'">

	<name>plg_'.$group.'_'.$name.'</name>

	<author>'.$author.'</author>

	<creationDate>'.$date.'</creationDate>

	<copyright>Copyright (C) '.$date.$copyright.'. All rights reserved.</copyright>

	<license>GNU General Public License version 3</license>

	<authorEmail>'.$authoremail.'</authorEmail>

	<authorUrl>'.$authorurl.'</authorUrl>

	<version>'.$pluginversion.'.0</version>

	<description><![CDATA['.$description.']]></description>

	<files>
	<folder>language</folder>

		<filename plugin="'.$name.'">'.$name.'.php</filename>
		<filename>index.html</filename>

	</files>
	<config>

		<fields name="params">

			<fieldset>

				<field

					type="spacer"

					name="myspacer1"

					class="text"

					label="'.$fieldsetname.'"

				/>

			</fieldset>

		</fields>

	</config>

</extension>

';



        $phpBuffer = '<?php

/**

 * @package		Joomla

 * @subpackage	mod_'.$name.'

 * @copyright	Copyright (C) 2011 JoomlaDayUK. All rights reserved.

 * @license		GNU General Public License version 3

 */



// no direct access

defined(\'_JEXEC\') or die;

jimport(\'joomla.plugin.plugin\');

class plg'.ucfirst($group).ucfirst($name).' extends JPlugin {

}

';


     $iniBuffer = '

; $Id: en-GB.plg_'.$group.'_'.$name.'.ini 
; Joomla! Project
; Copyright (C) '.$date.$copyright.'. All rights reserved.
; License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
; Note : All ini files need to be saved as UTF-8
';


     $sysiniBuffer = '

; $Id: en-GB.plg_'.$group.'_'.$name.'.ini 
; Joomla! Project
; Copyright (C) '.$date.$copyright.'. All rights reserved.
; License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
; Note : All ini files need to be saved as UTF-8
';



		JFolder::create(JPATH_BASE.'/plugins/plg_'.$group.'_'.$name);

 		JFile::write(JPATH_BASE.'/plugins/plg_'.$group.'_'.$name.'/'.$name.'.xml',$xmlBuffer);

 		JFile::write(JPATH_BASE.'/plugins/plg_'.$group.'_'.$name.'/'.$name.'.php',$phpBuffer);
 		JFile::write(JPATH_BASE.'/plugins/plg_'.$group.'_'.$name.'/language/en-GB/en-GB.plg_'.$group.'_'.$name.'.ini',$iniBuffer);
 		JFile::write(JPATH_BASE.'/plugins/plg_'.$group.'_'.$name.'/language/en-GB/en-GB.plg_'.$group.'_'.$name.'.sys.ini',$sysiniBuffer);

 		JFile::write(JPATH_BASE.'/plugins/plg_'.$group.'_'.$name.'/index.html',$blank);



	}



	function insertPlugin($name)

    {

		// Why do I need to do this?

		include_once ( JPATH_BASE.'/libraries/joomla/database/table/extension.php' );



		$extension = JTableExtension::getInstance('extension', 'JTable');



		$extension->name = 'plugin_'.$name;

		$extension->type = 'plugin';

		$extension->element = 'plg_'.$name;

		$extension->client_id = 0;

		$extension->enabled = 1;

		$extension->access = 1;



		if ($extension->store())

		{

				$this->out('Added the '.$name.' plugin to the Joomla site database.');

		}

		else

		{

				$this->out($module->getError());

		}

	}



    public function execute()

    {

		//require_once JPATH_BASE.'/configuration.php';

	//	$config = new JConfig;
	
	     $this->out( 'l for local build c for CMS insert' );

        $build = $this->in( );


        $this->out( 'What is the name of your plugin?' );

        $name = $this->in( );


        $this->out( 'What is the name of your plugin group?' );

        $group = $this->in( );
        
        $this->out( 'Who shall we put as copyright?' );
        $copyright = $this->in( );
        
        $this->out( 'Who is the author?' );

        $author = $this->in( );

        $this->out( 'What is the authors email?' );

        $authoremail = $this->in( );
        
        $this->out( 'What is the authors url?' );
        $authorurl = $this->in( );

        $this->out( 'What is the joomla version?' );

        $joomlaversion = $this->in( );
        
        $this->out( 'What is the plugin version?' );
        $pluginversion = $this->in( );        
        
        $this->out( 'What is the package description?' );
        $description = $this->in( );
        
        $this->out( 'What is the pane label?' );
        $fieldsetname = $this->in( );
        
        



		$name = preg_replace("/[^a-zA-Z0-9\s]/", "", $name);
		

		if($build=="l"){

		$this->writeFiles($name,$group,$copyright,$author,$authoremail,$authorurl,$joomlaversion,$pluginversion,$description,$fieldsetname);
		}
		else if($build=="c")

		$this->insertPlugin($name,$group,$copyright,$author,$authoremail,$authorurl,$joomlaversion,$pluginversion,$description,$fieldsetname);

    }



}



JCli::getInstance('SetupModule')->execute();