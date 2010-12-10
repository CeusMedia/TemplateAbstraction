<?php
/**
 *	Factory for template from several template engines.
 *	@category	cmModules
 *	@package	TEA
 *	@author		Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version	$Id$
 */
/**
 *	Factory for template from several template engines.
 *	@category	cmModules
 *	@package	TEA
 *	@author		Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version	$Id$
 */
class CMM_TEA_Factory{

	protected $defaultType		= 'cmc';
	protected $pathCache		= 'templates/cache/';
	protected $pathTemplates	= 'templates/';
	protected $patternType		= '/^<!--TEA:(\S+)-->\n?\r?/';

	public function identifyType( $fileName ){
		$content	= File_Reader::load( $this->pathTemplates.$fileName );
		$matches	= array();
		if( preg_match_all( $this->patternType, $content, $matches ) )
			return $matches[1][0];
		return NULL;
	}

	public function getPattern(){
		return $this->patternType;
	}

	public function getTemplate( $fileName, $data = NULL ){
		$type	= $this->identifyType( $fileName );
		$type	= $type ? $type : $this->defaultType;
		if( !$type )
			throw new RuntimeException( 'No type identified or set' );
		return $this->newTemplate( $type, $fileName, $data );
	}

	public function newTemplate( $type, $fileName = NULL, $data = NULL ){
		$className	= 'CMM_TEA_Adapter_'.$type;
		if( !class_exists( $className ) )
			throw new RuntimeException( 'Template engine "'.$type.'" not registered' );
		$reflection	= new ReflectionClass( $className );
		$template	= $reflection->newInstanceArgs( array( $this ) );
		$template->setSourcePath( $this->pathTemplates );
		if( $this->pathCache )
			$template->setCachePath( $this->pathCache );
		if( !empty( $fileName ) )
			$template->setSourceFile( $fileName );
		if( $data )
			$template->setData( $data );
		return $template;
	}

	public function setCachePath( $path ){
		$this->pathCache	= $path;
	}

	public function setDefaultType( $type ){
		$this->defaultType	= $type;
	}

	public function setTemplatePath( $path ){
		$this->pathTemplates	= $path;
	}
}
?>