<?php

class SearchCest
{
    public function videoPreviewTest(AcceptanceTester $I)
    {
        // $I->amOnPage('/video/search?text=ураган');
        $I->amOnPage('/video');
        // $I->submitForm('.search2', array('text' => 'ураган'));
        $I->fillField('form.search2 input','ураган');
        $I->click('form.search2 button');

        $I->waitForElement('div.thumb-image', 10);
        $I->moveMouseOver('div.thumb-image');
        $I->waitForElementClickable('div.thumb-image video', 5);
        $I->seeElement('div.thumb-image video');

        $video_url = $I->grabAttributeFrom('div.thumb-image video', 'src');
        $I->assertNotFalse(strstr($video_url, '.mp4'), 'The link to the video should contain .mp4');

        $I->makeElementScreenshot('div.thumb-image video', 'before');
        $I->wait(1);
        $I->makeElementScreenshot('div.thumb-image video', 'after');

        $before_image = new Imagick("./tests/_output/debug/before.png");
        $after_image = new Imagick("./tests/_output/debug/after.png");

        $result = $before_image->compareImages($after_image, 1);
        $I->assertNotEquals($result[1], 0, 'Images should be different'); // same images have the difference = 0
    }
}
