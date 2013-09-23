<?php

namespace Tests\Unit\SubPageList\UI\PageRenderer;

use SubPageList\Page;
use SubPageList\UI\PageRenderer\LinkingPageRenderer;
use SubPageList\UI\PageRenderer\PlainPageRenderer;
use Title;

/**
 * @covers SubPageList\UI\PageRenderer\LinkingPageRenderer
 *
 * @group SubPageList
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LinkingPageRendererTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider renderProvider
	 */
	public function testRenderPage( Page $page, $expected ) {
		$basicRenderer = $this->getMock( 'SubPageList\UI\PageRenderer\PageRenderer' );

		$basicRenderer->expects( $this->once() )
			->method( 'renderPage' )
			->with( $this->equalTo( $page ) )
			->will( $this->returnCallback( function( Page $page ) {
				return $page->getTitle()->getSubpageText();
			} ) );

		$renderer = new LinkingPageRenderer( $basicRenderer );

		$actual = $renderer->renderPage( $page );

		$this->assertEquals( $expected, $actual );
	}

	public function renderProvider() {
		return array(
			array(
				new Page( Title::newFromText( 'AAA' ) ),
				'[[AAA|AAA]]',
			),
			array(
				new Page( Title::newFromText( 'AAA/BBB' ) ),
				'[[AAA/BBB|BBB]]',
			),
			array(
				new Page( Title::newFromText( 'Foo:Bar' ) ),
				'[[Foo:Bar|Foo:Bar]]',
			),
			array(
				new Page( Title::newFromText( 'Foo:Bar/Baz' ) ),
				'[[Foo:Bar/Baz|Baz]]',
			),
		);
	}

}
