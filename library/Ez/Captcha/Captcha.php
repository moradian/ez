<?php
/*
 * Copyright 2011 Mehdi Bakhtiari
 * 
 * THIS SOFTWARE IS A FREE SOFTWARE AND IS PROVIDED BY THE COPYRIGHT HOLDERS
 * AND CONTRIBUTORS "AS IS".YOU CAN USE, MODIFY OR REDISTRIBUTE IT UNDER THE
 * TERMS OF "GNU LESSER	GENERAL PUBLIC LICENSE" VERSION 3. YOU SHOULD HAVE
 * RECEIVED A COPY OF FULL TEXT OF LGPL AND GPL SOFTWARE LICENCES IN ROOT OF
 * THIS SOFTWARE LIBRARY. THIS SOFTWARE HAS BEEN DEVELOPED WITH THE HOPE TO
 * BE USEFUL, BUT WITHOUT ANY WARRANTY. IN NO EVENT SHALL THE COPYRIGHT OWNER
 * OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS;
 * OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
 * WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
 * OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
 * ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * THIS SOFTWARE IS LICENSED UNDER THE "GNU LESSER PUBLIC LICENSE" VERSION 3.
 * FOR MORE INFORMATION PLEASE REFER TO <http://www.ez-project.org>
 */

namespace Ez\Captcha;

class Captcha
{
    private	$image,
        $imageWidth,
        $imageHeight,
        $font,
        $fontSize,
        $noiseCount,
        $string,
        $quality;

    public function __construct( $string, $width = 150, $height = 50 )
    {
        $this->string	= $string;
        $this->image	= imagecreate( $width, $height );

        $this->imageWidth	= $width;
        $this->imageHeight	= $height;

        $this->setTextProperties();
        $this->setImageProperties();
    }

    public function setTextProperties( $fontSize = 15, $fontFace = "/times.ttf" )
    {
        $this->fontSize	= $fontSize;
        $this->font	= $fontFace;
    }

    public function setImageProperties( $NoiseCount = 100, $ImageQuality = 25 )
    {
        $this->noiseCount	= $NoiseCount;
        $this->quality		= $ImageQuality;
    }

    public function outputCaptcha()
    {
        $randomColor	= rand( 150, 180 );
        $color		    = imagecolorallocate( $this->image, $randomColor, $randomColor, $randomColor );

        // SET THE BACKGROUND COLOR
        imagefill(
            $this->image,
            0,
            0,
            imagecolorallocate( $this->image, 255, 255, 255 )
        );

        // DRAW NOISE PIXELS ON THE CAPTCHA IAMGE
        $this->drawNoisePixels( $color );

        // DRAW NOISE LINES ON THE CAPTCHA IMAGE
        $this->drawNoiseLines( $color );

        // DRAWING THE CAPTCHA SRTING
        $this->drawCaptchaString( $color );

        // DO THE JOB! OUTPUT CAPTCHA IMAGE
        imagejpeg( $this->image, null, $this->quality );
        imagedestroy( $this->image );
    }

    private function drawNoisePixels( $color )
    {
        for( $i = 0; $i < $this->noiseCount; $i++ )
        {
            $RandomX = rand( 0, $this->imageWidth );
            $RandomY = rand( 0, $this->imageHeight );

            imagesetpixel( $this->image, $RandomX, $RandomY, $color );
        }
    }

    private function drawNoiseLines( $color )
    {
        define( "LINE_NOISE_COUNT", 4 );

        $RandomX_1 = null;
        $RandomY_1 = null;

        for( $i = 0; $i < LINE_NOISE_COUNT; $i++ )
        {
            if( empty( $RandomX_1 ) )
            {
                $RandomX_1 = rand( 0, $this->imageWidth * ( $i + 1 ) / LINE_NOISE_COUNT );
                $RandomY_1 = rand( 0, $this->imageHeight );

                continue;
            }

            $RandomX_2 = rand( ( $this->imageWidth * ( $i + 1 ) / LINE_NOISE_COUNT ), ( $this->imageWidth * ( $i + 2 ) / LINE_NOISE_COUNT ) );
            $RandomY_2 = rand( 0, $this->imageHeight );

            imageline( $this->image, $RandomX_1, $RandomY_1, $RandomX_2, $RandomY_2, $color );

            $RandomX_1 = $RandomX_2;
            $RandomY_1 = $RandomY_2;
        }
    }

    private function drawCaptchaString( $color )
    {
        $len = strlen($this->string);

        for( $i = 0; $i < $len; $i++ )
        {
            // GENERATE A RANDOM ANGLE FOR EACH
            // CHARACTER OF THE CAPTCHA STRING
            $angle		= rand( -35, 35 );
            $SizeQuerter	= ( int ) $this->fontSize / 4;
            $size		= rand(	$this->fontSize - $SizeQuerter,
                        $this->fontSize + $SizeQuerter
            );

            // CALCULATE THE CURRENT CHARACTER'S
            // X POSITION ON THE CAPTCHA IMAGE
            $StartX =	floor( $this->imageWidth / 2 )	-
                    floor( $len / 2 )		*
                    $this->fontSize			+
                    ( $this->fontSize * $i )	+
                    rand( -3, 3 );

            $StartX = ( ( $StartX * 4 ) / 5 );

            // CALCULATE THE CURRENT CHARACTER'S
            // Y POSITION ON THE CAPTCHA IMAGE
            $StartY	= rand(	floor( $this->fontSize * 1.5 ),
                    $this->imageHeight - $this->fontSize
            );

            // SETTLE DOWN THE CURRENT CHARACTER
            // ON THE CAPTCHA IMAGE
            imagefttext(	$this->image,
                    $size,
                    $angle,
                    $StartX,
                    $StartY,
                    $color,
                    $this->font,
                    $this->string[ $i ]
            );
        }
    }
}