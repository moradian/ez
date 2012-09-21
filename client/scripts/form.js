function AjaxForm()
{
	this.formId				= null;
	this.form				= null;
	this.successURI			= null;
	this.successFunc		= null;
	this.errorMessagesPane	= null;
	this.response			= null;
}

AjaxForm.prototype.setFormId = function( id )
{
	this.formId = id;

	if( $( "form[id='" + id + "']" ).length > 0 )
	{
		this.form = $( "form[id='" + id + "']" );
	}
	else
	{
		throw new Error( "No form exists with ID " + id );
	}
};

AjaxForm.prototype.submit = function()
{
	if( this.form == null )
	{
		throw new Error( "The form to submit has not been identified." );
	}

	$.ajax( {
		instance : this,
		url      : this.form.attr( "action" ),
		type     : this.form.attr( "method" ),
		data     : this.form.serialize(),
		success  : function( response )
		{
			this.instance.processResponse( response );
		}
	} );
};

AjaxForm.prototype.processResponse = function( response )
{
	try
	{
		this.response = jQuery.parseJSON( response );
	}
	catch( e )
	{
		throw new Error( "Cannot parse form submittion response" );
	}

	if( this.response.status )
	{
		if( this.successURI != null )
		{
			top.location = this.successURI;
		}

		if( this.successFunc != null )
		{
			this.successFunc();
		}
	}
	else
	{
		this.prepareErrorListPane();
		this.showErrorMessages( this.response.messages );
		this.highlightFields( this.response );
	}
};

AjaxForm.prototype.prepareErrorListPane = function()
{
	if( this.errorMessagesPane == null )
	{
		throw new Error( "Error messages pane has not been specified." );
	}

	this.errorMessagesPane
		.css( {
			"border"     : "1px #FF6600 solid",
			"background" : "#F8F8F8",
			"color"      : "#FF0000",
			"padding"    : "10px"
		} )
		.attr( "class", "roundedBy5Radius" );
};

AjaxForm.prototype.showErrorMessages = function( messages )
{
	if( this.errorMessagesPane == null )
	{
		throw new Error( "Error messages pane has not been specified." );
	}

	this.errorMessagesPane.html( "" );
	this.errorMessagesPane.append( $( "<ul></ul>" ) );

	for( var i = 0; i < messages.length; i++ )
	{
		this.errorMessagesPane.children( "ul:first" ).append(
			$( "<li></li>" )
				.html( messages[i].message )
		);
	}
};

AjaxForm.prototype.highlightFields = function( response )
{
	var i;

	for( i = 0; i < response.messages.length; i++ )
	{
		if( $( response.messages[i].cssSelector ).length > 0 )
		{
			$( response.messages[i].cssSelector ).css( {
				"border-color" : "#FF6600"
			} );
		}
	}

	for( i = 0; i < response.fineFields.length; i++ )
	{
		if( $( response.fineFields[i] ).length > 0 )
		{
			$( response.fineFields[i] ).css( {
				"border-color" : "#CCCCCC"
			} );
		}
	}
};

AjaxForm.prototype.setSuccessURI = function( uri )
{
	this.successURI = uri;
};

AjaxForm.prototype.setSuccessFunc = function( func )
{
	this.successFunc = func;
};

AjaxForm.prototype.setErrorMessagesPane = function( pane )
{
	this.errorMessagesPane = pane;
};
