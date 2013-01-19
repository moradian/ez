function DataPoster()
{
	this.form = null;
}

DataPoster.prototype.post = function ()
{
	$( document.body ).append( this.form );
	this.form.trigger( "submit" );
};

DataPoster.prototype.setupForm = function ( URI, method )
{
	this.form = $( "<form></form>" ).attr( {
			"action":URI,
			"method":method
		} );
};

DataPoster.prototype.setData = function ( data )
{
	if( this.form == null )
	{
		throw new Error( "You should setup the form before setting up the data." );
	}

	for( i = 0; i < data.length; i++ )
	{
		this.form.append( $( "<input/>" ).attr( "type", "hidden" ).attr( "name", data[i].name ).val( data[i].value ) );
	}
};

DataPoster.prototype.addData = function ( name, value )
{
	this.setData( [
		{"name":name, "value":value}
	] );
};