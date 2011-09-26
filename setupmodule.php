<?php

define('_JEXEC', 1);
define('JPATH_BASE', '..');
define('JPATH_SITE', JPATH_BASE);
echo"hi";
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
	function writeFiles($name)
    {
        $date = JFactory::getDate();
        $blankBuffer = '';

        $xmlBuffer = '<?xml version="1.0" encoding="utf-8"?>
<extension
	type="module"
	version="0.1"
	client="site"
	method="upgrade"
>
	<name>'.$name.'</name>
	<author></author>
	<creationDate>'.$date.'</creationDate>
	<copyright>Copyright (C) 2011 JoomlaDayUK. All rights reserved.</copyright>
	<license>GNU General Public License version 3</license>
	<authorEmail>us@joomladayuk</authorEmail>
	<authorUrl>http://www.joomladayuk2011.org/</authorUrl>
	<version>1.7.0</version>
	<description><![CDATA[]]></description>
	<files>
		<filename module="mod_'.$name.'">mod_'.$name.'.php</filename>
		<folder>template</folder>
		<filename>helper.php</filename>
		<filename>index.html</filename>
		<filename>mod_'.$name.'.xml</filename>
	</files>
	<languages folder="language">
		<language tag="en-GB">en-GB.mod_'.$name.'.sys.ini</language>
		<language tag="en-GB">en-GB.mod_'.$name.'.ini</language>
	</languages>
	<config>
		<fields name="params">
			<fieldset>
				<field
					type="spacer"
					name="myspacer1"
					class="text"
					label="MODULE_LABEL"
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
defined(\'_JEXEC\') or die;';

		JFolder::create(JPATH_BASE.'/modules/mod_'.$name);
		JFolder::create(JPATH_BASE.'/modules/mod_'.$name);
		JFolder::create(JPATH_BASE.'/modules/mod_'.$name.'/template');

 		JFile::write(JPATH_BASE.'/modules/mod_'.$name.'/mod_'.$name.'.xml',$xmlBuffer);
 		JFile::write(JPATH_BASE.'/modules/mod_'.$name.'/mod_'.$name.'.php',$phpBuffer);
 		JFile::write(JPATH_BASE.'/modules/mod_'.$name.'/helper.php',$phpBuffer);
 		JFile::write(JPATH_BASE.'/modules/mod_'.$name.'/index.html',$blank);
 		JFile::write(JPATH_BASE.'/modules/mod_'.$name.'/template/default.php',$phpBuffer);

 		JFile::write(JPATH_BASE.'/language/en-GB/en-GB.mod_test.sys.ini',$blank);
 		JFile::write(JPATH_BASE.'/language/en-GB/en-GB.mod_test.ini',$blank);
	}

	function insertModule($name)
    {
		// Why do I need to do this?
		include_once ( JPATH_BASE.'/libraries/joomla/database/table/extension.php' );

		$extension = JTableExtension::getInstance('extension', 'JTable');

		$extension->name = 'mod_'.$name;
		$extension->type = 'module';
		$extension->element = 'mod_'.$name;
		$extension->client_id = 0;
		$extension->enabled = 1;
		$extension->access = 1;

		if ($extension->store())
		{
				$this->out('Added the '.$name.' module to the Joomla site database.');
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

        $this->out( 'What is the name of your module?' );
        $name = $this->in( );

		$name = preg_replace("/[^a-zA-Z0-9\s]/", "", $name);

		$this->writeFiles($name);
		$this->insertModule($name);
    }

}

JCli::getInstance('SetupModule')->execute();