<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';

function sample1(): void
{
    echo "使用母版创建幻灯片页面\n";
    $ppt = \Imoing\Pptx\Presentation::create();

    $titleSlideLayout = $ppt->getSlideLayouts()->item(0);
    $slide = $ppt->slides->addSlide($titleSlideLayout);
    $title = $slide->shapes->title;
    $subtitle = $slide->placeholders[1];
    $title->text = '你好!';
    $subtitle->text = 'php pptx where here';
    $ppt->save("1.pptx");
}

function sample2(): void
{
    $ppt = \Imoing\Pptx\Presentation::create("./t1.pptx");
    foreach ($ppt->slideLayouts as $idx => $layout) {
        /**
         * @var \Imoing\Pptx\Slide\SlideLayout $layout
         */

        foreach ($layout->iterClonablePlaceholders() as $placeholder) {
            $phType = $placeholder->placeholderFormat->getType();
            var_dump($phType->getXmlValue());
        }

        echo sprintf("母版%d: %s 占位数量: %d\n", $idx, $layout->name, count($layout->placeholders));
    }
}

function sample3()
{
    $ppt = \Imoing\Pptx\Presentation::load("./t1.pptx");
    $tpl = [
        'slides' => [],
    ];
    foreach ($ppt->slideLayouts as $idx => $layout) {
        $tpl['slides'][] = $layout->iterClonablePlaceholders();
    }
}
sample1();



