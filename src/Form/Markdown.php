<?php

namespace Ghost\Markdown\Form;

use Dcat\Admin\Admin;
use Dcat\Admin\Form\Field;
use Dcat\Admin\Form\Field\Editor;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Support\JavaScript;
use Illuminate\Support\Str;

class Markdown extends Field
{
    /**
     * 编辑器配置.
     *
     * @var array
     */
    protected $options = [
        'height'        => 500,
        'iconlibrary'   => 'fa',
        'autofocus'     => false,
        'savable'       => false,

    ];

    protected static $js = [
        '@extension/ghost/dcat-markdown/js/bootstrap-markdown.js',
        '@extension/ghost/dcat-markdown/js/dropzone.js',
        '@extension/ghost/dcat-markdown/js/markdown.js',
        '@extension/ghost/dcat-markdown/js/Parser.js',
    ];

    protected static $css = [
        '@extension/ghost/dcat-markdown/css/bootstrap-markdown.min.css',
        '@extension/ghost/dcat-markdown/css/markdown.css',
    ];

    protected $language;

    protected $defaultLangs = [
        'zh_CN'     => '@extension/ghost/dcat-markdown/js/locale/bootstrap-markdown.zh.js',
        'zh_TW'     => '@extension/ghost/dcat-markdown/js/locale/bootstrap-markdown.zh-tw.js',
    ];

    protected $view = 'ghost.dcat-markdown::markdown';

    protected $imageUploadDirectory = 'ghost/markdown';

    /**
     * @var string
     */
    protected $disk;

    /**
     * @param string $disk
     *
     * @return $this
     */
    public function disk(string $disk): Markdown
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * 开启 HTML 标签解析.
     * style,script,iframe|on*.
     *
     * @param string $decode
     *
     * @return \Ghost\Markdown\Form\Markdown
     */
    public function htmlDecode($decode)
    {
        $this->options['htmlDecode'] = &$decode;

        return $this;
    }


    /**
     * 设置编辑器容器高度
     * @param $height
     * @return $this
     */
    public function height($height): Markdown
    {
        $this->options['height'] = $height;

        return $this;
    }


    /**
     * @return string
     */
    protected function defaultImageUploadUrl(): string
    {
        return $this->formatUrl(route(admin_api_route_name('ghost-md.upload')));
    }

    /**
     * 设置图片上传文件夹.
     *
     * @param string $dir
     *
     * @return $this
     */
    public function imageDirectory(string $dir): Markdown
    {
        $this->imageUploadDirectory = $dir;

        return $this;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    protected function formatUrl(string $url): string
    {
        return Helper::urlWithQuery($url, [
                'disk' => $this->disk,
                'dir' => $this->imageUploadDirectory,
            ]);
    }

    /**
     * @return string
     */
    public function render(): string
    {

        $this->attribute('id', $id = $this->generateId());


        $this->options['name'] = $this->column;
        $this->options['placeholder'] = $this->placeholder();
        $this->options['id'] = $id;

        if (empty($this->options['imageUploadURL'])) {
            $this->options['imageUploadURL'] = $this->defaultImageUploadUrl();
        }



        $this->requireLang();


        $this->addVariables(['options' => JavaScript::format($this->options)]);

        return parent::render();
    }

    protected function generateId()
    {
        return 'markdown-'.Str::random(8);
    }

    protected function requireLang()
    {
        $locale = config('app.locale');
        list($language) = explode('_',$locale);
        $this->options['language'] = $language;

        if (isset($this->defaultLangs[$locale])) {
            Admin::js($this->defaultLangs[$locale]);

            return;
        }

        if ($this->language) {
            Admin::js($this->language);
        }
    }
}