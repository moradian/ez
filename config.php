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

///////////////////////////////
// DETERMINING THE ROOT PATH //
///////////////////////////////

$rootPath = realpath( __DIR__ );

////////////////////////////////////////
// SETTING APPLICATION WIDE CONSTANTS //
////////////////////////////////////////

define( "PUBLIC_PATH"			, $rootPath . "/client/" );
define( "ROOT_PATH"				, $rootPath );
define( "PATH_TO_TEMPLATES"		, ROOT_PATH . "/templates/" );
define( "PATH_TO_VIEWS"			, ROOT_PATH . "/views/" );
define( "PATH_TO_CONTROLLERS"	, ROOT_PATH . "/controllers/" );
define( "PATH_TO_CACHE"			, ROOT_PATH . "/cache/" );
define( "PATH_TO_TRANSLATIONS"	, ROOT_PATH . "/translations/" );
define( "PATH_TO_CONFIGS"	    , ROOT_PATH . "/configs/" );
define( "PATH_TO_LIBRARY"		, ROOT_PATH . "/library/" );
define( "PATH_TO_LOGS"			, ROOT_PATH . "/logs/" );

require_once PATH_TO_LIBRARY . "/Ez/Autoloader.php";

Ez\Autoloader::addPath( PATH_TO_LIBRARY );
Ez\Autoloader::register();