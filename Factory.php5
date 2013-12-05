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

	protected $defaultType		= 'STE';
	protected $engines			= array();
	protected $pathTemplates	= 'templates/';
	protected $pathCache		= 'templates/cache/';
	protected $pathCompile		= 'templates/compiled/';
	public $patternType			= '/^<!--TEA:(\S+)-->\n?\r?/';

	/**
	 *	Constructor.
	 *	Loads engine definitions from engine.ini.
	 *	@access		public
	 *	@param		string|array	$config		Filename of config file OR configuration as array
	 *	@return		void
	 */
	public function __construct( $config = NULL ){
		if( is_array( $config ) )
			$this->engines	= $config;
		else{
			$fileName		= $config ? $config : dirname( __FILE__ ).'/engines.ini';
			if( !file_exists( $fileName ) )
				throw new RuntimeException( 'Config file "'.$fileName.'" is missing' );
			$this->engines	= parse_ini_file( $fileName, TRUE );
		}
		if( !array_key_exists( $this->defaultType, $this->engines ) ){
			$this->defaultType		= NULL;
			foreach( $this->engines as $engineName => $engineData ){
				if( !empty( $engineData['default'] ) ){
					$this->defaultType		= $engineName;
					break;
				}
			}
		}
	}

	/**
	 *	Tries to identify engine type by looking for a specific header pattern within a template.
	 *	Returns every found type even if not supported.
	 *	@access		protected
	 *	@param		string		$fileName		File name of template within template path
	 *	@return		string|NULL
	 */
	protected function identifyType( $fileName ){
		$content	= File_Reader::load( $this->pathTemplates.$fileName );
		$matches	= array();
		if( preg_match_all( $this->patternType, $content, $matches ) )
			return $matches[1][0];
		return NULL;
	}

	public function getEngineSettings( $type ){
		if( !array_key_exists( $type, $this->engines ) )
			throw new DomainException( 'Unknown engine "'.$type.'"' );
		return $this->engines[$type];
	}
	
	/**
	 *	Loads a template after identifying its engine type.
	 *	If the engine type is known use newTemplate to avoid engine type detection.
	 *	@access		public
	 *	@param		string		$fileName		File name of template within set template path
	 *	@param		array		$data			Map of template pairs
	 *	@return		CMM_TEA_Adapter_Abstract
	 *	@throws		RuntimeException	if no engine type could be identified
	 */
	public function getTemplate( $fileName, $data = NULL ){
		$type	= $this->identifyType( $fileName );
		$type	= $type ? $type : $this->defaultType;
		if( !$type )
			throw new RuntimeException( 'No engine identified or set' );
		return $this->newTemplate( $type, $fileName, $data );
	}

	public function hasEngine( $type ){
		return array_key_exists( $type, $this->engines );
	}
	
	/**
	 *	Checks engine settings.
	 *	Tries to load engine from file or registers an autoloader for a path.
	 *	Notes ready state of engine and skips on a second run.
	 *	@access		protected
	 *	@param		string		$type		Engine type key
	 *	@return		void
	 *	@throws		RuntimeException	if engine type is unknown
	 *	@throws		RuntimeException	if engine is not enabled
	 */
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

	/**
	 *	Loads a template of a known engine type.
	 *	@access		public
	 *	@param		string		$type			Engine type key, case sensitive, see engines.ini
	 *	@param		string		$fileName		File name of template within set template path
	 *	@param		array		$data			Map of template pairs
	 *	@return		CMM_TEA_Adapter_Abstract
	 */
	public function newTemplate( $type, $fileName = NULL, $data = NULL ){
		$this->initializeEngine( $type );
		$className	= 'CMM_TEA_Adapter_'.$type;
		$reflection	= new ReflectionClass( $className );
		$template	= $reflection->newInstanceArgs( array( $this ) );
		$template->setSourcePath( $this->pathTemplates );
		if( $this->pathCache )
			$template->setCachePath( $this->pathCache );
		if( $this->pathCompile )
			$template->setCompilePath( $this->pathCompile );
		if( !empty( $fileName ) )
			$template->setSourceFile( $fileName );
		if( $data )
			$template->setData( $data );
		return $template;
	}

	/**
	 *	Sets path to cache folder.
	 *	@access		public
	 *	@param		string			$path			Path to cache folder
	 *	@return		void
	 */
	public function setCachePath( $path ){
		$this->pathCache	= $path;
	}

	/**
	 *	Sets path to compile folder.
	 *	@access		public
	 *	@param		string			$path			Path to compile folder
	 *	@return		void
	 */
	public function setCompilePath( $path ){
		$this->pathCompile	= $path;
	}

	/**
	 *	Sets default template engine type.
	 *	@access		public
	 *	@param		string			$type			Engine type to set as default
	 *	@return		void
	 */
	public function setDefaultType( $type ){
		if( !array_key_exists( $type, $this->engines ) )
			throw new RuntimeException( 'Engine "'.$type.'" is not available' );
		$this->defaultType	= $type;
	}

	/**
	 *	Sets path to template folder.
	 *	@access		public
	 *	@param		string			$path			Path to template folder
	 *	@return		void
	 */
	public function setTemplatePath( $path ){
		$this->pathTemplates	= $path;
	}
}
?>