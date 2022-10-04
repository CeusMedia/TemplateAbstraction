<?php
declare(strict_types=1);

/**
 *	Adapter for phpHaml template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 *	@see			https://haml.info/docs/yardoc/file.REFERENCE.html Templating Guide
 *	@see			https://github.com/kriss0r/phphaml @GitHub
 */

namespace CeusMedia\TemplateAbstraction\Adapter;

use CeusMedia\TemplateAbstraction\AdapterAbstract;
use HamlParser as HamlEngine;
use RuntimeException;

/**
 *	Adapter for phpHaml template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class phpHaml extends AdapterAbstract
{
	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 *	@throws		RuntimeException		if no source file has been set
	 */
	public function render(): string
	{
		if( NULL === $this->sourceFile )
			throw new RuntimeException( 'No source file set' );
		$engine	= new HamlEngine( $this->sourcePath, $this->pathCache );
		$engine->append( $this->data );
		$content	= $engine->fetch( $this->sourceFile );
		return $this->removeTypeIdentifier( $content );
	}
}
