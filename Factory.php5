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

	public function __construct(){
		$this->engines	= parse_ini_file( dirname( __FILE__ ).'/engines.ini', TRUE );
	}

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

	protected function initializeEngine( $type ){
		if( empty( $this->engines[$type] ) )
			throw new RuntimeException( 'Unknown engine "'.$type.'"' ); 
		$engine	= $this->engines[$type];
		switch( $this->engines[$type]['active'] ){
			case 0:
				throw new RuntimeException( 'Engine "'.$type.'" not enabled' ); 
			case 1:
				if( !empty( $engine['loadFile'] ) )
					require_once $engine['loadFile'];
				else if( !empty( $engine['loadPath'] ) ){
					$path	= $engine['loadPath'];
					$ext	= empty( $engine['loadExtension'] ) ? 'php' : $engine['loadExtension'];
					$prefix	= empty( $engine['loadPrefix'] ) ? NULL : $engine['loadPrefix'];
					CMC_Loader::registerNew( $ext, $prefix, $path );
				}
				$this->engines['active']	= 2;
				break;
			case 2:
				break;
		}
	}

	public function getTemplate( $fileName, $data = NULL ){
		$type	= $this->identifyType( $fileName );
		$type	= $type ? $type : $this->defaultType;
		if( !$type )
			throw new RuntimeException( 'No type identified or set' );
		return $this->newTemplate( $type, $fileName, $data );
	}

	public function newTemplate( $type, $fileName = NULL, $data = NULL ){
		$this->initializeEngine( $type );
		
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