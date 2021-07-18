<?php
/**
 *	Interface for each template engine in factory.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
namespace CeusMedia\TemplateAbstraction;

/**
 *	Interface for each template engine in factory.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
interface AdapterInterface
{
	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		Factory			$factory		TEA factory instance
	 */
	public function __construct( Factory $factory );

	/**
	 *	Assigns context data for template.
	 *	@access		public
	 *	@param		string			$key			Data pair key
	 *	@param		mixed			$value			Data pair value
	 *	@param		boolean			$force			Flag: override existing data pair
	 *	@return		AdapterAbstract
	 */
	public function addData( string $key, $value, bool $force = FALSE ): AdapterAbstract;

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(): string;

	/**
	 *	Sets path to compile folder.
	 *	@access		public
	 *	@param		string			$path			Path to cache folder
	 *	@return		AdapterAbstract
	 */
	public function setCachePath( string $path ): AdapterAbstract;

	/**
	 *	Sets path to cache or compile folder.
	 *	@access		public
	 *	@param		string			$path			Path to compile folder
	 *	@return		AdapterAbstract
	 */
	public function setCompilePath( string $path ): AdapterAbstract;

	/**
	 *	Assigns a map of context data for template.
	 *	@access		public
	 *	@param		array			$map			Map of context data pairs
	 *	@param		boolean			$force			Flag: override existing data pair
	 *	@return		AdapterAbstract
	 */
	public function setData( array $map, bool $force = FALSE ): AdapterAbstract;

	/**
	 *	Sets name of template file in template folder.
	 *	@access		public
	 *	@param		string			$fileName		Name of template file in template folder
	 *	@return		AdapterAbstract
	 */
	public function setSourceFile( string $fileName ): AdapterAbstract;

	/**
	 *	Sets path to template folder.
	 *	@access		public
	 *	@param		string			$path			Path to template folder
	 *	@return		AdapterAbstract
	 */
	public function setSourcePath( string $path ): AdapterAbstract;

	/**
	 *	Sets template content by string.
	 *	@access		public
	 *	@param		string			$string			Template content
	 *	@return		AdapterAbstract
	 */
	public function setSourceString( string $string ): AdapterAbstract;
}
