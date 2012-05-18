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

namespace Ez;

class Registry
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private static $doctrineEntityManager;
	
	/**
	 * @var array
	 */
	private static $translation;
	
	/**
	 * @author	Mehdi Bakhtiari
	 * @param	\Doctrine\ORM\EntityManager $entityManager
	 * @return	void
	 */
	public static function setDoctrineEntityManager( \Doctrine\ORM\EntityManager $entityManager )
	{
		self::$doctrineEntityManager = $entityManager;
	}
	
	/**
	 * @author	Mehdi Bakhtiari
	 * @return	\Doctrine\ORM\EntityManager
	 */
	public static function getDoctrineEntityManager()
	{
		return self::$doctrineEntityManager;
	}
	
	/**
	 * @author	Mehdi Bakhtiari
	 * @param	array $translation
	 * return	void
	 */
	public static function setTranslation( array $translation )
	{
		self::$translation = $translation;
	}
	
	/**
	 * @author	Mehdi Bakhtiari
	 * @return	array
	 */
	public static function getTranslation()
	{
		return self::$translation;
	}
} 