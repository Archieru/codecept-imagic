<?php

class SearchCest
{
    public function videoPreviewTest(AcceptanceTester $I)
    {
        $mainSearch = 'form.search2 ';
        $videoPreview = 'div.thumb-image';
        $videoPlaying = $videoPreview.' video';

        // $I->amOnPage('/video/search?text=ураган');
        $I->amOnPage('/video');
        // $I->submitForm('.search2', array('text' => 'ураган'));
        $I->fillField($mainSearch.'input','ураган');
        $I->click($mainSearch.'button');

        $I->waitForElementClickable($videoPreview, 10);
        $I->moveMouseOver($videoPreview);
        $I->waitForElementClickable($videoPlaying, 5);
        $I->seeElement($videoPlaying);

        $videoUrl = $I->grabAttributeFrom($videoPlaying, 'src');
        $I->assertNotFalse(strstr($videoUrl, '.mp4'), 'The link to the video should contain .mp4');

        $I->makeElementScreenshot($videoPlaying, 'before');
        $I->wait(1);
        $I->makeElementScreenshot($videoPlaying, 'after');

        $before = new Imagick(codecept_output_dir()."/debug/before.png");
        $after = new Imagick(codecept_output_dir()."/debug/after.png");

        $difference = $before->compareImages($after, 1);
        $I->assertNotEquals($difference[1], 0, 'Images should be different'); // same images have the difference = 0
    }
}
