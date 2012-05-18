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

namespace Ez\i18n;

abstract class AbstractLocale
{
	/**
	 * @var string
	 */
	protected static $direction;
	
	/**
	 * @var string
	 */
	protected static $floatDirection;
	
	/**
	 * @var string
	 */
	protected static $floatOppositeDirection;
	
	/**
	 * Returns the direction of the locale.
	 * This can be "rtl" either "ltr"
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getDirection()
	{
		return self::$direction;
	}
	
	/**
	 * Returns the float direction of the locale.
	 * It is "right" for ltr locales.
	 * It is "left" for rtl locales.
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getFloatDirection()
	{
		return self::$floatDirection;
	}
	
	/**
	 * Returns the opposite float direction of the locale.
	 * It is "right" for rtl locales.
	 * It is "left" for ltr locales.
	 * 
	 *  @author	Mehdi Bakhtiari
	 *  @return	string
	 */
	public function getFloatOppositeDirection()
	{
		return self::$floatOppositeDirection;
	}
}