function AjaxForm()
{
	this.form = null;
	this.successURI = null;
	this.successFunc = null;
	this.messagePane = null;
	this.response = null;
	this.successMessageOnForm = null;
}

AjaxForm.prototype.setFormId = function ( id )
{
	if ( $( "form[id='" + id + "']" ).length > 0 )
	{
		this.form = $( "form[id='" + id + "']" );
	}
	else
	{
		throw new Error( "No form exists with ID " + id );
	}
};

AjaxForm.prototype.submit = function ( callback )
{
	if ( this.form == null )
	{
		throw new Error( "The form to submit has not been identified." );
	}

	$.ajax( {
		instance:this,
		url     :this.form.attr( "action" ),
		type    :this.form.attr( "method" ),
		data    :this.form.serialize(),
		success :function ( response )
		{
			this.instance.processResponse( response );

			if ( callback != undefined && typeof callback == "function" )
			{
				callback();
			}
		}
	} );
};

AjaxForm.prototype.processResponse = function ( response )
{
	try
	{
		this.response = jQuery.parseJSON( response );
	}
	catch ( e )
	{
		throw new Error( "Cannot parse form submittion response" );
	}

	if ( this.response.status )
	{
		if ( this.successURI != null )
		{
			top.location = this.successURI;
			return;
		}

		if ( this.successMessageOnForm == true )
		{
			this.showSuccessMessageOnForm();
			this.messagePane.remove();

			if ( this.successFunc != null )
			{
				this.successFunc( response );
				return;
			}

			return;
		}

		if ( this.successFunc != null )
		{
			this.successFunc( response );
			return;
		}

		this.showSuccessMessage();
		this.highlightFields( this.response );
	}
	else
	{
		this.prepareErrorListPane();
		this.showErrorMessages( this.response.messages );
		this.highlightFields( this.response );
	}
};

AjaxForm.prototype.prepareErrorListPane = function ()
{
	if ( this.messagePane == null )
	{
		throw new Error( "Error messages pane has not been specified." );
	}

	this.messagePane
		.css( {
			"border"     :"1px #FF6600 solid",
			"background" :"#F8F8F8",
			"color"      :"#FF0000",
			"padding"    :"5px",
			"font-weight":"400"
		} )
		.attr( "class",
		"roundedBy5Radius" );
};

AjaxForm.prototype.showErrorMessages = function ( messages )
{
	this.messagePane.html( "" );
	this.messagePane.append( $( "<ul></ul>" ) );

	for ( var i = 0; i < messages.length; i++ )
	{
		this.messagePane.children( "ul:first" ).append(
			$( "<li></li>" )
				.html( messages[i].message )
		);
	}
};

AjaxForm.prototype.highlightFields = function ( response )
{
	var i;

	if ( response.messages != undefined )
	{
		for ( i = 0; i < response.messages.length; i++ )
		{
			if ( $( response.messages[i].cssSelector ).length > 0 )
			{
				$( response.messages[i].cssSelector ).css( {
					"border-color":"#FF6600"
				} );
			}
		}
	}

	for ( i = 0; i < response.fineFields.length; i++ )
	{
		if ( $( response.fineFields[i] ).length > 0 )
		{
			$( response.fineFields[i] ).css( {
				"border-color":"#CCCCCC"
			} );
		}
	}
};

AjaxForm.prototype.setSuccessURI = function ( uri )
{
	this.successURI = uri;
};

AjaxForm.prototype.setSuccessFunc = function ( func )
{
	this.successFunc = func;
};

AjaxForm.prototype.setMessagesPane = function ( pane, fixed )
{
	this.messagePane = pane;

	if ( fixed == true )
	{
		this.messagePane.css( "position",
			"fixed" );
	}
};

AjaxForm.prototype.showSuccessMessage = function ()
{
	this.readyMessagePaneForSuccessMessage();
	this.messagePane.text( this.response.message );
};

AjaxForm.prototype.readyMessagePaneForSuccessMessage = function ()
{
	this.messagePane
		.css( {
			"border"     :"1px #3399cc solid",
			"background" :"#F8F8F8",
			"color"      :"#3399cc",
			"padding"    :"15px",
			"font-size"  :"14px",
			"text-align" :"justify",
			"font-weight":"900"
		} )
		.attr( "class",
		"roundedBy5Radius" )
		.html( "" );
};

AjaxForm.prototype.showSuccessMessageOnForm = function ()
{
	var wrapper = $( "<div></div>" )
		.css( {
			"color"     :"#3399cc",
			"background":"#FFFFFF",
			"margin"    :"15px",
			"padding"   :"15px",
			"border"    :"1px #3399cc solid"
		} )
		.attr( "class", "roundedBy5Radius" )
		.text( this.response.message );

	this.form.wrap( wrapper );
	this.form.remove();
};