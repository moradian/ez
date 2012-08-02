<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.ez-project.org>.
 * 
 * Copyright 2011 Mehdi Bakhtiari
 */

namespace Ez\View;

abstract class AbstractView
{
    protected $templateFile;

	protected   $contentFile,
				$encoding,
				$title,
				$request,

				$metaKeywords,
				$metaDescription;

	// THIS ARRAY PROPERTY IS USED TO SET VALUES
	// TO THE VIEW OBJ TO BE USED AND DISPLAYED
	protected	$data				= array();
	public		$JSLibsToInclude	= array();

	static function determineView( $code )
	{
		// THIS METHOD RETURNS THE VIEW CLASS FILE NAME WITHOUT
		// THE THE EXTENSION ".php"

		$archive =	array(	"chidari"			=> "what.is.chidari",
							"faq"				=> "faq",
							"about"				=> "about.us",
							"contact"			=> "contact.us",
							"tos"				=> "terms.of.service",
							"policy"			=> "privacy.policy",
							"manual"			=> "manual.menu",
							"manual-payment"	=> "manual.payment",
							"manual-ads"		=> "manual.ads",
							"manual-chidari"	=> "manual.chidari"
		);

		return	array_key_exists( $code, $archive )
				? $archive[ $code ]
				: null;
	}

	static function determineTemplate( $code )
	{
		// THIS METHOD RETURNS THE TEMPLATE FILE NAME WITHOUT
		// THE THE EXTENSION ".php"

		$archive =	array(	"mehdi"	=> "home" );

		return	array_key_exists( $code, $archive )
				?
				$archive[ $code ]
				:
				null;
	}

	public function setTemplateFile( $file )
	{
		$templateFile = PATH_TO_TEMPLATES . $file . ".php";

		if( file_exists( $templateFile ) )
		{
			$this->templateFile = $templateFile;
		}

		return $this;
	}

	/**
	 * Passes the request object to the view in case it is
	 * going to be accessed within the view
	 *
	 * @author	Mehdi Bakhtiari
	 * @param	\Ez\Request $request
	 * @return	\Ez\View\AbstractView
	 */
	public function setRequest( \Ez\Request $request )
	{
		$this->request = $request;
		return $this;
	}

	public function __set( $key, $value )
	{
		$this->data[ $key ] = $value;
	}

	public function __get( $key )
	{
		if( $key === "request" )
		{
			return $this->request;
		}

		return	array_key_exists( $key, $this->data )
				? $this->data[ $key ]
				: "";
	}

	public function display()
	{
		// THE CONTENT FILE IS INCLUDED FROM INSIDE
		// OF THE TEMPLATE FILE IN THE ITS PROPER PLACE
		if( !strlen( $this->templateFile ) || !strlen( $this->contentFile ) )
		{
			return false;
		}

		// INCLUDE THE TEMPLATE FILE

        include_once $this->templateFile;
	}

	/**
	 * Sets the content file of the view
	 *
	 * @author	Mehdi Bakhtiari
	 * @param	string $file Filename without the .php extension
	 * @return	\Ez\View\AbstractView
	 */
	public function setContentFile( $file )
	{
		if( file_exists( PATH_TO_VIEWS . $file . ".php" ) )
		{
			$this->contentFile = $file . ".php";
		}

		return $this;
	}

	/**
	 * Returns the name of the content file fo the view
	 *
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getContentFile()
	{
		return $this->contentFile;
	}

	/**
	 * Sets the encoding of the view
	 *
	 * @author	Mehdi Bakhtiari
	 * @param	string $encoding
	 * @return	\Ez\View\AbstractView
	 */
	public function setEncoding( $encoding = "UTF-8" )
	{
		$this->encoding = $encoding;
		return $this;
	}

	/**
	 * Returns the content encoding of the view
	 *
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getEncoding()
	{
		return $this->encoding;
	}

	/**
	 * Sets the title of the view
	 *
	 * @author	Mehdi Bakhtiari
	 * @param	string $title
	 * @return	\Ez\View\AbstractView
	 */
	public function setTitle( $title )
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * Returns the title of the view
	 *
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getTitle()
	{
		return $this->title;
	}
}
