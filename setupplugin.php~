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
	function writeFiles($name,$group,$copyright,$author,$authoremail,$authorurl,$joomlaversion,$description,$pluginname,$fieldsetname)
    {
        $date = JFactory::getDate();
        $blankBuffer = '';

        $xmlBuffer = 
'<?xml version="'.$joomlaversion.'" encoding="utf-8"?>
<extension
	type="plugin"
	version="0.1"
	group='.$group.'
	method="upgrade"
>
	<name>plg_'.$name.'</name>
	<author>'.$author.'</author>
	<creationDate>'.$date.'</creationDate>
	<copyright>Copyright (C) '.$date.$copyright.'. All rights reserved.</copyright>
	<license>GNU General Public License version 3</license>
	<authorEmail>'.$authoremail.'</authorEmail>
	<authorUrl>'.$authorurl.'</authorUrl>
	<version>'.$joomlaversion.'.0</version>
	<description><![CDATA['.$description.']]></description>
	<files>
		<filename plugin="'.$pluginname.'">'.$pluginname.'.php</filename>
		<filename>index.html</filename>
	</files>
	<languages>
		<language tag="en-GB">en-GB.plg_'.$pluginname.'.ini</language>
		<language tag="en-GB">en-GB.plg_'.$pluginname.'.sys.ini</language>
</languages>
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
</extension>';

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

class plg'.$pluginname.' extends JPlugin {

}

';

     $iniBuffer = '
; $Id: en-GB.plg_'.$pluginname.'.ini 
; Joomla! Project
; Copyright (C) '.$date.$copyright.'. All rights reserved.
; License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
; Note : All ini files need to be saved as UTF-8
';

     $sysiniBuffer = '
; $Id: en-GB.plg_'.$pluginname.'.ini 
; Joomla! Project
; Copyright (C) '.$date.$copyright.'. All rights reserved.
; License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
; Note : All ini files need to be saved as UTF-8
';

		JFolder::create(JPATH_BASE.'/plugins/plugin_'.$name);
 		JFile::write(JPATH_BASE.'/plugins/plugin_'.$name.'/plugin_'.$name.'.xml',$xmlBuffer);
 		JFile::write(JPATH_BASE.'/plugins/plugin_'.$name.'/plugin_'.$name.'.php',$phpBuffer);
 		JFile::write(JPATH_BASE.'/plugins/plugin_'.$name.'/language/en-GB.plg_'.$group.$pluginname.'.ini',$iniBuffer);
 		JFile::write(JPATH_BASE.'/plugins/plugin_'.$name.'/language/en-GB.plg_'.$group.$pluginname.'.sys.ini',$sysiniBuffer);
 		JFile::write(JPATH_BASE.'/plugins/plugin_'.$name.'/index.html',$blank);

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
        
        $this->out( 'What is the package description?' );
        $description = $this->in( );
        
         $this->out( 'What is the plugin name (used in code and must have no spaces)?' );
        $pluginname = $this->in( );
        
        $this->out( 'What is the pane label?' );
        $fieldsetname = $this->in( );
        
        


		$name = preg_replace("/[^a-zA-Z0-9\s]/", "", $name);
		
		if($build=="l"){
		$this->writeFiles($name,$group,$copyright,$author,$authoremail,$authorurl,$joomlaversion,$description,$pluginname,$fieldsetname);
		}
		else if($build=="c")
		$this->insertPlugin($name,$group,$copyright,$author,$authoremail,$authorurl,$joomlaversion,$description,$pluginname,$fieldsetname);
    }

}

JCli::getInstance('SetupModule')->execute();