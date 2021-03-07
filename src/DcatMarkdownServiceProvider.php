<?php

namespace Ghost\Markdown;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Form;
use Ghost\Markdown\Form\Markdown;

class DcatMarkdownServiceProvider extends ServiceProvider
{

	public function init()
	{
		parent::init();

        Form::extend('markdown', Markdown::class);

	}
}
