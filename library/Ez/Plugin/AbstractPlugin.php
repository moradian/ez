<?php

namespace Ez\Plugin;

abstract class AbstractPlugin
{
	abstract public function preDispatch( \Ez\Request $request );
	abstract public function postDispatch( \Ez\Request $request );
}