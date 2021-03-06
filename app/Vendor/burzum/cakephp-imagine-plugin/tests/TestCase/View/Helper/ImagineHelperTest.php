<?php
/**
 * Copyright 2011-2015, Florian Krämer
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * Copyright 2011-2015, Florian Krämer
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace Burzum\Imagine\Test\TestCase\View\Helper;

use Burzum\Imagine\View\Helper\ImagineHelper;
use Cake\TestSuite\TestCase;
use Cake\Core\Configure;
use Cake\View\View;

/**
 * ImagineHelperTest class
 */
class ImagineHelperTest extends TestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		Configure::write('Imagine.salt', 'this-is-a-nice-salt');
		$controller = null;
		$View = new View($controller);
		$this->Imagine = new ImagineHelper($View);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Imagine);
	}

/**
 * testUrl method
 *
 * @return void
 */
	public function testUrl() {
		$result = $this->Imagine->url(
			[
				'controller' => 'images',
				'action' => 'display',
				1
			],
			false,
			[
				'thumbnail' => [
					'width' => 200,
					'height' => 150
				]
			]
		);
		$expected = '/images/display/1?thumbnail=width%7C200%3Bheight%7C150&hash=69aa9f46cdc5a200dc7539fc10eec00f2ba89023';
		$this->assertEquals($result, $expected);
	}
  
/**
 * testUrl method for backward compatibility
 *
 * @return void
 */
	public function testUrlBackwardCompatibility() {
		$param1 = [
			'controller' => 'Images',
			'action' => 'display',
			1
		];
		$param2 = false;
		$param3 = [
			'thumbnail' => [
				'width' => 200,
				'height' => 150
			]
		];

		$result1 = $this->Imagine->url($param1, $param2, $param3);
		$result2 = $this->Imagine->url($param1, $param3, $param2);
		$this->assertEquals($result1, $result2);
	}

/**
 * testHash method
 *
 * @return void
 */
	public function testHash() {
		$options = $this->Imagine->pack([
				'thumbnail' => [
					'width' => 200,
					'height' => 150
				]
			]
		);
		$result = $this->Imagine->hash($options);
		$this->assertEquals($result, '69aa9f46cdc5a200dc7539fc10eec00f2ba89023');
	}

/**
 * testHash method
 *
 * @expectedException Exception
 * @return void
 */
	public function testMissingSaltForHash() {
		Configure::write('Imagine.salt', null);
		$this->Imagine->hash('foo');
	}

/**
 * testUrl method
 *
 * @return void
 */
	public function testPack() {
		$result = $this->Imagine->pack([
				'thumbnail' => [
					'width' => 200,
					'height' => 150
				]
			]
		);

		$this->assertEquals($result, ['thumbnail' => 'width|200;height|150']);
	}

}
